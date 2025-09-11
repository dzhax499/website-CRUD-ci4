<?php
namespace App\Models;

use CodeIgniter\Model;

class Mahasiwa_models extends Model {
    protected $table = 'biodata';
    protected $primary_key='nim';
    protected $fields = ['nim','nama_lengkap','umur'];
}
?>