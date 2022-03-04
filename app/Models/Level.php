<?php

namespace App\Models;

use CodeIgniter\Model;

class Level extends Model
{
    protected $table = 'level';

    protected $primaryKey = 'id_level';
    
    protected $allowedFields = ['id_level','nama_jabatan','id_booth'];

    public function get_levels($id_booth)
    {
        return  $this->where('id_booth', $id_booth)->findAll();
    }
    
    public function get_latest_id($id_booth)
    {
        return  $this->select('id_level')->like('id_level','L' . $id_booth.'B', 'both')->orderby('id_level','DESC')->first();

    }
}
