<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BiayaModel;

class BiayaOperasional extends BaseController
{
    protected BiayaModel $biayaModel;

    public function __construct()
    {
        $this->biayaModel = new BiayaModel();
    }

    public function index(): string
    {
        return view('biaya/index', [
            'biaya_list' => $this->biayaModel->orderBy('tanggal_pengeluaran', 'DESC')->findAll(),
        ]);
    }

    public function create(): string
    {
        return view('biaya/create');
    }

    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->biayaModel->insert([
            'kategori_biaya'     => $this->request->getPost('kategori_biaya'),
            'jumlah_pengeluaran' => $this->request->getPost('jumlah_pengeluaran'),
            'tanggal_pengeluaran'=> $this->request->getPost('tanggal_pengeluaran'),
            'keterangan'         => $this->request->getPost('keterangan'),
        ]);
        return redirect()->to('/biaya')->with('success', 'Biaya operasional berhasil dicatat!');
    }

    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->biayaModel->delete($id);
        return redirect()->to('/biaya')->with('success', 'Data biaya berhasil dihapus!');
    }
}
