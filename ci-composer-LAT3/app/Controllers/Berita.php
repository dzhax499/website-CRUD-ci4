<?php

namespace App\Controllers;

use App\Models\BeritaModel;

class Berita extends BaseController
{
    public function index()
    {
        $beritaModel = new BeritaModel();
        $data['title'] = "Daftar Berita";
        $data['content'] = view('berita/index', [
            'berita' => $beritaModel->findAll()
        ]);

        return view('layout', $data);
    }
}
