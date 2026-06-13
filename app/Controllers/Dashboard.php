<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MobilModel;
use App\Models\PenyewaanModel;
use App\Models\BiayaModel;

class Dashboard extends BaseController
{
    protected MobilModel $mobilModel;
    protected PenyewaanModel $penyewaanModel;
    protected BiayaModel $biayaModel;

    public function __construct()
    {
        $this->mobilModel     = new MobilModel();
        $this->penyewaanModel = new PenyewaanModel();
        $this->biayaModel     = new BiayaModel();
    }

    public function index(): string
    {
        $today       = date('Y-m-d');
        $bulanIni    = (int)date('m');
        $tahunIni    = (int)date('Y');

        $statistikMobil = $this->mobilModel->getStatistik();
        $pendapatanHari = $this->penyewaanModel->getPendapatanHarian($today);
        $transaksiAktif = $this->penyewaanModel->countActive();
        $pendBulanan    = $this->penyewaanModel->getTotalPendapatanBulanan($bulanIni, $tahunIni);
        $biayaBulanan   = $this->biayaModel->getTotalBulanan($bulanIni, $tahunIni);
        $labaKotor      = $pendBulanan - $biayaBulanan;

        $recentSewa = $this->penyewaanModel->getWithMobil();
        $recentSewa = array_slice($recentSewa, 0, 5);

        return view('dashboard/index', [
            'statistik_mobil'  => $statistikMobil,
            'pendapatan_hari'  => $pendapatanHari,
            'transaksi_aktif'  => $transaksiAktif,
            'pendapatan_bulan' => $pendBulanan,
            'biaya_bulan'      => $biayaBulanan,
            'laba_kotor'       => $labaKotor,
            'recent_sewa'      => $recentSewa,
        ]);
    }
}
