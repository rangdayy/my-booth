<?php

namespace App\Models;

use CodeIgniter\Model;

class Forms extends Model
{
    protected $table = 'forms';
    
    protected $allowedFields = ['id_form','nama_form'];

    public function get_forms()
    {
        return  $this->orderBy('id_form', 'ASC')->findAll();
    }

}
