<?php

namespace App\Models;

use CodeIgniter\Model;

class MobilModel extends Model
{
    protected $table         = 'mobil';
    protected $primaryKey    = 'id_mobil';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'merek',
        'model',
        'nopol_mobil',
        'tahun_perolehan',
        'harga_perolehan',
        'harga_sewa_perhari',
        'status_mobil'
    ];
    protected $useTimestamps = false;

    public function getMobilTersedia(): array
    {
        return $this->where('status_mobil', 'tersedia')->findAll();
    }

    public function getStatistik(): array
    {
        $db = \Config\Database::connect();

        return [
            'total'      => $db->table($this->table)->countAllResults(),
            'tersedia'   => $db->table($this->table)->where('status_mobil', 'tersedia')->countAllResults(),
            'disewa'     => $db->table($this->table)->where('status_mobil', 'disewa')->countAllResults(),
            'perawatan'  => $db->table($this->table)->where('status_mobil', 'perawatan')->countAllResults(),
        ];
    }
}
