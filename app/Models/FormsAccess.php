<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Forms;

class FormsAccess extends Model
{
    protected $table = 'form_access';

    protected $allowedFields = ['id_level', 'id_form', 'access', 'action'];

    public function insert_security($id_level)
    {
        $forms = new Forms();
        $data = $forms->get_forms();
        $security = [];
        foreach ($data as $idx => $form) {
            $security[$idx]['id_level'] = $id_level;
            $security[$idx]['id_form']  = $form['id_form'];
            $security[$idx]['access']   = 'T';
            $security[$idx]['action']   = 'T';
        }
        
        return $this->insertBatch($security);
    }
}
