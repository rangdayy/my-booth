<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $primaryKey = 'id_transaksi';

    protected $allowedFields = ['id_transaksi', 'qty',  'id_booth', 'id_barang', 'id_struk'];


    public function get_latest_id($id_booth)
    {
        return  $this->select('id_transaksi')->like('id_transaksi', 'TB' . $id_booth . 'B', 'both')->orderby('id_transaksi', 'DESC')->first();
    }

    public function get_receipt($id_booth, $id_struk)
    {
        return  $this->select("transaksi.id_barang, barang.nama_barang, barang.harga, struk.uang,transaksi.qty,struk.id_struk")
            ->join('barang', 'transaksi.id_barang = barang.id_barang', 'left')
            ->join('struk', 'transaksi.id_struk = struk.id_struk', 'left')
            ->where(array('struk.id_struk' => $id_struk , 'transaksi.id_booth ' => $id_booth))->findAll();
    }
}
