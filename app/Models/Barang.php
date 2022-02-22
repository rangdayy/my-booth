<?php

namespace App\Models;

use CodeIgniter\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $primaryKey = 'id_barang';

    protected $allowedFields = ['id_barang', 'nama_barang', 'harga', 'stock', 'id_booth'];


    public function get_goods($id_booth)
    {
        return  $this->select('barang.id_barang, barang.nama_barang, barang.stock, barang.harga, barang.id_booth')
            ->join('booth', 'barang.id_booth = booth.id_booth', 'left')
            ->where('barang.id_booth', $id_booth)->findAll();
    }

    public function get_latest_id($id_booth)
    {
        return  $this->select('id_barang')->like('id_barang','G' . $id_booth.'B', 'both')->orderby('id_barang','DESC')->first();

    }

    public function get_latest_goods_qty($id_booth, $id)
    {
        return  $this->select('stock')->where(array('id_barang' => $id , 'id_booth ' => $id_booth))->first();
    }
}
