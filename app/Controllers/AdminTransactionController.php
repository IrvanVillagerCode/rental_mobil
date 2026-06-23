<?php

namespace App\Controllers;

use App\Models\MidtransTransactionModel;

class AdminTransactionController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('midtrans_transactions mt');
        $builder->select('mt.*, u.nama_lengkap, u.email, p.tgl_sewa, p.tgl_kembali, m.merek, m.model');
        $builder->join('penyewaan p', 'p.id_sewa = mt.id_sewa', 'left');
        $builder->join('mobil m', 'm.id_mobil = p.id_mobil', 'left');
        $builder->join('users u', 'u.id_user = mt.id_user', 'left');
        
        // Handling filters
        $status = $this->request->getGet('status');
        if ($status && $status !== 'all') {
            $builder->where('mt.transaction_status', $status);
        }
        
        $tanggal = $this->request->getGet('tanggal');
        if ($tanggal) {
            $builder->like('mt.created_at', $tanggal);
        }

        $builder->orderBy('mt.created_at', 'DESC');
        
        $data['transactions'] = $builder->get()->getResultArray();
        $data['title'] = 'Monitoring Transaksi Payment';
        $data['filter_status'] = $status ?? 'all';
        $data['filter_tanggal'] = $tanggal ?? '';

        return view('transactions/admin_monitoring', $data);
    }
}
