<?php

namespace App\Controllers;

use App\Models\MobilModel;

class Home extends BaseController
{
    protected MobilModel $mobilModel;

    public function __construct()
    {
        $this->mobilModel = new MobilModel();
    }

    public function index(): string
    {
        $data = [
            'mobil_list' => $this->mobilModel->findAll(),
            'statistik'  => $this->mobilModel->getStatistik(),
        ];
        return view('home/index', $data);
    }

    public function getMobilAjax()
    {
        $search = $this->request->getGet('search') ?? '';
        $mobil = $this->mobilModel->findAll();

        if (!empty($search)) {
            $mobil = array_filter($mobil, function ($item) use ($search) {
                $search_lower = strtolower($search);
                return strpos(strtolower($item['merek']), $search_lower) !== false ||
                    strpos(strtolower($item['model']), $search_lower) !== false;
            });
            $mobil = array_values($mobil);
        }

        return $this->response->setJSON(['data' => $mobil]);
    }

    public function getStatistikAjax()
    {
        return $this->response->setJSON($this->mobilModel->getStatistik());
    }
}
