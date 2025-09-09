<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TabelDinamis extends Controller
{
    public function index()
    {
        $data_mahasiswa = [
            ['nim' => '071', 'nama' => 'Dzakir', 'jurusan' => 'Teknik Informatika'],
            ['nim' => '039', 'nama' => 'Gema', 'jurusan' => 'Teknik Mesin'],
            ['nim' => '077', 'nama' => 'Dava', 'jurusan' => 'Teknik Elektro'],
            ['nim' => '017', 'nama' => 'Davi', 'jurusan' => 'Teknik Elektro'],
            ['nim' => '023', 'nama' => 'Dava', 'jurusan' => 'Teknik Elektro'],
            ['nim' => '065', 'nama' => 'Dava', 'jurusan' => 'Teknik Elektro'],
        ];

        $tabel = '
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>
                <tbody>
        ';

        foreach ($data_mahasiswa as $mahasiswa) {
            $tabel .= '
                <tr>
                    <td>' . $mahasiswa['nim'] . '</td>
                    <td>' . $mahasiswa['nama'] . '</td>
                    <td>' . $mahasiswa['jurusan'] . '</td>
                </tr>
            ';
        }

        $tabel .= '
                </tbody>
            </table>
        ';

        return $tabel;
    }
}