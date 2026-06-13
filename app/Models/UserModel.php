<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_user', 'nama_lengkap', 'email', 'role'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = '';

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

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
            // atau return false untuk mencegah duplikat
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
}
