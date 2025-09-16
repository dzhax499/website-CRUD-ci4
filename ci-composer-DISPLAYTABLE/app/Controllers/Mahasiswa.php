<?php
// ===== 1. Mahasiswa.php (Controller) - DIPERBAIKI =====
namespace App\Controllers;

use App\Models\Mahasiswa_models;

class Mahasiswa extends BaseController
{
    public function index() 
    {
        $model = new Mahasiswa_models();
        $data['title'] = 'Daftar Mahasiswa';
        // PERBAIKAN: Menggunakan view yang benar (v_mahasiswa) dan variabel yang tepat
        $data['content'] = view('mahasiswa/v_mahasiswa', [
            'mhs' => $model->findAll()
        ]);

        return view('layout', $data);
    }
}
