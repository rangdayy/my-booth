<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\FormAccess;
use App\Models\Level;
use App\Models\Forms;
use App\Models\FormsAccess;

class Levels extends BaseController
{
    public function levels()
    {
        $forms = new Forms();
        $data = [
            'forms' => $forms->get_forms(),
        ];
        return view('dashboard/levels', $data);
    }
    public function levelsList()
    {
        if ($this->request->isAJAX()) {
            $levels = new Level();
            $levels_list = $levels->get_levels(session()->get('id_booth'));
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $levels_list]);
        }
    }
    public function levelsAdd()
    {
        if ($this->request->isAJAX()) {
            $levels = new Level();
            $security = new FormsAccess();
            $nama_level = service('request')->getPost('add_name');
            $last_id = $levels->get_latest_id(session()->get('id_booth'))['id_level'];
            if ($last_id) {
                $id_level = substr($last_id, 0, -3) . sprintf("%03s", ((int)substr($last_id, -3)) + 1);;
            } else {
                $id_level = 'L' . session()->get('id_booth') . 'B000';
            }
            $levels->insert([
                'id_level' => $id_level,
                'nama_jabatan' => strtoupper($nama_level),
                'id_booth' => (int)(session()->get('id_booth'))
            ]);
            $security->insert_security($id_level);
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id_level]);
        }
    }
    public function levelsEdit()
    {
        if ($this->request->isAJAX()) {
            $levels = new Level();
            $forms = new Forms();
            $security = new FormsAccess();
            $id = service('request')->getPost('edit_id');
            $nama_jabatan = service('request')->getPost('edit_name');
            $access = service('request')->getPost('checkbox_access[]');
            $manage = service('request')->getPost('checkbox_manage[]');
            $list_of_forms = $forms->get_forms();
            // $form_arr = [];
            foreach ($list_of_forms as $idx => $form) {
                // $form_arr[$idx]['id_level'] = $id;
                // $form_arr[$idx]['id_form']  = $form['id_form'];
                // $form_arr[$idx]['access']   = 'T' ? isset($access[$form['id_form']]) : 'F';
                // $form_arr[$idx]['action']   = 'T' ? isset($manage[$form['id_form']]) : 'F';
                $data = [
                    'id_level'  =>  $id,
                    'id_form'  =>  $form['id_form'],
                    'access'  =>  isset($access[$form['id_form']]) ? 'T' : 'F',
                    'action'  =>  isset($manage[$form['id_form']]) ? 'T' : 'F',
                ];
                $security->where([
                    'id_level'  =>  $id,
                    'id_form'  =>  $form['id_form']
                ])->delete();
                $security->save($data);
            }
            $levels->update($id, ['nama_jabatan' => strtoupper($nama_jabatan)]);
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id]);
        }
    }
    public function levelsDelete()
    {
        if ($this->request->isAJAX()) {
            $levels = new Level();
            $id_level = service('request')->getPost('id_level');
            $levels->where('id_level', $id_level)->delete();
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id_level]);
        }
    }

    public function levelSecurity()
    {
        if ($this->request->isAJAX()) {
            $security = new FormsAccess();
            $id_level = service('request')->getPost('id_level');
            $query = $security->where('id_level', $id_level)->orderBy('id_form', 'ASC')->findAll();
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $query]);
        }
    }
}
