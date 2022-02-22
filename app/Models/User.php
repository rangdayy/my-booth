<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'id_user';

    protected $allowedFields = ['id_user', 'nama_user', 'password', 'hp', 'id_booth', 'id_level'];

    public function get_user_data($id)
    {
        return  $this->join('booth', 'booth.id_booth = user.id_booth', 'left')
            ->join('level', 'level.id_level = user.id_level', 'left')
            ->where('user.id_user', $id)->first();
    }

    public function get_employees($id_booth)
    {
        return  $this->select('user.id_user, user.nama_user, user.hp,level.id_level, level.nama_jabatan')
            ->join('level', 'level.id_level = user.id_level', 'left')
            ->where('user.id_booth', $id_booth)->findAll();
    }

    public function get_latest_id($id_booth)
    {
        return  $this->select('id_user')->like('id_user','U' . $id_booth.'B', 'both')->orderby('id_user','DESC')->first();

    }
}
