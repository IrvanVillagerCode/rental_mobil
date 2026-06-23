<?php

namespace App\Controllers;

use App\Models\MidtransTransactionModel;
use App\Models\PenyewaanModel;

class TransactionController extends BaseController
{
    public function history()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $midtransModel = new MidtransTransactionModel();
        
        $db = \Config\Database::connect();
        $builder = $db->table('midtrans_transactions mt');
        $builder->select('mt.*, m.merek, m.model, m.nopol_mobil');
        $builder->join('penyewaan p', 'p.id_sewa = mt.id_sewa');
        $builder->join('mobil m', 'm.id_mobil = p.id_mobil');
        $builder->where('mt.id_user', session()->get('uid'));
        $builder->orderBy('mt.created_at', 'DESC');
        
        $data['transactions'] = $builder->get()->getResultArray();
        $data['title'] = 'Riwayat Transaksi';

        return view('transactions/user_history', $data);
    }
}
