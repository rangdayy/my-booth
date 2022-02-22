<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Barang;

class Goods extends BaseController
{
    public function goods()
    {
        return view('dashboard/goods');
    }
    public function goodsList()
    {
        if ($this->request->isAJAX()) {
            $goods = new Barang();
            $goods_list = $goods->get_goods(session()->get('id_booth'));
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $goods_list]);
        }
    }

    public function goodsAdd()
    {
        if ($this->request->isAJAX()) {
            $barang = new Barang();
            $nama_barang = service('request')->getPost('add_name');
            $harga = service('request')->getPost('add_price');
            $stock = service('request')->getPost('add_stock');
            $last_id = $barang->get_latest_id(session()->get('id_booth'))['id_barang'];
            if ($last_id) {
                $id_barang = substr($last_id, 0, -3) . sprintf("%03s", ((int)substr($last_id, -3)) + 1);;
            } else {
                $id_barang = 'G' . session()->get('id_booth') . 'B000';
            }
            $query = $barang->insert([
                'id_barang' => $id_barang,
                'nama_barang' => strtoupper($nama_barang),
                'harga' => $harga,
                'stock' => (int)$stock,
                'id_booth' => (int)(session()->get('id_booth'))
            ]);
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id_barang]);
        }
    }
    public function goodsEdit()
    {
        if ($this->request->isAJAX()) {
            $barang = new barang();
            $id = service('request')->getPost('edit_id');
            $nama_barang = service('request')->getPost('edit_name');
            $harga = service('request')->getPost('edit_price');
            $stock = service('request')->getPost('edit_stock');
            $query = $barang->update($id, [
                'nama_barang' => strtoupper($nama_barang),
                'harga' => $harga,
                'stock' => (int)$stock,
            ]);
            // if ($query->insert_id()) {
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id]);
            // } else {
            //     return json_encode(['msg' => 'error', 'csrf' => csrf_hash(), 'result' => $query->insert_id()]);
            // }
        }
    }
    public function goodsDelete()
    {
        if ($this->request->isAJAX()) {
            $barang = new barang();
            $id_barang = service('request')->getPost('id_barang');
            $barang->where('id_barang', $id_barang)->delete();
            return json_encode(['msg' => 'success', 'csrf' => csrf_hash(), 'result' => $id_barang]);
        }
    }
}
