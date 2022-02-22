<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Level extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_level'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
            'nama_jabatan'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'id_booth'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
        ]);
        // Membuat primary key
        $this->forge->addKey('id_level', TRUE);
        $this->forge->addForeignKey('id_booth', 'booth', 'id_booth', 'CASCADE', 'CASCADE');
        // Membuat tabel
        $this->forge->createTable('level', TRUE);
    }

    public function down()
    {
        //
        // menghapus tabel
        $this->forge->dropTable('level');
    }
}
