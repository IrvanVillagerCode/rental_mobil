<?php

namespace App\Models;

use CodeIgniter\Model;

class MidtransTransactionModel extends Model
{
    protected $table            = 'midtrans_transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_sewa',
        'id_user',
        'order_id',
        'amount',
        'payment_method',
        'payment_type',
        'snap_token',
        'transaction_status',
        'midtrans_transaction_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
