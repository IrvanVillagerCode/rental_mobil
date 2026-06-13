# 🚗 Sistem Informasi Rental Mobil - Kelompok 2

Aplikasi berbasis web manajemen rental mobil modern yang dibangun menggunakan arsitektur **Object-Oriented Programming (OOP)** dengan Framework **CodeIgniter 4**, integrasi **Firebase Authentication**, dan database **MySQL**. Proyek ini dikembangkan untuk memenuhi tugas besar mata kuliah Pemrograman Web / Rekayasa Perangkat Lunak.

---

## 👥 Anggota Kelompok 2
* **Irvan Agus Saputra** - 312410263
* **Adnan Adha Febryan**- 312410622
* **Bagus Sulistyo** - 312410011

---

## 🚀 Fitur Utama Sistem

### 1. Multi-Role Authentication (Firebase Auth)
Mengamankan gerbang masuk aplikasi dengan memisahkan hak akses antara pengelola dan pelanggan:
* **Admin Dashboard:** Autentikasi menggunakan kombinasi *Email & Password* melalui Firebase Auth Core.
* **User/Pelanggan:** Autentikasi instan menggunakan akun Google (*Single Sign-On*) dan fitur registrasi mandiri.
* **Secure Redirect & Error Handling:** Dilengkapi proteksi *server-side session validation* (CI4 Filters). Jika login gagal atau data salah, sistem otomatis menampilkan notifikasi error dan mengarahkan kembali ke halaman login.

### 2. Manajemen CRUD Transaksi (OOP-Driven)
Manajemen data operasional rental yang dikelola secara terstruktur dengan konsep MVC murni:
* **Create:** Input data sewa baru (Unit mobil, jenis sewa lepas kunci/sopir, biaya sewa, DP, dan tanggal operasional).
* **Read:** Monitoring ketersediaan armada, detail penyewa aktif, dan riwayat transaksi secara real-time.
* **Update:** Fleksibilitas pembaruan data untuk perpanjangan waktu sewa, kalkulasi denda keterlambatan, dan pelunasan kas.
* **Delete:** Fitur penghapusan atau pengarsipan data transaksi lama demi efisiensi database.

### 3. Cetak Dokumen & Laporan Kustom (PDF Engine)
Fitur cetak dokumen digital berbasis HTML-to-PDF menggunakan library **Dompdf** yang desain layout-nya dapat disesuaikan (*customizable*):
* **Cetak Nota Sewa:** Bukti transaksi otentik untuk pelanggan saat unit keluar atau masuk (Format A5).
* **Laporan Harian:** Log manifest penyewa, *Checklist* kondisi fisik mobil (BBM & baret bodi), serta rekapitulasi penerimaan kas harian.
* **Laporan Bulanan:** Evaluasi laporan Laba-Rugi bulanan, rekap biaya servis berkala, kompilasi penagihan (*Invoice*), dan daftar piutang sewa.
* **Laporan Tahunan:** Rekapitulasi finansial tahunan, Neraca Keuangan (*Asset, Kewajiban, Ekuitas*), serta perhitungan nilai penyusutan (*depresiasi*) aset kendaraan.

---

## 🛠️ Tech Stack & Library
* **Backend:** PHP 8.1+, Framework CodeIgniter 4
* **Database:** MySQL / MariaDB Engine
* **Autentikasi:** Firebase Auth Client SDK v10.x
* **Renderer PDF:** Dompdf v2.0+
* **Frontend:** Bootstrap 5, Modern Vanilla JS (Fetch API), HTML5, CSS3

---

## 📦 Cara Instalasi Proyek di Lokal

1. **Clone Repositori:**
   ```bash
   git clone [https://github.com/IrvanVillagerCode/](https://github.com/IrvanVillagerCode/)[nama-repo-anda].git
   cd [nama-repo-anda]
