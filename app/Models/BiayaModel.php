<?php

namespace App\Models;

use CodeIgniter\Model;

class BiayaModel extends Model
{
    protected $table         = 'operasional_biaya';
    protected $primaryKey    = 'id_biaya';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'kategori_biaya', 'jumlah_pengeluaran',
        'tanggal_pengeluaran', 'keterangan'
    ];
    protected $useTimestamps = false;

    public function getTotalBulanan(int $bulan, int $tahun): float
    {
        $result = $this->db->table('operasional_biaya')
            ->selectSum('jumlah_pengeluaran')
            ->where('MONTH(tanggal_pengeluaran)', $bulan)
            ->where('YEAR(tanggal_pengeluaran)', $tahun)
            ->get()->getRowArray();
        return (float)($result['jumlah_pengeluaran'] ?? 0);
    }

    public function getByBulan(int $bulan, int $tahun): array
    {
        return $this->where('MONTH(tanggal_pengeluaran)', $bulan)
            ->where('YEAR(tanggal_pengeluaran)', $tahun)
            ->findAll();
    }

    public function getTotalTahunan(int $tahun): float
    {
        $result = $this->db->table('operasional_biaya')
            ->selectSum('jumlah_pengeluaran')
            ->where('YEAR(tanggal_pengeluaran)', $tahun)
            ->get()->getRowArray();
        return (float)($result['jumlah_pengeluaran'] ?? 0);
    }
}
