<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormAccess extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
            'id_form'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
            'access'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '1',
            ],
            'action'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '1',
            ],
        ]);
        // Membuat primary key
        // $this->forge->addKey('id_level', TRUE);
        $this->forge->addForeignKey('id_form', 'forms', 'id_form', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');
        // Membuat tabel
        $this->forge->createTable('form_access', TRUE);
    }

    public function down()
    {
        //
        // menghapus tabel
        $this->forge->dropTable('form_access');
    }
}
