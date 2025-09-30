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

    // ===== COURSE MANAGEMENT  =====
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

    // ===== STUDENT MANAGEMENT (Tradisional) =====
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
        $data['content'] = view('admin/students', $data);

        return view('layout_dashboard', $data);
    }
    public function addStudent()
    {
        $data['title'] = 'Tambah Mahasiswa';
        $data['content'] = view('admin/add_student');

        return view('layout_dashboard', $data);
    }

    public function storeStudent()
    {
        $rules = [
            'nim' => [
                'rules' => 'required|min_length[5]|max_length[20]|is_unique[biodata.nim]',
                'errors' => [
                    'required' => 'NIM harus diisi',
                    'min_length' => 'NIM minimal 5 karakter',
                    'max_length' => 'NIM maksimal 20 karakter',
                    'is_unique' => 'NIM sudah terdaftar'
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi',
                    'min_length' => 'Nama lengkap minimal 3 karakter'
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[4]|is_unique[biodata.username]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'min_length' => 'Username minimal 4 karakter',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[biodata.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak cocok'
                ]
            ],
            'jurusan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jurusan harus diisi'
                ]
            ],
            'semester' => [
                'rules' => 'required|integer|greater_than[0]|less_than[15]',
                'errors' => [
                    'required' => 'Semester harus diisi',
                    'integer' => 'Semester harus berupa angka',
                    'greater_than' => 'Semester harus lebih dari 0',
                    'less_than' => 'Semester tidak valid'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new User_model();

        $data = [
            'nim' => $this->request->getPost('nim'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'jurusan' => $this->request->getPost('jurusan'),
            'semester' => $this->request->getPost('semester'),
            'role' => 'student',
            'enrolled_courses' => json_encode([]),
            'status' => 'active'
        ];

        try {
            $insertResult = $model->insert($data);

            if ($insertResult !== false) {
                return redirect()->to('/admin/students')->with('success', 'Mahasiswa berhasil ditambahkan!');
            } else {
                log_message('error', 'Failed to insert student: ' . json_encode($model->errors()));
                return redirect()->back()->withInput()->with('error', 'Gagal menambahkan mahasiswa: ' . implode(', ', $model->errors()));
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in storeStudent: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    public function editStudent($nim)
    {
        $model = new User_model();
        $student = $model->where('nim', $nim)->where('role', 'student')->first();

        if (!$student) {
            return redirect()->to('/admin/students')->with('error', 'Mahasiswa tidak ditemukan!');
        }

        $data['title'] = 'Edit Mahasiswa';
        $data['student'] = $student;
        $data['content'] = view('admin/edit_student', $data);

        return view('layout_dashboard', $data);
    }

    public function updateStudent($nim)
    {
        $model = new User_model();
        $student = $model->where('nim', $nim)->where('role', 'student')->first();

        if (!$student) {
            return redirect()->to('/admin/students')->with('error', 'Mahasiswa tidak ditemukan!');
        }

        $rules = [
            'nama_lengkap' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi',
                    'min_length' => 'Nama lengkap minimal 3 karakter'
                ]
            ],
            'username' => [
                'rules' => "required|min_length[4]|is_unique[biodata.username,nim,{$nim}]",
                'errors' => [
                    'required' => 'Username harus diisi',
                    'min_length' => 'Username minimal 4 karakter',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => "required|valid_email|is_unique[biodata.email,nim,{$nim}]",
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'jurusan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jurusan harus diisi'
                ]
            ],
            'semester' => [
                'rules' => 'required|integer|greater_than[0]|less_than[15]',
                'errors' => [
                    'required' => 'Semester harus diisi',
                    'integer' => 'Semester harus berupa angka',
                    'greater_than' => 'Semester harus lebih dari 0',
                    'less_than' => 'Semester tidak valid'
                ]
            ]
        ];

        // Validasi password hanya jika diisi
        if ($this->request->getPost('password')) {
            $rules['password'] = [
                'rules' => 'min_length[6]',
                'errors' => [
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ];
            $rules['confirm_password'] = [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'jurusan' => $this->request->getPost('jurusan'),
            'semester' => $this->request->getPost('semester')
        ];

        // Update password jika diisi
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($model->update($nim, $data)) {
            return redirect()->to('/admin/students')->with('success', 'Data mahasiswa berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate data mahasiswa!');
        }
    }

    public function deleteStudent($nim)
    {
        $model = new User_model();

        // Soft delete dengan mengubah status
        if ($model->update($nim, ['status' => 'inactive'])) {
            return redirect()->to('/admin/students')->with('success', 'Mahasiswa berhasil dihapus!');
        } else {
            return redirect()->to('/admin/students')->with('error', 'Gagal menghapus mahasiswa!');
        }
    }
    // ===== StUDENT MANAGEMENT  (AJAX/ no Refresh halaman) =====
    public function storeStudentAjax()
    {
        // Set header JSON
        header('Content-Type: application/json');

        $rules = [
            'nim' => [
                'rules' => 'required|min_length[5]|max_length[20]|is_unique[biodata.nim]',
                'errors' => [
                    'required' => 'NIM harus diisi',
                    'min_length' => 'NIM minimal 5 karakter',
                    'max_length' => 'NIM maksimal 20 karakter',
                    'is_unique' => 'NIM sudah terdaftar'
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi',
                    'min_length' => 'Nama lengkap minimal 3 karakter'
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[4]|is_unique[biodata.username]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'min_length' => 'Username minimal 4 karakter',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[biodata.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak cocok'
                ]
            ],
            'jurusan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jurusan harus diisi'
                ]
            ],
            'semester' => [
                'rules' => 'required|integer|greater_than[0]|less_than[15]',
                'errors' => [
                    'required' => 'Semester harus diisi',
                    'integer' => 'Semester harus berupa angka',
                    'greater_than' => 'Semester harus lebih dari 0',
                    'less_than' => 'Semester tidak valid'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $model = new User_model();

        $data = [
            'nim' => $this->request->getPost('nim'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'jurusan' => $this->request->getPost('jurusan'),
            'semester' => $this->request->getPost('semester'),
            'role' => 'student',
            'enrolled_courses' => json_encode([]),
            'status' => 'active'
        ];

        try {
            $insertResult = $model->insert($data);

            if ($insertResult !== false) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Mahasiswa berhasil ditambahkan!',
                    'data' => $data
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan mahasiswa',
                    'errors' => $model->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in storeStudentAjax: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi error: ' . $e->getMessage()
            ]);
        }
    }

    public function getStudentAjax($nim)
    {
        header('Content-Type: application/json');

        $model = new User_model();
        $student = $model->where('nim', $nim)->where('role', 'student')->first();

        if (!$student) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $student
        ]);
    }

    public function updateStudentAjax($nim)
    {
        header('Content-Type: application/json');

        $model = new User_model();
        $student = $model->where('nim', $nim)->where('role', 'student')->first();

        if (!$student) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ]);
        }

        $rules = [
            'nama_lengkap' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi',
                    'min_length' => 'Nama lengkap minimal 3 karakter'
                ]
            ],
            'username' => [
                'rules' => "required|min_length[4]|is_unique[biodata.username,nim,{$nim}]",
                'errors' => [
                    'required' => 'Username harus diisi',
                    'min_length' => 'Username minimal 4 karakter',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => "required|valid_email|is_unique[biodata.email,nim,{$nim}]",
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'jurusan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jurusan harus diisi'
                ]
            ],
            'semester' => [
                'rules' => 'required|integer|greater_than[0]|less_than[15]',
                'errors' => [
                    'required' => 'Semester harus diisi',
                    'integer' => 'Semester harus berupa angka',
                    'greater_than' => 'Semester harus lebih dari 0',
                    'less_than' => 'Semester tidak valid'
                ]
            ]
        ];

        // Validasi password hanya jika diisi
        if ($this->request->getPost('password')) {
            $rules['password'] = [
                'rules' => 'min_length[6]',
                'errors' => [
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ];
            $rules['confirm_password'] = [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'jurusan' => $this->request->getPost('jurusan'),
            'semester' => $this->request->getPost('semester')
        ];

        // Update password jika diisi
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($model->update($nim, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data mahasiswa berhasil diupdate!',
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengupdate data mahasiswa'
            ]);
        }
    }

    public function deleteStudentAjax($nim)
    {
        header('Content-Type: application/json');

        $model = new User_model();
        $student = $model->where('nim', $nim)->where('role', 'student')->first();

        if (!$student) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ]);
        }

        // Soft delete dengan mengubah status
        if ($model->update($nim, ['status' => 'inactive'])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Mahasiswa berhasil dihapus!',
                'nim' => $nim
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus mahasiswa'
            ]);
        }
    }

    public function getStudentsAjax()
    {
        header('Content-Type: application/json');

        $model = new User_model();
        $students = $model->getStudents();

        return $this->response->setJSON([
            'success' => true,
            'data' => $students
        ]);
    }
    
    // ===== ENROLLMENT MANAGEMENT  =====
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

    //non-refresh version
    public function loadPage($page = 'dashboard')
    {
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $model = new User_model();
        $page = rtrim($page, '/');

        switch ($page) {
            case 'students':
                $data['students'] = $model->getStudents();
                return view('admin/students', $data);

            case 'courses':
                $data['courses'] = $model->getCourses();
                return view('admin/courses', $data);

            case 'dashboard':
                $data['total_students'] = count($model->getStudents());
                $data['total_courses'] = count($model->getCourses());
                return view('admin/dashboard', $data);

            default:
                return '<div class="alert alert-warning">Halaman tidak ditemukan</div>';
        }
    }

}