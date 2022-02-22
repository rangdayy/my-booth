<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        //
        // Membuat kolom/field untuk tabel
        $this->forge->addField([
            'id_user'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
            'nama_user'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'password'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'hp'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '20'
            ],
            'id_booth'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
            'id_level'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
        ]);
        // Membuat primary key
        $this->forge->addKey('id_user', TRUE);
        $this->forge->addForeignKey('id_booth', 'booth', 'id_booth', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_level', 'level', 'id_level', 'CASCADE', 'CASCADE');
        // Membuat tabel
        $this->forge->createTable('user', TRUE);
    }

    public function down()
    {
        //
        // menghapus tabel
        $this->forge->dropTable('user');
    }
}
