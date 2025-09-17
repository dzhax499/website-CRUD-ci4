<?php
// App/Controllers/Dashboard.php - DIMODIFIKASI UNTUK TABEL BIODATA
namespace App\Controllers;

use App\Models\User_model;

class Dashboard extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
        // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            header('Location: ' . base_url('auth/login'));
            exit();
        }
    }

    public function index()
    {
        $role = $this->session->get('role');

        if ($role == 'admin') {
            return $this->adminDashboard();
        } else {
            return $this->studentDashboard();
        }
    }

    private function adminDashboard()
    {
        $model = new User_model();

        $data['title'] = 'Admin Dashboard';
        $data['total_courses'] = $model->where('role', 'course')->countAllResults();
        $data['total_students'] = $model->where('role', 'student')->countAllResults();

        // Hitung total enrollment
        $students = $model->getStudents();
        $totalEnrollments = 0;
        foreach ($students as $student) {
            if ($student['enrolled_courses']) {
                $enrolled = json_decode($student['enrolled_courses'], true);
                $totalEnrollments += count($enrolled ?? []);
            }
        }
        $data['total_enrollments'] = $totalEnrollments;

        $data['recent_courses'] = $model->where('role', 'course')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->find();

        $data['content'] = view('dashboard/admin', $data);
        return view('layout_dashboard', $data);
    }

    private function studentDashboard()
    {
        $model = new User_model();

        // Dapatkan data student berdasarkan nim
        $student = $model->where('nim', $this->session->get('user_nim'))->first();

        $data['title'] = 'Student Dashboard';
        $data['student'] = $student;
        $data['available_courses'] = $model->getCourses();
        $data['enrolled_courses'] = $model->getStudentEnrollments($this->session->get('user_nim'));

        $data['content'] = view('dashboard/student', $data);
        return view('layout_dashboard', $data);
    }
}
