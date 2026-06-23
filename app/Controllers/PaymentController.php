<?php

namespace App\Controllers;

use App\Models\PenyewaanModel;
use App\Models\MidtransTransactionModel;
use Config\Midtrans;

class PaymentController extends BaseController
{
    protected $penyewaanModel;
    protected $midtransModel;

    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel();
        $this->midtransModel = new MidtransTransactionModel();

        // Setup Midtrans
        $midtransConfig = new Midtrans();
        \Midtrans\Config::$serverKey = $midtransConfig->serverKey;
        \Midtrans\Config::$isProduction = $midtransConfig->isProduction;
        \Midtrans\Config::$isSanitized = $midtransConfig->isSanitized;
        \Midtrans\Config::$is3ds = $midtransConfig->is3ds;
    }

    public function checkout($idSewa)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $sewa = $this->penyewaanModel->getWithMobil($idSewa);
        if (!$sewa) {
            return redirect()->back()->with('error', 'Data penyewaan tidak ditemukan.');
        }

        // Pastikan hanya user yang bersangkutan atau admin yang bisa checkout
        if (session()->get('role') !== 'admin' && $sewa['id_user'] !== session()->get('uid')) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak berhak mengakses transaksi ini.');
        }

        // Cek apakah transaksi midtrans sudah pernah dibuat untuk order ini
        $orderId = 'TRX-' . $sewa['id_sewa'] . '-' . time();
        $grossAmount = (float)$sewa['total_biaya'];

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $grossAmount,
        ];

        $customerDetails = [
            'first_name' => session()->get('nama_lengkap') ?? $sewa['nama_penyewa'],
            'email' => session()->get('email') ?? 'customer@autovora.id',
            'phone' => $sewa['kontak'],
        ];

        $itemDetails = [
            [
                'id' => $sewa['id_mobil'],
                'price' => $grossAmount,
                'quantity' => 1,
                'name' => "Sewa " . $sewa['merek'] . " " . $sewa['model'],
            ]
        ];

        $snapToken = '';
        try {
            $snapToken = \Midtrans\Snap::getSnapToken([
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $itemDetails,
            ]);

            // Save to DB
            $this->midtransModel->insert([
                'id_sewa' => $sewa['id_sewa'],
                'id_user' => session()->get('uid'),
                'order_id' => $orderId,
                'amount' => $grossAmount,
                'snap_token' => $snapToken,
                'transaction_status' => 'pending'
            ]);

            // Update penyewaan methods
            $this->penyewaanModel->update($sewa['id_sewa'], [
                'metode_pembayaran' => 'online',
                'status_pembayaran' => 'menunggu'
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }

        $data = [
            'sewa' => $sewa,
            'snapToken' => $snapToken,
            'clientKey' => (new Midtrans())->clientKey,
            'orderId' => $orderId
        ];

        return view('penyewaan/checkout_midtrans', $data);
    }
}
