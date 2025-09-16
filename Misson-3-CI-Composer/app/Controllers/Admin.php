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

    // ===== COURSE MANAGEMENT =====
    public function courses()
    {
        $model = new User_model();
        $data['title'] = 'Kelola Courses';
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
        $rules = [
            'kode_mk' => 'required|min_length[3]|is_unique[biodata.nim]',
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

        // Format data course dalam JSON untuk kolom enrolled_courses
        $courseData = [
            'sks' => $this->request->getPost('sks'),
            'kuota' => $this->request->getPost('kuota'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        $data = [
            'nim' => $this->request->getPost('kode_mk'), // nim digunakan sebagai kode_mk
            'nama_lengkap' => $this->request->getPost('nama_mk'), // nama_lengkap sebagai nama_mk
            'jurusan' => $this->request->getPost('dosen'), // jurusan sebagai dosen
            'semester' => $this->request->getPost('semester'),
            'role' => 'course',
            'enrolled_courses' => json_encode($courseData),
            'status' => 'active',
            'email' => 'course@kampus.ac.id'
        ];

        if ($model->insert($data)) {
            return redirect()->to('/admin/courses')->with('success', 'Course berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menambah course!');
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

    // ===== STUDENT MANAGEMENT =====
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
}
