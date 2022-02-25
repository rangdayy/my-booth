<?php

namespace App\Models;

use CodeIgniter\Model;

class Struk extends Model
{
    protected $table = 'struk';

    protected $primaryKey = 'id_struk';

    protected $allowedFields = ['id_struk', 'tanggal_transaksi', 'harga_total',  'uang','id_booth', 'id_user', 'id_transaksi'];

    public function get_latest_id($id_booth, $date)
    {
        return  $this->select('id_struk')->like('id_struk', 'T' . $id_booth . 'B' . $date, 'both')->orderby('id_struk', 'DESC')->first();
    }

    public function get_transactions($id_booth, $paginate)
    {
        return  $this->select("struk.id_struk, DATE_FORMAT(struk.tanggal_transaksi, '%d-%m-%Y %h:%i %p') AS tanggal_transaksi, ,struk.harga_total, user.nama_user, user.id_user")
            ->join('user', 'user.id_user = struk.id_user', 'left')
            ->where('struk.id_booth', $id_booth)->paginate($paginate,'transaksi');
    }

    public function todays_transactions($id_booth, $date)
    {
        return  $this->selectCount('id_struk')->where(array('id_booth'=>$id_booth, 'DATE_FORMAT(tanggal_transaksi, "%d-%m-%Y")'=> $date) )->countAllResults();
    }

    public function income_by_date($id_booth, $date)
    {
        return  $this->selectSum('harga_total')->where(array('id_booth'=>$id_booth, 'DATE_FORMAT(tanggal_transaksi, "%d-%m-%Y")'=> $date) )->first();
    }

    public function count_receipts($id_booth)
    {
        return  $this->select('id_struk')->where(array('id_booth'=>$id_booth, 'tanggal_transaksi'=> 'DATE(NOW()) - INTERVAL 7 DAY') )->countAll();
    }


}
