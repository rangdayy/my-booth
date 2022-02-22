<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Struk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
            'qty'       => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,

            ],
            'id_booth'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'id_barang'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
            'id_struk'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
        ]);
        // Membuat primary key
        $this->forge->addKey('id_transaksi', TRUE);
        $this->forge->addForeignKey('id_booth', 'booth', 'id_booth', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_struk', 'struk', 'id_struk', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_barang', 'barang', 'id_barang', 'CASCADE', 'CASCADE');
        // Membuat tabel
        $this->forge->createTable('transaksi', TRUE);
    }

    public function down()
    {
        // menghapus tabel
        $this->forge->dropTable('transaksi');
    }
}