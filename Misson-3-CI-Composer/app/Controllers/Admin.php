<?php
// App/Controllers/Admin.php - UNTUK MENGELOLA COURSES DAN STUDENTS
namespace App\Controllers;

use App\Models\User_model;

class Admin extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
        // Cek apakah user sudah login dan role admin
        if (!$this->session->get('logged_in') || $this->session->get('role') != 'admin') {
            header('Location: ' . base_url('auth/login'));
            exit();
        }
    }

    // ===== COURSE MANAGEMENT (Kode yang sudah ada) =====
    public function courses()
    {
        $model = new User_model();
        $data['title'] = 'Kelola Courses';

        // Ambil data courses
        $data['courses'] = $model->getCourses();


        $data['content'] = view('admin/courses', $data);

        return view('layout_dashboard', $data);
    }

    public function addCourse()
    {
        $data['title'] = 'Tambah Course';
        $data['content'] = view('admin/add_course');

        return view('layout_dashboard', $data);
    }

    public function storeCourse()
    {
        // Perbarui rules validasi
        $rules = [
            'kode_mk' => 'required|min_length[3]',
            'nama_mk' => 'required|min_length[3]',
            'dosen' => 'required',
            'semester' => 'required|integer',
            'sks' => 'required|integer|greater_than[0]',
            'kuota' => 'required|integer|greater_than[0]',
            'deskripsi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new User_model();

        // Pastikan kode_mk selalu unik dengan menambahkan prefiks
        $kode_mk_unik = 'MK-' . $this->request->getPost('kode_mk');

        $courseData = [
            'sks' => $this->request->getPost('sks'),
            'kuota' => $this->request->getPost('kuota'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        $data = [
            'nim' => $kode_mk_unik,
            'nama_lengkap' => $this->request->getPost('nama_mk'),
            'jurusan' => $this->request->getPost('dosen'),
            'semester' => $this->request->getPost('semester'),
            'role' => 'course',
            'enrolled_courses' => json_encode($courseData),
            'status' => 'active',
            'email' => 'course@kampus.ac.id',
            'password' => password_hash('default_password', PASSWORD_DEFAULT)
        ];

        try {
            // Cek apakah kode MK sudah ada
            $existingCourse = $model->where('nim', $kode_mk_unik)->first();
            if ($existingCourse) {
                return redirect()->back()->withInput()->with('error', 'Kode mata kuliah sudah ada!');
            }

            // Insert data - method insert() mengembalikan inserted ID atau false
            $insertResult = $model->insert($data);

            if ($insertResult !== false) {
                return redirect()->to('/admin/courses')->with('success', 'Course berhasil ditambahkan!');
            } else {
                // Log error untuk debugging
                log_message('error', 'Failed to insert course: ' . json_encode($model->errors()));
                return redirect()->back()->withInput()->with('error', 'Gagal menambahkan course: ' . implode(', ', $model->errors()));
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in storeCourse: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    public function editCourse($nim)
    {
        $model = new User_model();
        $course = $model->where('nim', $nim)->where('role', 'course')->first();

        if (!$course) {
            return redirect()->to('/admin/courses')->with('error', 'Course tidak ditemukan!');
        }

        $data['title'] = 'Edit Course';
        $data['course'] = $course;
        $data['course_detail'] = json_decode($course['enrolled_courses'], true);
        $data['content'] = view('admin/edit_course', $data);

        return view('layout_dashboard', $data);
    }

    public function updateCourse($nim)
    {
        $rules = [
            'nama_mk' => 'required|min_length[3]',
            'dosen' => 'required',
            'semester' => 'required|integer',
            'sks' => 'required|integer|greater_than[0]',
            'kuota' => 'required|integer|greater_than[0]',
            'deskripsi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new User_model();

        $courseData = [
            'sks' => $this->request->getPost('sks'),
            'kuota' => $this->request->getPost('kuota'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_mk'),
            'jurusan' => $this->request->getPost('dosen'),
            'semester' => $this->request->getPost('semester'),
            'enrolled_courses' => json_encode($courseData)
        ];

        if ($model->update($nim, $data)) {
            return redirect()->to('/admin/courses')->with('success', 'Course berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate course!');
        }
    }

    public function deleteCourse($nim)
    {
        $model = new User_model();

        if ($model->where('nim', $nim)->where('role', 'course')->delete()) {
            return redirect()->to('/admin/courses')->with('success', 'Course berhasil dihapus!');
        } else {
            return redirect()->to('/admin/courses')->with('error', 'Gagal menghapus course!');
        }
    }

    // ===== STUDENT MANAGEMENT (Kode yang sudah ada) =====
    public function students()
    {
        $model = new User_model();
        $data['title'] = 'Kelola Students';
        $data['students'] = $model->getStudents();
        $data['content'] = view('admin/students', $data);

        return view('layout_dashboard', $data);
    }

    public function viewStudent($nim)
    {
        $model = new User_model();
        $student = $model->where('nim', $nim)->where('role', 'student')->first();

        if (!$student) {
            return redirect()->to('/admin/students')->with('error', 'Student tidak ditemukan!');
        }

        $data['title'] = 'Detail Student';
        $data['student'] = $student;
        $data['enrolled_courses'] = $model->getStudentEnrollments($nim);
        $data['content'] = view('admin/view_student', $data);

        return view('layout_dashboard', $data);
    }
    
    // ===== ENROLLMENT MANAGEMENT (Fungsi Baru) =====
    public function manageEnrollment($nim)
    {
        $model = new User_model();
        $student = $model->where('nim', $nim)->where('role', 'student')->first();

        if (!$student) {
            return redirect()->to('/admin/students')->with('error', 'Student tidak ditemukan!');
        }

        $data['title'] = 'Kelola Enrollment untuk ' . $student['nama_lengkap'];
        $data['student'] = $student;
        $data['enrolled_courses'] = $model->getStudentEnrollments($nim);
        $data['all_courses'] = $model->getCourses();
        $data['content'] = view('admin/manage_enrollment', $data);

        return view('layout_dashboard', $data);
    }

    public function enroll($studentNim, $courseCode)
    {
        $model = new User_model();
        if ($model->enrollCourse($studentNim, $courseCode)) {
            return redirect()->to('/admin/manageEnrollment/' . $studentNim)->with('success', 'Mahasiswa berhasil di-enroll!');
        } else {
            return redirect()->to('/admin/manageEnrollment/' . $studentNim)->with('error', 'Gagal melakukan enrollment. Mungkin sudah terdaftar.');
        }
    }

    public function unenroll($studentNim, $courseCode)
    {
        $model = new User_model();
        if ($model->unenrollCourse($studentNim, $courseCode)) {
            return redirect()->to('/admin/manageEnrollment/' . $studentNim)->with('success', 'Mahasiswa berhasil di-unenroll!');
        } else {
            return redirect()->to('/admin/manageEnrollment/' . $studentNim)->with('error', 'Gagal melakukan unenroll. Mungkin tidak terdaftar.');
        }
    }

}