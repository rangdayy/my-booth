<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_struk'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
            'tanggal_transaksi'       => [
                'type'           => 'DATETIME',
            ],
            'harga_total'       => [
                'type'           => 'DECIMAL(20,2)',
            ],
            'uang'       => [
                'type'           => 'DECIMAL(20,2)',
            ],
            'id_booth'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
            'id_user'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
        ]);
        // Membuat primary key
        $this->forge->addKey('id_struk', TRUE);
        $this->forge->addForeignKey('id_booth', 'booth', 'id_booth', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');
        // Membuat tabel
        $this->forge->createTable('struk', TRUE);
    }

    public function down()
    {
        //
        // menghapus tabel
        $this->forge->dropTable('struk');
    }
}
