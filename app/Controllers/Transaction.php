<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Struk;
use App\Models\Transaksi;
use App\Models\Barang;
use CodeIgniter\I18n\Time;

class Transaction extends BaseController
{
    public function transaction()
    {

        return view('dashboard/transaction');
    }

    public function report()
    {
        $transaction = new Struk();
        $data = [
            'transactions' => $transaction->get_transactions(session()->get('id_booth'), 15),
            'pager' => $transaction->pager,
        ];
        return view('dashboard/report', $data);
    }
    public function transactionReceipt()
    {
        if ($this->request->isAJAX()) {
            $transaction = new Transaksi();
            $id_struk    = service('request')->getPost()['id_struk'];
            $data        = $transaction->get_receipt(session()->get('id_booth'), $id_struk);
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $data]);
        }
    }

    public function transactionAdd()
    {
        if ($this->request->isAJAX()) {
            $goods      = [];
            $update_qty = [];
            $total      = 0;
            $struk      = new Struk();
            $transaksi  = new Transaksi();
            $barang     = new Barang();
            $date       = date("dmY", strtotime(Time::now()));
            $receipt_last_id    = $struk->get_latest_id(session()->get('id_booth'), $date)['id_struk'];
            $goods_last_id      = $transaksi->get_latest_id(session()->get('id_booth'), $date)['id_transaksi'];
            $data               = json_decode(service('request')->getPost()['data']);
            $money              = service('request')->getPost()['money'];
            if ($receipt_last_id) {
                $id_struk = substr($receipt_last_id, 0, -4) . sprintf("%04s", ((int)substr($receipt_last_id, -4)) + 1);;
            } else {
                $id_struk = 'T' . session()->get('id_booth') . 'B' . $date . '0000';
            }
            foreach ($data as $idx => $value) {
                if ($goods_last_id) {
                    $id_tr_b = substr($goods_last_id, 0, -6) . sprintf("%06s", ((int)substr($goods_last_id, -6)) + ($idx+1));
                } else {
                    $id_tr_b = 'TB' . session()->get('id_booth') . 'B' . '000000';
                    $goods_last_id = $id_tr_b;
                }
                $goods[$idx]['id_transaksi'] = $id_tr_b;
                $goods[$idx]['qty']         = (int) ($value->qty);
                $goods[$idx]['id_barang']   = $value->id_barang;
                $goods[$idx]['id_booth']    = (int)(session()->get('id_booth'));
                $goods[$idx]['id_struk']    = $id_struk;
                $stock_qty_check            = $barang->get_latest_goods_qty(session()->get('id_booth'), $value->id_barang)['stock'];
                $update_qty[$idx]['stock']  = (int) ($stock_qty_check) - (int) ($value->qty);
                $update_qty[$idx]['id_barang']   = $value->id_barang;
                $total                      += (int) ($value->harga_total);
            } 
            $struk->insert([
                'id_struk'          => $id_struk,
                'tanggal_transaksi' => Time::now(),
                'harga_total'       => $total,
                'uang'              => (int) $money,
                'id_user'           => session()->get('id_user'),
                'id_booth'          => (int)(session()->get('id_booth'))
            ]);
            $substract = ((int) $money) - $total;
            $transaksi->insertBatch($goods);
            $barang->updateBatch($update_qty, 'id_barang');
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => ['id_struk' => $id_struk, 'substract' => $substract, 'data' => $goods]]);
        }
    }
}
