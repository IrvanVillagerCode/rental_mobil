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
        $role = session()->get('role');

        if ($role !== 'admin') {
            // Customer Dashboard Logic
            $uid = session()->get('uid');
            $myRentals = $this->penyewaanModel->getByUser($uid);
            
            $totalSewa = count($myRentals);
            $sewaAktif = 0;
            $totalPengeluaran = 0.0;
            foreach ($myRentals as $r) {
                if (in_array($r['status_transaksi'], ['booking', 'berjalan'])) {
                    $sewaAktif++;
                }
                if (in_array($r['status_transaksi'], ['berjalan', 'selesai'])) {
                    $totalPengeluaran += (float)$r['total_biaya'];
                }
            }

            // Set up virtual timers for active rentals
            $virtualTimers = session()->get('virtual_timers') ?? [];
            $activeTimers = [];
            $updatedTimers = false;
            foreach ($myRentals as $r) {
                if ($r['status_transaksi'] === 'berjalan') {
                    $idSewa = $r['id_sewa'];
                    if (!isset($virtualTimers[$idSewa])) {
                        $virtualTimers[$idSewa] = time() + 480; // 8 minutes default
                        $updatedTimers = true;
                    }
                    $activeTimers[$idSewa] = $virtualTimers[$idSewa];
                }
            }
            if ($updatedTimers) {
                session()->set('virtual_timers', $virtualTimers);
            }

            return view('dashboard/user_index', [
                'my_rentals'        => array_slice($myRentals, 0, 5),
                'total_sewa'        => $totalSewa,
                'sewa_aktif'        => $sewaAktif,
                'total_pengeluaran' => $totalPengeluaran,
                'active_timers'     => $activeTimers,
                'mobil_list'        => $this->mobilModel->findAll(),
            ]);
        }

        // Admin Dashboard Logic
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

    public function getStatsAjax()
    {
        $role = session()->get('role');

        if ($role !== 'admin') {
            $uid = session()->get('uid');
            $myRentals = $this->penyewaanModel->getByUser($uid);
            
            $totalSewa = count($myRentals);
            $sewaAktif = 0;
            $totalPengeluaran = 0.0;
            $tagihanBelumLunas = []; // Array untuk menampung tagihan sisa

            foreach ($myRentals as $r) {
                if (in_array($r['status_transaksi'], ['booking', 'berjalan'])) {
                    $sewaAktif++;
                }
                if (in_array($r['status_transaksi'], ['berjalan', 'selesai'])) {
                    $totalPengeluaran += (float)$r['total_biaya'];
                }
                
                // Cari tagihan yang masih aktif dan belum lunas
                if ($r['status_transaksi'] === 'berjalan' && $r['status_pembayaran'] === 'belum_lunas') {
                    $sisaTagihan = (float)$r['total_biaya'] - (float)$r['uang_muka'];
                    if ($sisaTagihan > 0) {
                        $tagihanBelumLunas[] = [
                            'id_sewa' => $r['id_sewa'],
                            'sisa'    => $sisaTagihan
                        ];
                    }
                }
            }

            // Update virtual timers
            $virtualTimers = session()->get('virtual_timers') ?? [];
            $activeTimers = [];
            $updatedTimers = false;
            foreach ($myRentals as $r) {
                if ($r['status_transaksi'] === 'berjalan') {
                    $idSewa = $r['id_sewa'];
                    if (!isset($virtualTimers[$idSewa])) {
                        $virtualTimers[$idSewa] = time() + 480;
                        $updatedTimers = true;
                    }
                    $activeTimers[$idSewa] = $virtualTimers[$idSewa];
                }
            }
            if ($updatedTimers) {
                session()->set('virtual_timers', $virtualTimers);
            }

            return $this->response->setJSON([
                'total_sewa'        => $totalSewa,
                'sewa_aktif'        => $sewaAktif,
                'total_pengeluaran' => (float)$totalPengeluaran,
                'update_time'       => date('H:i'),
                'active_timers'     => $activeTimers,
                'tagihan_belum_lunas'=> $tagihanBelumLunas,
                'mobil_list'        => $this->mobilModel->findAll()
            ]);
        }

        $today       = date('Y-m-d');
        $bulanIni    = (int)date('m');
        $tahunIni    = (int)date('Y');

        $statistikMobil = $this->mobilModel->getStatistik();
        $pendapatanHari = $this->penyewaanModel->getPendapatanHarian($today);
        $transaksiAktif = $this->penyewaanModel->countActive();
        $pendBulanan    = $this->penyewaanModel->getTotalPendapatanBulanan($bulanIni, $tahunIni);
        $biayaBulanan   = $this->biayaModel->getTotalBulanan($bulanIni, $tahunIni);
        $labaKotor      = $pendBulanan - $biayaBulanan;

        return $this->response->setJSON([
            'statistik_mobil'  => $statistikMobil,
            'pendapatan_hari'  => (float)$pendapatanHari,
            'transaksi_aktif'  => (int)$transaksiAktif,
            'pendapatan_bulan' => (float)$pendBulanan,
            'biaya_bulan'      => (float)$biayaBulanan,
            'laba_kotor'       => (float)$labaKotor,
            'update_time'      => date('H:i')
        ]);
    }
}
