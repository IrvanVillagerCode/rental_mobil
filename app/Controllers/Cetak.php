<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenyewaanModel;
use App\Models\KondisiModel;
use App\Models\BiayaModel;
use App\Models\MobilModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Cetak extends BaseController
{
    protected PenyewaanModel $penyewaanModel;
    protected KondisiModel $kondisiModel;
    protected BiayaModel $biayaModel;
    protected MobilModel $mobilModel;

    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel();
        $this->kondisiModel   = new KondisiModel();
        $this->biayaModel     = new BiayaModel();
        $this->mobilModel     = new MobilModel();
    }

    private function renderPdf(string $html, string $filename, string $paper = 'A4', string $orientation = 'portrait'): void
    {
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        $dompdf->stream($filename, ['Attachment' => false]);
        exit;
    }

    // Nota transaksi per ID sewa
    public function nota(int $id)
    {
        $sewa    = $this->penyewaanModel->getWithMobil($id);
        $kondisi = $this->kondisiModel->getBySewa($id);
        if (!$sewa) {
            return redirect()->to('/dashboard')->with('error', 'Data tidak ditemukan!');
        }

        // Security check: only allow admins or the user who owns the rental
        $role = session()->get('role');
        $uid  = session()->get('uid');
        if ($role !== 'admin' && $sewa['id_user'] !== $uid) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses ke nota ini!');
        }

        $html = view('cetak/nota_pdf', ['sewa' => $sewa, 'kondisi' => $kondisi]);
        $this->renderPdf($html, "Nota_Sewa_{$id}.pdf", 'A5', 'portrait');
    }

    // Laporan Harian
    public function harian(): void
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $data    = $this->penyewaanModel->getLaporanHarian($tanggal);
        $html    = view('cetak/laporan_harian', ['data' => $data, 'tanggal' => $tanggal]);
        $this->renderPdf($html, "Laporan_Harian_{$tanggal}.pdf");
    }

    // Laporan Bulanan
    public function bulanan(): void
    {
        $bulan   = (int)($this->request->getGet('bulan') ?? date('m'));
        $tahun   = (int)($this->request->getGet('tahun') ?? date('Y'));
        $data    = $this->penyewaanModel->getLaporanBulanan($bulan, $tahun);
        $biaya   = $this->biayaModel->getByBulan($bulan, $tahun);
        $totalPend = $this->penyewaanModel->getTotalPendapatanBulanan($bulan, $tahun);
        $totalBiaya = $this->biayaModel->getTotalBulanan($bulan, $tahun);
        $piutang = $this->penyewaanModel->getPiutang();

        $html = view('cetak/laporan_bulanan', compact('data', 'biaya', 'totalPend', 'totalBiaya', 'piutang', 'bulan', 'tahun'));
        $this->renderPdf($html, "Laporan_Bulanan_{$bulan}_{$tahun}.pdf");
    }

    // Laporan Tahunan
    public function tahunan(): void
    {
        $tahun      = (int)($this->request->getGet('tahun') ?? date('Y'));
        $data       = $this->penyewaanModel->getLaporanTahunan($tahun);
        $totalPend  = $this->penyewaanModel->getTotalPendapatanBulanan(0, $tahun); // override below
        // Total pendapatan tahunan
        $totalPend  = 0;
        foreach ($data as $d) { $totalPend += (float)$d['total_biaya']; }
        $totalBiaya = $this->biayaModel->getTotalTahunan($tahun);
        $labaBersih = $totalPend - $totalBiaya;

        // Penyusutan kendaraan (15% per tahun dari harga perolehan)
        $armada     = $this->mobilModel->findAll();
        foreach ($armada as &$m) {
            $usia = $tahun - (int)$m['tahun_perolehan'];
            $m['penyusutan'] = (float)$m['harga_perolehan'] * 0.15 * max(1, $usia);
            $m['nilai_buku'] = max(0, (float)$m['harga_perolehan'] - $m['penyusutan']);
        }
        unset($m);

        $html = view('cetak/laporan_tahunan', compact('data', 'armada', 'totalPend', 'totalBiaya', 'labaBersih', 'tahun'));
        $this->renderPdf($html, "Laporan_Tahunan_{$tahun}.pdf");
    }
}
