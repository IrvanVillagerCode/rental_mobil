<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Tampilkan halaman login
    public function index(): \CodeIgniter\HTTP\ResponseInterface|string
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    // Endpoint AJAX: sinkronisasi session setelah Firebase sukses
    public function setSession(): \CodeIgniter\HTTP\ResponseInterface
    {
        $json = $this->request->getJSON(true);

        $uid   = $json['uid']   ?? '';
        $nama  = $json['nama']  ?? '';
        $email = $json['email'] ?? '';
        $role  = $json['role']  ?? 'user'; // Dikirim dari client berdasarkan email check

        if (empty($uid) || empty($email)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap'])->setStatusCode(400);
        }

        try {
            // Sync user ke DB lokal
            $this->userModel->syncFirebaseUser($uid, $nama, $email, $role);
        } catch (\Exception $e) {
            // Handle error duplikat email atau error lainnya
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan user: ' . $e->getMessage()
            ])->setStatusCode(400);
        }

        // Ambil role dari DB agar akurat
        $dbUser = $this->userModel->find($uid);

        // Jika user tidak ditemukan dengan uid baru, coba cari dengan email
        if (!$dbUser) {
            $dbUser = $this->userModel->findByEmail($email);
        }

        if (!$dbUser) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal membaca data user dari database'
            ])->setStatusCode(400);
        }

        $finalRole = $dbUser['role'] ?? 'user';

        // Simpan session
        session()->set([
            'logged_in'  => true,
            'uid'        => $dbUser['id_user'],
            'nama'       => $dbUser['nama_lengkap'] ?? $nama,
            'email'      => $email,
            'role'       => $finalRole,
        ]);

        return $this->response->setJSON([
            'status'   => 'ok',
            'role'     => $finalRole,
            'redirect' => base_url('dashboard'),
        ]);
    }

    // Logout: hapus session
    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
