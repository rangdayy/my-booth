<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Forms extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_form'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
            'nama_form'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ]
        ]);
        // Membuat primary key
        $this->forge->addKey('id_form', TRUE);
        // Membuat tabel
        $this->forge->createTable('forms', TRUE);
    }

    public function down()
    {
        // menghapus tabel
        $this->forge->dropTable('forms');
    }
}
