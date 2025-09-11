<!-- // Controllers -->
<?php 
namespace App\Controllers;

use App\Models\Mahasiwa_models;

class Mahasiwa extends BaseController
{
    public function display() 
    {
        $model = new Mahasiwa_models();
        $data['title'] = 'Tabel Mahasiswa';
        $data['content'] = view('mahasiswa/detail', ['mahasiswa' => $model->findAll()]);

        return view('layout');
    }
}
?>