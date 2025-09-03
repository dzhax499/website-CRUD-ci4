<?php 
namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'biodata';

    public function getMahasiswa()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM biodata');
        return $query->getResultArray();
    }
}
