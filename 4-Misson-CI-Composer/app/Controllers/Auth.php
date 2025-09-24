<?php
namespace App\Controllers;

use App\Models\User_model;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $data['title'] = 'Login - Sistem Akademik';
        $data['content'] = view('auth/login');

        return view('layout_dashboard', $data);
    }

    public function authenticate()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new User_model();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->authenticate($username, $password);

        if ($user) {
            $session_data = [
                'user_nim' => $user['nim'], // Menggunakan nim sebagai primary identifier
                'username' => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role' => $user['role'],
                'logged_in' => TRUE
            ];
            session()->set($session_data);

            return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
        } else {
            return redirect()->back()->with('error', 'Username atau password salah!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Anda telah logout!');
    }

    public function register()
    {
        $data['title'] = 'Register - Sistem Akademik';
        $data['content'] = view('auth/register');

        return view('layout_dashboard', $data);
    }

    public function store()
    {
        $rules = [
            'nim' => 'required|min_length[3]|is_unique[biodata.nim]',
            'nama_lengkap' => 'required|min_length[3]',
            'username' => 'required|min_length[3]|is_unique[biodata.username]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'jurusan' => 'required',
            'email' => 'required|valid_email',
            'semester' => 'required|integer|greater_than[0]|less_than[9]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new User_model();
        $data = [
            'nim' => $this->request->getPost('nim'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jurusan' => $this->request->getPost('jurusan'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'student', // Default role student
            'email' => $this->request->getPost('email'),
            'semester' => $this->request->getPost('semester'),
            'status' => 'active',
            'enrolled_courses' => '[]' // JSON kosong untuk enrollment
        ];

        if ($model->insert($data)) {
            return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil! Silakan login.');
        } else {
            return redirect()->back()->with('error', 'Registrasi gagal!');
        }
    }
}
