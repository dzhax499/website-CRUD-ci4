<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'userId'     => $user['id'],
                'role'       => $user['role'],
                'nama'       => $user['nama']
            ]);

            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/student/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
