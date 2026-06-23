<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    public $serverKey = '';
    public $clientKey = '';
    public $isProduction = false;
    public $isSanitized = true;
    public $is3ds = true;

    public function __construct()
    {
        parent::__construct();
        $this->serverKey = getenv('MIDTRANS_SERVER_KEY') ?: 'SB-Mid-server-TnmOmhzMQzZf7ZqB05hK0kPz';
        $this->clientKey = getenv('MIDTRANS_CLIENT_KEY') ?: 'SB-Mid-client-nS8aQ_t34B16_9gI';
        $this->isProduction = getenv('MIDTRANS_IS_PRODUCTION') === 'true';
    }
}
