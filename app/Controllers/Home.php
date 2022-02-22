<?php

namespace App\Controllers;
use App\Models\Struk;
use CodeIgniter\I18n\Time;


class Home extends BaseController
{
    public function index()
    {
        $transaction    = new Struk();
        $today              = date("d-m-Y", strtotime(Time::now()));
        $yesterday          = date("d-m-Y", strtotime(Time::yesterday()));
        $todays_transaction = $transaction->todays_transactions(session()->get('id_booth'), $today);
        $todays_income      = $transaction->todays_income(session()->get('id_booth'), $today);
        $yesterday_income   = $transaction->todays_income(session()->get('id_booth'), $yesterday);
        $data['todays_transaction'] = $todays_transaction;
        $data['todays_income'] = $todays_income;
        $data['yesterday_income'] = $yesterday_income;
        return view('dashboard/welcome', $data);
    }


}
