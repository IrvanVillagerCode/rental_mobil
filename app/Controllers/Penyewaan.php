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
        return view('penyewaan/create', [
            'mobil_tersedia' => $this->mobilModel->getMobilTersedia(),
        ]);
    }

    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $tglSewa    = $this->request->getPost('tgl_sewa');
        $tglKembali = $this->request->getPost('tgl_kembali');
        $idMobil    = (int)$this->request->getPost('id_mobil');
        $jenisSewa  = $this->request->getPost('jenis_sewa');
        $uangMuka   = (float)$this->request->getPost('uang_muka');

        // Hitung total biaya
        $mobil      = $this->mobilModel->find($idMobil);
        $durasi     = max(1, (int)((strtotime($tglKembali) - strtotime($tglSewa)) / 86400));
        $tarifSewa  = (float)$mobil['harga_sewa_perhari'];
        $tarifSopir = ($jenisSewa === 'dengan sopir') ? 200000 : 0;
        $totalBiaya = ($tarifSewa + $tarifSopir) * $durasi;

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
            'status_transaksi' => 'booking',
        ]);

        // Update status mobil
        $this->mobilModel->update($idMobil, ['status_mobil' => 'disewa']);

        // Simpan kondisi kendaraan keluar
        $this->kondisiModel->insert([
            'id_sewa'       => $idSewa,
            'stnk_tersedia' => $this->request->getPost('stnk_tersedia') ? 1 : 0,
            'bbm_keluar'    => $this->request->getPost('bbm_keluar'),
            'fisik_keluar'  => $this->request->getPost('fisik_keluar'),
        ]);

        return redirect()->to('/penyewaan')->with('success', 'Transaksi sewa berhasil ditambahkan!');
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
}
