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
        $todays_income      = $transaction->income_by_date(session()->get('id_booth'), $today);
        $yesterday_income   = $transaction->income_by_date(session()->get('id_booth'), $yesterday);
        $weekly_receipts    = $transaction->count_receipts(session()->get('id_booth'));
        $data['todays_transaction'] = $todays_transaction;
        $data['todays_income'] = $todays_income;
        $data['yesterday_income'] = $yesterday_income;
        $data['weekly_receipts'] = $weekly_receipts;
        return view('dashboard/welcome', $data);
    }


}
