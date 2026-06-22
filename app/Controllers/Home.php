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

    private function assignImageUrls(array $mobilList): array
    {
        $extensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
        foreach ($mobilList as &$mobil) {
            $mobil['image_url'] = ''; // fallback
            $found = false;
            
            $merek = strtoupper(trim($mobil['merek']));
            $model = strtoupper(trim($mobil['model']));
            
            // Kombinasi nama file yang mungkin ada di folder
            $possible_names = [
                $merek . ' ' . $model, // contoh: TOYOTA FORTUNER
                $model,                // contoh: BRIO SATYA
                $merek,
                'mobil-' . $mobil['id_mobil']
            ];

            // 1. Coba cari gambar berdasarkan kombinasi nama
            foreach ($possible_names as $name) {
                foreach ($extensions as $ext) {
                    if (file_exists(FCPATH . 'assets/images/' . $name . '.' . $ext)) {
                        // Ganti spasi dengan %20 agar URL valid
                        $safe_name = str_replace(' ', '%20', $name);
                        $mobil['image_url'] = base_url('assets/images/' . $safe_name . '.' . $ext);
                        $found = true;
                        break 2;
                    }
                }
            }

            // 2. Jika tidak ditemukan, cari mobil-default
            if (!$found) {
                foreach ($extensions as $ext) {
                    if (file_exists(FCPATH . 'assets/images/mobil-default.' . $ext)) {
                        $mobil['image_url'] = base_url('assets/images/mobil-default.' . $ext);
                        $found = true;
                        break;
                    }
                }
            }
            
            // 3. Fallback mutlak jika tidak ada gambar sama sekali
            if (!$found) {
                $mobil['image_url'] = 'https://ui-avatars.com/api/?name=' . urlencode($mobil['merek'] . '+' . $mobil['model']) . '&background=1a1f35&color=fff&size=400';
            }
        }
        return $mobilList;
    }

    public function index(): string
    {
        $data = [
            'mobil_list' => $this->assignImageUrls($this->mobilModel->findAll()),
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

        $mobil = $this->assignImageUrls($mobil);
        return $this->response->setJSON(['data' => $mobil]);
    }

    public function getStatistikAjax()
    {
        return $this->response->setJSON($this->mobilModel->getStatistik());
    }
}
