<?php

namespace App\Controllers;

use App\Models\Booth;
use App\Models\User;
use App\Models\Level;
use App\Models\FormsAccess;

class Auth extends BaseController
{
    public function signUp()
    {
        if (!session()->get('isLoggedIn')) {
            return view('auth/sign_up');
        } else {
            return redirect()
                ->to('/');
        }
    }

    public function login()
    {
        if (!session()->get('isLoggedIn')) {
            return view('auth/login');
        } else {
            return redirect()
                ->to('/');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function createBooth()
    {
        helper(['form']);
        $rules = [
            'booth_name'   => 'required|min_length[2]|max_length[50]|is_unique[booth.nama_booth]',
            'name'         => 'required|min_length[4]|max_length[100]',
            'password'     => 'required|min_length[4]|max_length[50]',
            // 'confirmpassword'  => 'matches[password]'
        ];
        if ($this->validate($rules)) {
            $booth = new Booth();
            $user  = new User();
            $level  = new Level();
            $security  = new FormsAccess();
            $booth->insert([
                'nama_booth' => strtoupper($this->request->getVar('booth_name'))
            ]);
            $id_booth = $booth->get_last_id($this->request->getVar('booth_name'));
            $id_user = 'U' . $id_booth['id_booth'] .'B'. '000';
            $id_level = 'L' . $id_booth['id_booth'] .'B'. '000';
            $level->insert([
                'id_level' => $id_level,
                'nama_jabatan' => 'OWNER',
                'id_booth' => $id_booth
            ]);
            $security->insert_security($id_level);
            $user->insert([
                'id_user' => $id_user,
                'nama_user' => strtoupper($this->request->getVar('name')),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'id_level' => $id_level,
                'id_booth' => $id_booth
            ]);
            $session = session();
            $session->setFlashdata('success', 'Your booth has been registered!. your ID is ' . $id_user . ', please login to access the dashboard!');
            return redirect()->to('/login');
        } else {
            $session = session();
            $session->setFlashdata('error',  $this->validator->listErrors());
            return redirect()->to('/signup');
            // $data['error'] = $this->validator;
            // echo  view('auth/sign_up', $data);
        }
    }

    public function loginAuth()
    {
        $session = session();
        $userModel = new User();
        $id = $this->request->getVar('user_id');
        $password = $this->request->getVar('password');
        $data = $userModel->get_user_data($id);
        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'id_user' => $data['id_user'],
                    'name' => $data['nama_user'],
                    'id_booth' => $data['id_booth'],
                    'nama_booth' => $data['nama_booth'],
                    'level' => $data['nama_jabatan'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/');
            } else {
                $session->setFlashdata('error', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', "ID doesn't exist.");
            return redirect()->to('/login');
        }
    }
}
