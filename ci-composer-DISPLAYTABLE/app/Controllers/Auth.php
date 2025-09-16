<?php
// App/Controllers/Auth.php
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

        return view('layout', $data);
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

        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session_data = [
                'user_id' => $user['id'],
                'username' => $user['username'],
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

        return view('layout', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'role' => 'required|in_list[admin,student]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new User_model();
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($model->insert($data)) {
            return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil! Silakan login.');
        } else {
            return redirect()->back()->with('error', 'Registrasi gagal!');
        }
    }
}
