<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyewaanModel extends Model
{
    protected $table         = 'penyewaan';
    protected $primaryKey    = 'id_sewa';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'id_user', 'id_mobil', 'nama_penyewa', 'kontak',
        'tgl_sewa', 'tgl_kembali', 'jenis_sewa',
        'uang_muka', 'pelunasan', 'denda', 'total_biaya', 'status_transaksi'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getWithMobil(?int $id = null): mixed
    {
        $builder = $this->db->table('penyewaan p')
            ->select('p.*, m.merek, m.model, m.nopol_mobil, m.harga_sewa_perhari')
            ->join('mobil m', 'm.id_mobil = p.id_mobil', 'left')
            ->orderBy('p.created_at', 'DESC');
        if ($id !== null) {
            return $builder->where('p.id_sewa', $id)->get()->getRowArray();
        }
        return $builder->get()->getResultArray();
    }

    public function getPendapatanHarian(string $tanggal): float
    {
        $result = $this->db->table('penyewaan')
            ->selectSum('total_biaya')
            ->where('tgl_sewa', $tanggal)
            ->whereIn('status_transaksi', ['berjalan', 'selesai'])
            ->get()->getRowArray();
        return (float)($result['total_biaya'] ?? 0);
    }

    public function getLaporanHarian(string $tanggal): array
    {
        return $this->db->table('penyewaan p')
            ->select('p.*, m.merek, m.model, m.nopol_mobil')
            ->join('mobil m', 'm.id_mobil = p.id_mobil', 'left')
            ->where('p.tgl_sewa', $tanggal)
            ->get()->getResultArray();
    }

    public function getLaporanBulanan(int $bulan, int $tahun): array
    {
        return $this->db->table('penyewaan p')
            ->select('p.*, m.merek, m.model, m.nopol_mobil')
            ->join('mobil m', 'm.id_mobil = p.id_mobil', 'left')
            ->where('MONTH(p.tgl_sewa)', $bulan)
            ->where('YEAR(p.tgl_sewa)', $tahun)
            ->get()->getResultArray();
    }

    public function getLaporanTahunan(int $tahun): array
    {
        return $this->db->table('penyewaan p')
            ->select('p.*, m.merek, m.model, m.nopol_mobil')
            ->join('mobil m', 'm.id_mobil = p.id_mobil', 'left')
            ->where('YEAR(p.tgl_sewa)', $tahun)
            ->get()->getResultArray();
    }

    public function getTotalPendapatanBulanan(int $bulan, int $tahun): float
    {
        $result = $this->db->table('penyewaan')
            ->selectSum('total_biaya')
            ->where('MONTH(tgl_sewa)', $bulan)
            ->where('YEAR(tgl_sewa)', $tahun)
            ->whereIn('status_transaksi', ['berjalan', 'selesai'])
            ->get()->getRowArray();
        return (float)($result['total_biaya'] ?? 0);
    }

    public function getPiutang(): array
    {
        return $this->db->table('penyewaan p')
            ->select('p.*, m.merek, m.model, m.nopol_mobil')
            ->join('mobil m', 'm.id_mobil = p.id_mobil', 'left')
            ->where('p.pelunasan', 0)
            ->whereIn('p.status_transaksi', ['selesai'])
            ->get()->getResultArray();
    }

    public function countActive(): int
    {
        return $this->whereIn('status_transaksi', ['booking', 'berjalan'])->countAllResults();
    }
}
