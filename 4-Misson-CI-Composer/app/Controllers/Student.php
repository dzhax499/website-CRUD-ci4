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
    // enroll multiple courses
    public function enrollMultiple()
    {
        $model = new User_model();
        $studentNim = $this->session->get('user_nim');
        $selectedCourses = $this->request->getPost('selected_courses') ?? [];

        if (empty($selectedCourses)) {
            return redirect()->back()->with('error', 'Tidak ada mata kuliah yang dipilih!');
        }

        $allCourses = $model->getCourses();
        $courseMap = [];
        foreach ($allCourses as $course) {
            $courseMap[$course['nim']] = $course;
        }

        $enrolledCourses = $model->getStudentEnrollments($studentNim);
        $enrolledCodes = array_column($enrolledCourses, 'nim');

        $successCount = 0;
        $errorMessages = [];

        foreach ($selectedCourses as $courseCode) {
            // Cek apakah course exists
            if (!isset($courseMap[$courseCode])) {
                $errorMessages[] = "Course dengan kode $courseCode tidak ditemukan.";
                continue;
            }

            // Cek apakah sudah enroll
            if (in_array($courseCode, $enrolledCodes)) {
                $errorMessages[] = "Anda sudah terdaftar di course dengan kode $courseCode.";
                continue;
            }

            // Cek kuota
            $courseDetail = json_decode($courseMap[$courseCode]['enrolled_courses'], true);
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
                $errorMessages[] = "Kuota untuk course dengan kode $courseCode sudah penuh.";
                continue;
            }

            // Enroll
            if ($model->enrollCourse($studentNim, $courseCode)) {
                $successCount++;
            } else {
                $errorMessages[] = "Gagal enroll course dengan kode $courseCode.";
            }
        }
        $message = "$successCount mata kuliah berhasil di-enroll.";
        if (!empty($errorMessages)) {
            $message .= ' Namun, beberapa kesalahan terjadi: ' . implode(' ', $errorMessages);
            return redirect()->back()->with('error', $message);
        } 
        return redirect()->back()->with('success', $message);
    }

    // public function enrollMultiple()
    // {
    //     if (!$this->request->isAJAX()) {
    //         return $this->response->setStatusCode(400)
    //             ->setJSON(['success' => false, 'message' => 'Invalid request']);
    //     }

    //     $data = $this->request->getJSON(true);
    //     $courseCodes = $data['courses'] ?? [];
    //     $totalSKS = $data['total_sks'] ?? 0;
    //     $studentNim = $this->session->get('user_nim');

    //     if (empty($courseCodes)) {
    //         return $this->response->setJSON([
    //             'success' => false,
    //             'message' => 'Tidak ada course yang dipilih.'
    //         ]);
    //     }

    //     $model = new User_model();

    //     // Loop enroll semua courses
    //     $success = $model->enrollMultipleCourses($studentNim, $courseCodes);

    //     if ($success) {
    //         return $this->response->setJSON([
    //             'success' => true,
    //             'message' => 'Berhasil enroll ' . count($courseCodes) . ' course. Total SKS: ' . $totalSKS
    //         ]);
    //     } else {
    //         return $this->response->setJSON([
    //             'success' => false,
    //             'message' => 'Sebagian course gagal diproses.'
    //         ]);
    //     }
    // }


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
