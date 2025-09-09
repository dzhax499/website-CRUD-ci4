<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'content' => view('home')
        ];
        return view('template', $data);
    }
}
