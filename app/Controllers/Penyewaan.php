<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenyewaanModel;
use App\Models\MobilModel;
use App\Models\KondisiModel;

class Penyewaan extends BaseController
{
    protected PenyewaanModel $penyewaanModel;
    protected MobilModel $mobilModel;
    protected KondisiModel $kondisiModel;

    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel();
        $this->mobilModel     = new MobilModel();
        $this->kondisiModel   = new KondisiModel();
    }

    public function index(): string
    {
        return view('penyewaan/index', [
            'penyewaan_list' => $this->penyewaanModel->getWithMobil(),
        ]);
    }

    public function create(): string
    {
        $selectedMobilId = (int)$this->request->getGet('mobil');

        return view('penyewaan/create', [
            'mobil_tersedia'    => $this->mobilModel->getMobilTersedia(),
            'selected_mobil_id' => $selectedMobilId
        ]);
    }

    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $role       = session()->get('role');
        $tglSewa    = $this->request->getPost('tgl_sewa');
        $tglKembali = $this->request->getPost('tgl_kembali');
        $idMobil    = (int)$this->request->getPost('id_mobil');
        $jenisSewa  = $this->request->getPost('jenis_sewa');

        // Hitung total biaya
        $mobil      = $this->mobilModel->find($idMobil);
        if (!$mobil) {
            return redirect()->back()->with('error', 'Mobil tidak ditemukan!')->withInput();
        }

        if ($mobil['status_mobil'] !== 'tersedia') {
            return redirect()->back()->with('error', 'Mobil ' . $mobil['merek'] . ' ' . $mobil['model'] . ' sedang tidak tersedia untuk disewa saat ini!')->withInput();
        }

        $durasi     = max(1, (int)((strtotime($tglKembali) - strtotime($tglSewa)) / 86400));
        $tarifSewa  = (float)$mobil['harga_sewa_perhari'];
        $tarifSopir = ($jenisSewa === 'dengan sopir') ? 200000 : 0;
        $totalBiaya = ($tarifSewa + $tarifSopir) * $durasi;

        $isAdmin    = ($role === 'admin');
        $uangMuka   = $isAdmin ? (float)$this->request->getPost('uang_muka') : 0.0;

        $metodePembayaran = $this->request->getPost('metode_pembayaran'); // online | langsung
        if ($isAdmin) {
            $metodePembayaran = 'langsung';
            $statusPembayaran = ($uangMuka >= $totalBiaya) ? 'lunas' : 'belum_lunas';
            $statusTransaksi  = 'booking';
        } else {
            if ($metodePembayaran === 'online') {
                $statusPembayaran = 'menunggu';
                $statusTransaksi  = 'menunggu_pembayaran';
            } else {
                $metodePembayaran = 'langsung';
                $statusPembayaran = 'menunggu';
                $statusTransaksi  = 'menunggu_konfirmasi';
            }
        }

        $idSewa = $this->penyewaanModel->insert([
            'id_user'          => session()->get('uid'),
            'id_mobil'         => $idMobil,
            'nama_penyewa'     => $this->request->getPost('nama_penyewa'),
            'kontak'           => $this->request->getPost('kontak'),
            'tgl_sewa'         => $tglSewa,
            'tgl_kembali'      => $tglKembali,
            'jenis_sewa'       => $jenisSewa,
            'uang_muka'        => $uangMuka,
            'pelunasan'        => 0,
            'denda'            => 0,
            'total_biaya'      => $totalBiaya,
            'metode_pembayaran'=> $metodePembayaran,
            'status_pembayaran'=> $statusPembayaran,
            'status_transaksi' => $statusTransaksi,
        ]);

        // Simpan kondisi kendaraan keluar
        $this->kondisiModel->insert([
            'id_sewa'       => $idSewa,
            'stnk_tersedia' => $isAdmin ? ($this->request->getPost('stnk_tersedia') ? 1 : 0) : 1,
            'bbm_keluar'    => $isAdmin ? $this->request->getPost('bbm_keluar') : 'Full',
            'fisik_keluar'  => $isAdmin ? $this->request->getPost('fisik_keluar') : 'Mulus, siap pakai',
        ]);

        // Update status mobil (hanya jika langsung booking, jika nunggu online biarkan saja/bisa diubah saat lunas)
        // Tetapi agar mobil tidak dibooking ganda, kita tandai disewa.
        $this->mobilModel->update($idMobil, ['status_mobil' => 'disewa']);

        if ($isAdmin) {
            return redirect()->to('/penyewaan')->with('success', 'Transaksi sewa berhasil ditambahkan!');
        } else {
            if ($metodePembayaran === 'online') {
                return redirect()->to('/penyewaan/bayar-online/' . $idSewa);
            }
            return redirect()->to('/dashboard')->with('success', 'Booking berhasil diajukan! Menunggu konfirmasi admin.');
        }
    }

    public function extendAjax(int $id)
    {
        $sewa = $this->penyewaanModel->find($id);
        if (!$sewa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Transaksi tidak ditemukan'])->setStatusCode(404);
        }

        // Security check
        $uid = session()->get('uid');
        if ($sewa['id_user'] !== $uid) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Akses ditolak'])->setStatusCode(403);
        }

        // Update database: extend tgl_kembali by 1 day and increase total_biaya
        $mobil = $this->mobilModel->find($sewa['id_mobil']);
        $tarifSewa = (float)$mobil['harga_sewa_perhari'];
        $tarifSopir = ($sewa['jenis_sewa'] === 'dengan sopir') ? 200000 : 0;
        
        $newTglKembali = date('Y-m-d', strtotime($sewa['tgl_kembali'] . ' + 1 day'));
        $newTotalBiaya = (float)$sewa['total_biaya'] + ($tarifSewa + $tarifSopir);

        $this->penyewaanModel->update($id, [
            'tgl_kembali' => $newTglKembali,
            'total_biaya' => $newTotalBiaya
        ]);

        // Update virtual timer in session: add 10 minutes (600 seconds) for the demo
        $virtualTimers = session()->get('virtual_timers') ?? [];
        if (isset($virtualTimers[$id])) {
            $virtualTimers[$id] = max($virtualTimers[$id], time()) + 600; // Extend by 10 minutes
        } else {
            $virtualTimers[$id] = time() + 600;
        }
        session()->set('virtual_timers', $virtualTimers);

        return $this->response->setJSON([
            'status' => 'ok',
            'message' => 'Sewa berhasil diperpanjang 1 hari!',
            'new_tgl_kembali' => date('d/m/Y', strtotime($newTglKembali)),
            'new_total_biaya' => number_format($newTotalBiaya, 0, ',', '.')
        ]);
    }

    public function edit(int $id): string
    {
        $sewa = $this->penyewaanModel->getWithMobil($id);
        if (!$sewa) {
            return redirect()->to('/penyewaan')->with('error', 'Data tidak ditemukan!');
        }
        $kondisi = $this->kondisiModel->getBySewa($id);
        return view('penyewaan/edit', [
            'sewa'           => $sewa,
            'kondisi'        => $kondisi,
            'mobil_list'     => $this->mobilModel->findAll(),
        ]);
    }

    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $pelunasan       = (float)$this->request->getPost('pelunasan');
        $denda           = (float)$this->request->getPost('denda');
        $statusTransaksi = $this->request->getPost('status_transaksi');

        $sewa = $this->penyewaanModel->find($id);

        $this->penyewaanModel->update($id, [
            'pelunasan'        => $pelunasan,
            'denda'            => $denda,
            'status_transaksi' => $statusTransaksi,
        ]);

        // Update kondisi kembali jika selesai
        if ($statusTransaksi === 'selesai') {
            $this->kondisiModel->where('id_sewa', $id)->set([
                'bbm_kembali'   => $this->request->getPost('bbm_kembali'),
                'fisik_kembali' => $this->request->getPost('fisik_kembali'),
            ])->update();

            // Bebaskan mobil
            $this->mobilModel->update($sewa['id_mobil'], ['status_mobil' => 'tersedia']);
        }

        if ($statusTransaksi === 'dibatalkan') {
            $this->mobilModel->update($sewa['id_mobil'], ['status_mobil' => 'tersedia']);
        }

        return redirect()->to('/penyewaan')->with('success', 'Data penyewaan berhasil diperbarui!');
    }

    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $sewa = $this->penyewaanModel->find($id);
        if ($sewa) {
            $this->mobilModel->update($sewa['id_mobil'], ['status_mobil' => 'tersedia']);
        }
        $this->penyewaanModel->delete($id);
        return redirect()->to('/penyewaan')->with('success', 'Data berhasil dihapus!');
    }

    public function bayarOnline(int $id)
    {
        $sewa = $this->penyewaanModel->getWithMobil($id);
        if (!$sewa || $sewa['id_user'] !== session()->get('uid')) {
            return redirect()->to('/dashboard')->with('error', 'Transaksi tidak ditemukan!');
        }

        if ($sewa['status_pembayaran'] === 'lunas') {
            return redirect()->to('/dashboard')->with('success', 'Pembayaran sudah lunas.');
        }

        return view('pembayaran/online', ['sewa' => $sewa]);
    }

    public function prosesBayarOnline(int $id)
    {
        $sewa = $this->penyewaanModel->find($id);
        if (!$sewa || $sewa['id_user'] !== session()->get('uid')) {
            return redirect()->to('/dashboard')->with('error', 'Transaksi tidak ditemukan!');
        }

        $nominalBayar = (float)$this->request->getPost('nominal_bayar');
        $uangMukaLama = (float)$sewa['uang_muka'];
        $totalBiaya   = (float)$sewa['total_biaya'];
        
        $totalBayarSekarang = $uangMukaLama + $nominalBayar;
        // Pastikan tidak melebihi total biaya
        if ($totalBayarSekarang > $totalBiaya) {
            $totalBayarSekarang = $totalBiaya;
        }

        $statusPembayaran = ($totalBayarSekarang >= $totalBiaya) ? 'lunas' : 'belum_lunas';

        $this->penyewaanModel->update($id, [
            'status_pembayaran' => $statusPembayaran,
            'status_transaksi'  => 'berjalan', // Boleh jalan walau belum lunas (ada sisa tagihan)
            'uang_muka'         => $totalBayarSekarang 
        ]);

        if ($statusPembayaran === 'belum_lunas') {
            return redirect()->to('/dashboard')->with('warning', 'Pembayaran sebagian (DP) berhasil diterima! Sisa tagihan belum lunas.');
        }

        return redirect()->to('/penyewaan/invoice/' . $id)->with('success', 'Pembayaran berhasil lunas! Berikut nota Anda.');
    }

    public function approve(int $id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $this->penyewaanModel->update($id, [
            'status_transaksi' => 'berjalan' // disetujui admin, langsung berjalan
        ]);

        return redirect()->to('/penyewaan')->with('success', 'Booking berhasil disetujui!');
    }

    public function invoice(int $id)
    {
        $sewa = $this->penyewaanModel->getWithMobil($id);
        if (!$sewa) {
            return redirect()->to('/')->with('error', 'Transaksi tidak ditemukan');
        }

        if (session()->get('role') !== 'admin' && $sewa['id_user'] !== session()->get('uid')) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        return view('penyewaan/invoice', ['sewa' => $sewa]);
    }
}
