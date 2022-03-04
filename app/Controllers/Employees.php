<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Level;
use App\Models\FormsAccess;

class Employees extends BaseController
{
    public function employees()
    {
        $form = 'F001';
        $user = new User();
        $security = new FormsAccess();
        $id_level = $user->get_user_data(session()->get('id_user'));
        $access = $security->find_access($id_level['id_level'], $form);
        // return view('dashboard/employees', $access);
        if ($access['access'] == 'T') {
            return view('dashboard/employees');
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    public function employeesList()
    {
        if ($this->request->isAJAX()) {
            $user = new User();
            $employee_list = $user->get_employees(session()->get('id_booth'));
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $employee_list]);
        }
    }
    public function employeesLevel()
    {
        if ($this->request->isAJAX()) {
            $level = new Level();
            $levels = $level->get_levels(session()->get('id_booth'));
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $levels]);
        }
    }

    public function employeeAdd()
    {
        if ($this->request->isAJAX()) {
            $user = new user();
            $name = service('request')->getPost('add_name');
            $phone = service('request')->getPost('add_phone');
            $level = service('request')->getPost('add_level');
            $last_id = $user->get_latest_id(session()->get('id_booth'))['id_user'];
            $id_user = substr($last_id, 0, -3) . sprintf("%03s", ((int)substr($last_id, -3)) + 1);;
            $query = $user->insert([
                'id_user' => $id_user,
                'nama_user' => strtoupper($name),
                'password' => password_hash($id_user, PASSWORD_DEFAULT),
                'hp' => $phone,
                'id_level' => $level,
                'id_booth' => (int)(session()->get('id_booth'))
            ]);
            // if ($query->insert_id()) {
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id_user]);
            // } else {
            //     return json_encode(['msg' => 'error', 'csrf' => csrf_hash(), 'result' => $query->insert_id()]);
            // }
        }
    }
    public function employeeEdit()
    {
        if ($this->request->isAJAX()) {
            $user = new user();
            $id = service('request')->getPost('edit_id');
            $name = service('request')->getPost('edit_name');
            $phone = service('request')->getPost('edit_phone');
            $level = service('request')->getPost('edit_level');
            $query = $user->update($id, [
                'nama_user' => strtoupper($name),
                'hp' => $phone,
                'id_level' => $level,
            ]);
            // if ($query->insert_id()) {
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id]);
            // } else {
            //     return json_encode(['msg' => 'error', 'csrf' => csrf_hash(), 'result' => $query->insert_id()]);
            // }
        }
    }
    public function employeeDelete()
    {
        if ($this->request->isAJAX()) {
            $user = new user();
            $id_user = service('request')->getPost('id_user');
            $user->where('id_user', $id_user)->delete();
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id_user]);
        }
    }
}
