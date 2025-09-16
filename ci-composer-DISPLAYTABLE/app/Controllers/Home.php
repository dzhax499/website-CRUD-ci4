<?php
// App/Controllers/Home.php
namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = 'Home - Sistem Akademik';
        $data['content'] = view('home/v_home');

        return view('layout', $data);
    }
}
