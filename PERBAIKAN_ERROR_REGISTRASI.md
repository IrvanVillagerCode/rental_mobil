# Perbaikan Error Registrasi: "Email Already In Use"

## Masalah
Error: `Registrasi gagal: Firebase: Error (auth/email-already-in-use)`

Terjadi ketika pengguna mencoba mendaftar dengan email yang sudah terdaftar di Firebase Authentication.

## Root Cause
- Email sudah terdaftar di Firebase Auth dari attempt registrasi sebelumnya
- Tidak ada validasi di frontend untuk mengecek email existence sebelum registrasi
- Error message dari Firebase terlalu teknis dan tidak user-friendly

## Solusi yang Diterapkan

### 1. **Frontend - Login View** (`app/Views/auth/login.php`)

#### A. Update `showError()` Function
Menggunakan `innerHTML` daripada `textContent` untuk support HTML formatting:
```javascript
function showError(msg) {
    document.getElementById('error-msg').innerHTML = msg;  // Support HTML tags
    document.getElementById('error-box').style.display = 'flex';
}
```

#### B. Pre-Registration Email Validation
Sebelum registrasi, cek email ke backend:
```javascript
// Cek apakah email sudah terdaftar di database lokal
const checkRes = await fetch(BASE_URL + 'auth/check-email-exists?email=' + encodeURIComponent(email));
const checkData = await checkRes.json();

if (checkData.exists) {
    showError('Email ini sudah terdaftar. <br><strong>Silakan login</strong> dengan akun Anda atau gunakan email lain untuk mendaftar.');
    return;
}
```

#### C. Enhanced Error Handling
Tangkap specific Firebase error codes dengan pesan yang lebih user-friendly:

```javascript
if (e.code === 'auth/email-already-in-use') {
    errorMsg = 'Email ini sudah terdaftar. <br><strong>Silakan login</strong> dengan akun Anda atau gunakan email lain untuk mendaftar.';
} else if (e.code === 'auth/weak-password') {
    errorMsg = 'Password terlalu lemah. Gunakan kombinasi huruf, angka, dan simbol.';
} else if (e.code === 'auth/invalid-email') {
    errorMsg = 'Format email tidak valid!';
} else if (e.code === 'auth/operation-not-allowed') {
    errorMsg = 'Registrasi sedang dinonaktifkan. Hubungi admin.';
}
```

#### D. Email Format Validation
Validasi format email sebelum submit:
```javascript
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if (!emailRegex.test(email)) {
    showError('Format email tidak valid!');
    return;
}
```

### 2. **Backend - Auth Controller** (`app/Controllers/Auth.php`)

Tambah method baru untuk check email existence:
```php
public function checkEmailExists(): \CodeIgniter\HTTP\ResponseInterface
{
    $email = $this->request->getGet('email') ?? '';
    
    if (empty($email)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Email tidak boleh kosong'
        ])->setStatusCode(400);
    }

    // Cek di database lokal
    $existingUser = $this->userModel->findByEmail($email);
    
    return $this->response->setJSON([
        'exists' => !empty($existingUser),
        'user'   => $existingUser
    ]);
}
```

### 3. **Route Configuration** (`app/Config/Routes.php`)

Tambah public route untuk email validation endpoint:
```php
$routes->get('/auth/check-email-exists', 'Auth::checkEmailExists');
```

## Flow Registrasi yang Diperbaiki

```
1. User input nama, email, password
2. Validasi format input (required, password length, email format)
3. [BARU] Cek email ke backend - apakah sudah terdaftar?
   ├─ Jika YES: Tampilkan error dengan saran login
   └─ Jika NO: Lanjut ke step 4
4. Submit ke Firebase untuk create account
5. Handle Firebase errors dengan specific error codes
   ├─ auth/email-already-in-use: Saran login
   ├─ auth/weak-password: Tingkatkan password strength
   ├─ auth/invalid-email: Cek format email
   └─ Lainnya: Tampilkan error message
6. Success: Redirect ke dashboard
```

## UX Improvements

✅ **Pre-submission validation** - Cek email sudah terdaftar SEBELUM submit ke Firebase
✅ **User-friendly error messages** - Bukan technical Firebase error codes
✅ **Actionable suggestions** - "Silakan login dengan akun Anda atau gunakan email lain"
✅ **HTML-formatted errors** - Support untuk `<br>` dan `<strong>` tags
✅ **Multiple error scenarios** - Handle berbagai kondisi error dengan pesan spesifik

## Testing

Untuk test perbaikan ini:

1. Buka halaman login: `http://localhost:8080/login`
2. Ke tab "Pelanggan"
3. **Scenario A - Email Sudah Terdaftar:**
   - Email: `admin.rental@gmail.com` (yang sudah ada)
   - Nama: Test User
   - Password: password123
   - → Seharusnya muncul error: "Email ini sudah terdaftar. **Silakan login** dengan akun Anda..."

4. **Scenario B - Email Baru:**
   - Email: `newemail@example.com`
   - Nama: New User
   - Password: securepass123
   - → Seharusnya berhasil registrasi dan redirect ke dashboard

## Files yang Diubah

- `app/Views/auth/login.php` - Update registerUser function & showError function
- `app/Controllers/Auth.php` - Tambah checkEmailExists method
- `app/Config/Routes.php` - Tambah route untuk check-email-exists endpoint
