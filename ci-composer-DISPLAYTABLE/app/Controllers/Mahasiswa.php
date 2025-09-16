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

    // public function detail($id)
    // {
    //     $model = new Mahasiswa_models();
    //     $data['title'] = "Detail Mahasiswa";
    //     // PERBAIKAN: Menggunakan variabel yang konsisten (mhsindex)
    //     $data['content'] = view('mahasiswa/detail_mahasiswa', [
    //         'mhsindex' => $model->find($id)
    //     ]);

    //     return view('layout', $data);
    // }
}
