<?php

namespace App\Controllers;

use App\Models\PenyewaanModel;
use App\Models\MidtransTransactionModel;
use Config\Midtrans;

class MidtransCallbackController extends BaseController
{
    public function notification()
    {
        $midtransConfig = new Midtrans();
        \Midtrans\Config::$serverKey = $midtransConfig->serverKey;
        \Midtrans\Config::$isProduction = $midtransConfig->isProduction;

        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Invalid notification']);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $midtransModel = new MidtransTransactionModel();
        $penyewaanModel = new PenyewaanModel();

        $trxRecord = $midtransModel->where('order_id', $orderId)->first();
        if (!$trxRecord) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Order ID not found']);
        }

        $status = 'pending';
        $pembayaranStatus = 'menunggu';

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $status = 'challenge';
                } else {
                    $status = 'success';
                    $pembayaranStatus = 'lunas';
                }
            }
        } else if ($transaction == 'settlement') {
            $status = 'success';
            $pembayaranStatus = 'lunas';
        } else if ($transaction == 'pending') {
            $status = 'pending';
        } else if ($transaction == 'deny') {
            $status = 'failed';
            $pembayaranStatus = 'belum_lunas';
        } else if ($transaction == 'expire') {
            $status = 'expired';
            $pembayaranStatus = 'belum_lunas';
        } else if ($transaction == 'cancel') {
            $status = 'cancelled';
            $pembayaranStatus = 'belum_lunas';
        }

        // Update transaction record
        $midtransModel->update($trxRecord['id'], [
            'transaction_status' => $status,
            'payment_type' => $type,
            'midtrans_transaction_id' => $notif->transaction_id
        ]);

        // Auto update core order status if paid
        if ($status === 'success') {
            $penyewaanModel->update($trxRecord['id_sewa'], [
                'status_pembayaran' => 'lunas',
                'status_transaksi' => 'menunggu_konfirmasi' // Require admin approval
            ]);
        }

        return $this->response->setStatusCode(200)->setJSON(['message' => 'Notification handled']);
    }
}
