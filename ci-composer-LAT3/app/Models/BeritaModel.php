<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'biodata';
    protected $primaryKey = 'nim';
    protected $allowedFields = ['nim', 'nama_lengkap', 'umur'];
}
