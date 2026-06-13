<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MobilModel;

class Mobil extends BaseController
{
    protected MobilModel $mobilModel;

    public function __construct()
    {
        $this->mobilModel = new MobilModel();
    }

    public function index(): string
    {
        return view('mobil/index', [
            'mobil_list' => $this->mobilModel->findAll(),
        ]);
    }

    public function create(): string
    {
        return view('mobil/create');
    }

    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'merek'             => 'required|min_length[2]',
            'model'             => 'required|min_length[2]',
            'nopol_mobil'       => 'required|is_unique[mobil.nopol_mobil]',
            'tahun_perolehan'   => 'required|integer',
            'harga_perolehan'   => 'required|decimal',
            'harga_sewa_perhari'=> 'required|decimal',
            'status_mobil'      => 'required|in_list[tersedia,disewa,perawatan]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mobilModel->insert([
            'merek'              => $this->request->getPost('merek'),
            'model'              => $this->request->getPost('model'),
            'nopol_mobil'        => strtoupper($this->request->getPost('nopol_mobil')),
            'tahun_perolehan'    => $this->request->getPost('tahun_perolehan'),
            'harga_perolehan'    => $this->request->getPost('harga_perolehan'),
            'harga_sewa_perhari' => $this->request->getPost('harga_sewa_perhari'),
            'status_mobil'       => $this->request->getPost('status_mobil'),
        ]);

        return redirect()->to('/mobil')->with('success', 'Armada berhasil ditambahkan!');
    }

    public function edit(int $id): string
    {
        $mobil = $this->mobilModel->find($id);
        if (!$mobil) {
            return redirect()->to('/mobil')->with('error', 'Data tidak ditemukan!');
        }
        return view('mobil/edit', ['mobil' => $mobil]);
    }

    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'merek'              => 'required|min_length[2]',
            'model'              => 'required|min_length[2]',
            'nopol_mobil'        => "required|is_unique[mobil.nopol_mobil,id_mobil,{$id}]",
            'tahun_perolehan'    => 'required|integer',
            'harga_perolehan'    => 'required|decimal',
            'harga_sewa_perhari' => 'required|decimal',
            'status_mobil'       => 'required|in_list[tersedia,disewa,perawatan]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mobilModel->update($id, [
            'merek'              => $this->request->getPost('merek'),
            'model'              => $this->request->getPost('model'),
            'nopol_mobil'        => strtoupper($this->request->getPost('nopol_mobil')),
            'tahun_perolehan'    => $this->request->getPost('tahun_perolehan'),
            'harga_perolehan'    => $this->request->getPost('harga_perolehan'),
            'harga_sewa_perhari' => $this->request->getPost('harga_sewa_perhari'),
            'status_mobil'       => $this->request->getPost('status_mobil'),
        ]);

        return redirect()->to('/mobil')->with('success', 'Data armada berhasil diperbarui!');
    }

    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->mobilModel->delete($id);
        return redirect()->to('/mobil')->with('success', 'Armada berhasil dihapus!');
    }
}
