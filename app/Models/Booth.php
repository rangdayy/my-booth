<?php

namespace App\Models;

use CodeIgniter\Model;

class Booth extends Model
{
    protected $table = 'booth';

    protected $primaryKey = 'id_booth';
    
    protected $allowedFields = ['nama_booth'];
    
    public function get_last_id($data)
    {
        return  $this->select('id_booth')->where('nama_booth', $data)->first();
    }
}
