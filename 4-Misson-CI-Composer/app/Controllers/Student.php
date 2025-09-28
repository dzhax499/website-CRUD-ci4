<?php
// App/Controllers/Student.php - UNTUK STUDENT ENROLL COURSES
namespace App\Controllers;

use App\Models\User_model;

class Student extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
        // Cek apakah user sudah login dan role student
        if (!$this->session->get('logged_in') || $this->session->get('role') != 'student') {
            header('Location: ' . base_url('auth/login'));
            exit();
        }
    }

    public function courses()
    {
        $model = new User_model();
        $data['title'] = 'Daftar Courses';
        $data['courses'] = $model->getCourses();

        // Cek courses yang sudah diambil
        $enrolledCourses = $model->getStudentEnrollments($this->session->get('user_nim'));
        $enrolledCodes = array_column($enrolledCourses, 'nim');
        $data['enrolled_codes'] = $enrolledCodes;

        $data['content'] = view('student/courses', $data);

        return view('layout_dashboard', $data);
    }

    public function enrollments()
    {
        $model = new User_model();
        $studentNim = $this->session->get('user_nim');

        $data['title'] = 'Mata Kuliah Saya';
        $data['enrolled_courses'] = $model->getStudentEnrollments($studentNim);
        $data['content'] = view('student/enrollments', $data);

        return view('layout_dashboard', $data);
    }

    // MODIFIKASI: Menggabungkan fungsi enroll dan drop dalam satu method
    // Sekarang menangani baik enrollment maupun drop tanpa refresh halaman
    public function enrollMultiple()
    {
        // PERBAIKAN: Debug request untuk melihat masalahnya
        // Sementara hapus validasi AJAX untuk testing
        /*if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'Invalid request']);
        }*/

        // TAMBAHAN: Set response header untuk JSON
        $this->response->setContentType('application/json');

        // PERBAIKAN: Coba ambil data dari POST atau JSON
        $data = $this->request->getJSON(true);
        if (empty($data)) {
            $data = $this->request->getPost();
        }

        // DEBUG: Log data untuk troubleshooting
        log_message('debug', 'Received data: ' . json_encode($data));
        $action = $data['action'] ?? 'enroll'; // TAMBAHAN: Menentukan aksi (enroll/drop)
        $courseCodes = $data['courses'] ?? [];
        $totalSKS = $data['total_sks'] ?? 0;
        $studentNim = $this->session->get('user_nim');

        if (empty($courseCodes)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada course yang dipilih.'
            ]);
        }

        $model = new \App\Models\User_model();

        // MODIFIKASI: Menentukan operasi berdasarkan action
        if ($action === 'enroll') {
            $success = $model->enrollMultipleCourses($studentNim, $courseCodes);
            $message = $success ?
                'Berhasil enroll ' . count($courseCodes) . ' course. Total SKS: ' . $totalSKS :
                'Sebagian course gagal diproses.';
        } else if ($action === 'drop') {
            // TAMBAHAN: Memanggil fungsi untuk drop multiple courses
            $success = $model->dropMultipleCourses($studentNim, $courseCodes);
            $message = $success ?
                'Berhasil drop ' . count($courseCodes) . ' course. Total SKS: ' . $totalSKS :
                'Sebagian course gagal di-drop.';
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Action tidak valid.'
            ]);
        }

        return $this->response->setJSON([
            'success' => $success,
            'message' => $message
        ]);
    }

    // FUNGSI INDIVIDUAL ENROLL (tetap ada untuk keperluan tertentu)
    public function enroll($courseCode)
    {
        $model = new User_model();
        $studentNim = $this->session->get('user_nim');

        // Cek apakah course exists
        $course = $model->where('nim', $courseCode)->where('role', 'course')->first();
        if (!$course) {
            return redirect()->back()->with('error', 'Course tidak ditemukan!');
        }

        // Cek apakah sudah enroll
        $enrolledCourses = $model->getStudentEnrollments($studentNim);
        $enrolledCodes = array_column($enrolledCourses, 'nim');

        if (in_array($courseCode, $enrolledCodes)) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di course ini!');
        }

        // Cek kuota
        $courseDetail = json_decode($course['enrolled_courses'], true);
        $kuota = $courseDetail['kuota'] ?? 0;

        // Hitung jumlah student yang sudah enroll (simplified)
        $allStudents = $model->getStudents();
        $currentEnrolled = 0;
        foreach ($allStudents as $student) {
            if ($student['enrolled_courses']) {
                $studentCourses = json_decode($student['enrolled_courses'], true);
                if (is_array($studentCourses) && in_array($courseCode, $studentCourses)) {
                    $currentEnrolled++;
                }
            }
        }

        if ($currentEnrolled >= $kuota) {
            return redirect()->back()->with('error', 'Kuota course sudah penuh!');
        }

        // Enroll
        if ($model->enrollCourse($studentNim, $courseCode)) {
            return redirect()->back()->with('success', 'Berhasil enroll course: ' . $course['nama_lengkap']);
        } else {
            return redirect()->back()->with('error', 'Gagal enroll course!');
        }
    }

    // FUNGSI INDIVIDUAL UNENROLL (tetap ada untuk keperluan tertentu)
    public function unenroll($courseCode)
    {
        $model = new User_model();
        $studentNim = $this->session->get('user_nim');

        if ($model->unenrollCourse($studentNim, $courseCode)) {
            return redirect()->back()->with('success', 'Berhasil membatalkan enrollment!');
        } else {
            return redirect()->back()->with('error', 'Gagal membatalkan enrollment!');
        }
    }
}
