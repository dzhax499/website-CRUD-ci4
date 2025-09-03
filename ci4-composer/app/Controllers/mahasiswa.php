<?php
namespace App\Controllers;

use App\Models\MahasiswaModel;

class Mahasiswa extends BaseController
{
    public function display()
    {
        $model = new MahasiswaModel();
        $data['mahasiswa'] = $model->getMahasiswa();

        return view('v_mahasiswa', $data);
    }
}