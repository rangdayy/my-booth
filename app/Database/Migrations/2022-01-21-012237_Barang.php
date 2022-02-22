<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        //
        // Membuat kolom/field untuk tabel
        $this->forge->addField([
            'id_barang'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
            ],
            'nama_barang'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'harga'       => [
                'type'           => 'DECIMAL(20,2)',
            ],
            'stock'       => [
                'type'           => 'INT',
                'constraint'     => 10
            ],
            'id_booth'       => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true
            ],
        ]);
        // Membuat primary key
        $this->forge->addKey('id_barang', TRUE);
        $this->forge->addForeignKey('id_booth', 'booth', 'id_booth', 'CASCADE', 'CASCADE');
        // Membuat tabel
        $this->forge->createTable('barang', TRUE);
    }

    public function down()
    {
        //
        // menghapus tabel
        $this->forge->dropTable('barang');
    }
}
