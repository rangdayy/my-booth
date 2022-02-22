<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Level;

class Levels extends BaseController
{
    public function levels()
    {
        return view('dashboard/levels');
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
            $nama_level = service('request')->getPost('add_name');
            $last_id = $levels->get_latest_id(session()->get('id_booth'))['id_level'];
            if ($last_id) {
                $id_level = substr($last_id, 0, -3) . sprintf("%03s", ((int)substr($last_id, -3)) + 1);;
            } else {
                $id_level = 'L' . session()->get('id_booth') . 'B000';
            }
            $query = $levels->insert([
                'id_level' => $id_level,
                'nama_jabatan' => strtoupper($nama_level),
                'id_booth' => (int)(session()->get('id_booth'))
            ]);
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id_level]);
        }
    }
    public function levelsEdit()
    {
        if ($this->request->isAJAX()) {
            $levels = new Level();
            $id = service('request')->getPost('edit_id');
            $nama_jabatan = service('request')->getPost('edit_name');
            $query = $levels->update($id, [
                'nama_jabatan' => strtoupper($nama_jabatan),
            ]);
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
}
