# Perbaikan Error: Duplicate entry 'admin.rental@gmail.com'

## Masalah

Error: `Duplicate entry 'admin.rental@gmail.com' for key 'users.email_unique'`

Terjadi karena method `syncFirebaseUser()` di UserModel hanya melakukan pengecekan berdasarkan `id_user`, bukan berdasarkan `email`. Ketika pengguna login dengan Firebase UID yang berbeda tetapi menggunakan email yang sama, sistem mencoba memasukkan duplikat email ke database, yang melanggar UNIQUE constraint.

## Solusi yang Diterapkan

### 1. Perbaiki UserModel.php

**File**: `app/Models/UserModel.php`

Perubahan method `syncFirebaseUser()`:

- ✅ Cek apakah user dengan uid sudah ada → Update jika ada
- ✅ Cek apakah email sudah terdaftar dengan uid berbeda → Update record lama
- ✅ Insert user baru hanya jika keduanya belum ada

```php
public function syncFirebaseUser(string $uid, string $nama, string $email, string $role = 'user'): bool
{
    // Cek apakah user dengan uid ini sudah ada
    $existing = $this->find($uid);
    if ($existing) {
        // Update data user jika sudah ada
        return $this->update($uid, [
            'nama_lengkap' => $nama,
            'email'        => $email,
            'role'         => $role,
        ]);
    }

    // Cek apakah email sudah terdaftar dengan uid berbeda
    $emailExists = $this->findByEmail($email);
    if ($emailExists) {
        // Email sudah ada, update uid lama dengan data baru
        return $this->update($emailExists['id_user'], [
            'id_user'      => $uid,
            'nama_lengkap' => $nama,
            'role'         => $role,
        ]);
    }

    // Insert user baru
    return $this->insert([
        'id_user'      => $uid,
        'nama_lengkap' => $nama,
        'email'        => $email,
        'role'         => $role,
    ]);
}
```

### 2. Perbaiki Auth Controller

**File**: `app/Controllers/Auth.php`

Perubahan method `setSession()`:

- ✅ Tambahkan try-catch untuk error handling
- ✅ Cari user by email jika uid tidak ditemukan
- ✅ Validasi data sebelum menyimpan session
- ✅ Pesan error lebih deskriptif

### 3. Script Pembersihan Database

Dua script helper dibuat untuk diagnostik:

- `check_duplicates.php` - Cek duplikat email di database
- `cleanup_duplicates.php` - Bersihkan duplikat jika ada
- `check_structure.php` - Lihat struktur tabel dan constraints

## Hasil Verifikasi

```
=== Email Duplikat ===
(Tidak ada duplikat ditemukan)

=== Data User Setelah Pembersihan ===
ID: fb_uid_admin_112233, Email: admin.rental@gmail.com
ID: fb_uid_user_445566, Email: budi.santoso@gmail.com
ID: A4H6Cq6f9cdJkumHvmaOBcE3Rq42, Email: irvanagussaputra710@gmail.com
ID: fb_uid_user_778899, Email: siti.aminah@gmail.com
```

## Testing

Untuk menguji perbaikan:

1. Buka aplikasi dan coba login sebagai admin@rental.gmail.com dari berbagai device/browser
2. Seharusnya tidak akan muncul error duplikat lagi
3. Data user akan terupdate bukan ditambah duplikat

## Catatan

- Struktur tabel sudah memiliki constraint `email_unique` pada kolom `email`
- Primary key adalah `id_user` (varchar)
- Email adalah varchar(100) dengan UNIQUE constraint
