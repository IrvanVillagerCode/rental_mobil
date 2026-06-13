<?php

namespace App\Models;

use CodeIgniter\Model;

class KondisiModel extends Model
{
    protected $table         = 'kondisi_kendaraan';
    protected $primaryKey    = 'id_kondisi';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'id_sewa', 'stnk_tersedia', 'bbm_keluar',
        'bbm_kembali', 'fisik_keluar', 'fisik_kembali'
    ];
    protected $useTimestamps = false;

    public function getBySewa(int $idSewa): ?array
    {
        return $this->where('id_sewa', $idSewa)->first();
    }
}
