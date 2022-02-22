<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Booth extends Migration
{
    public function up()
    {
        //
        // Membuat kolom/field untuk tabel booth
        $this->forge->addField([
            'id_booth'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'nama_booth'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
        ]);
        // Membuat primary key
        $this->forge->addKey('id_booth', TRUE);

        // Membuat tabel booth
        $this->forge->createTable('booth', TRUE);
    }

    public function down()
    {
        //
        // menghapus tabel booth
        $this->forge->dropTable('booth');
    }
}
