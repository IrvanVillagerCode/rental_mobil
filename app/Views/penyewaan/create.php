<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>

<?php
$isAdmin = (session()->get('role') === 'admin');
$namaPenyewa = !$isAdmin ? session()->get('nama') : old('nama_penyewa');
$backUrl = $isAdmin ? base_url('penyewaan') : base_url('dashboard');
$title = $isAdmin ? 'Tambah Transaksi Sewa' : 'Booking Kendaraan';
$pageTitle = $title;
?>

<div class="page-header">
    <h2><i class="bi bi-plus-circle"></i> <?= $title ?></h2>
    <a href="<?= $backUrl ?>" class="btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="max-width:800px">
    <form action="<?= base_url('penyewaan/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div style="font-size:0.85rem;font-weight:700;color:var(--accent);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border)">
            <i class="bi bi-person-fill"></i> Data Penyewa
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Nama Penyewa</label>
                <input type="text" name="nama_penyewa" class="form-control" placeholder="Nama lengkap" required value="<?= esc($namaPenyewa) ?>" <?= !$isAdmin ? 'readonly' : '' ?>>
            </div>
            <div class="form-group">
                <label>Nomor Kontak (WhatsApp)</label>
                <input type="text" name="kontak" class="form-control" placeholder="08xxxxxxxxxx" required value="<?= old('kontak') ?>">
            </div>
        </div>

        <div style="font-size:0.85rem;font-weight:700;color:var(--accent);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border);margin-top:8px">
            <i class="bi bi-car-front-fill"></i> Data Kendaraan & Sewa
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Pilih Armada</label>
                <select name="id_mobil" id="id_mobil" class="form-control" required>
                    <option value="">-- Pilih Kendaraan Tersedia --</option>
                    <?php foreach ($mobil_tersedia as $m): ?>
                    <option value="<?= $m['id_mobil'] ?>" data-tarif="<?= $m['harga_sewa_perhari'] ?>" <?= ($m['id_mobil'] == $selected_mobil_id) ? 'selected' : '' ?>>
                        <?= esc($m['merek'] . ' ' . $m['model']) ?> (<?= $m['nopol_mobil'] ?>) – Rp <?= number_format($m['harga_sewa_perhari'], 0, ',', '.') ?>/hari
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jenis Sewa</label>
                <select name="jenis_sewa" id="jenis_sewa" class="form-control" required>
                    <option value="lepas kunci">🔑 Lepas Kunci</option>
                    <option value="dengan sopir">🧑‍✈️ Dengan Sopir (+Rp 200.000/hari)</option>
                </select>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label><i class="bi bi-calendar-event"></i> Tanggal Mulai Sewa</label>
                <input type="date" name="tgl_sewa" id="tgl_sewa" class="form-control" required value="<?= old('tgl_sewa', date('Y-m-d')) ?>">
            </div>
            <div class="form-group">
                <label><i class="bi bi-calendar-check"></i> Tanggal Kembali</label>
                <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" required value="<?= old('tgl_kembali') ?>">
            </div>
        </div>

        <?php if (!$isAdmin): ?>
        <div style="font-size:0.85rem;font-weight:700;color:var(--accent);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border);margin-top:8px">
            <i class="bi bi-credit-card-fill"></i> Metode Pembayaran
        </div>
        <div class="form-group" style="margin-bottom:16px;">
            <label style="display:none">Pilih Metode Pembayaran</label>
            <div style="display:flex; gap:16px; flex-wrap:wrap; margin-top:8px;">
                <label style="display:flex; align-items:center; gap:12px; background:var(--surface); padding:16px; border:1px solid var(--border); border-radius:8px; cursor:pointer; flex:1; transition:all 0.2s">
                    <input type="radio" name="metode_pembayaran" value="online" required style="width:20px;height:20px;accent-color:var(--primary)">
                    <div style="display:flex; flex-direction:column;">
                        <span style="font-weight:700; color:var(--text-main)"><i class="bi bi-phone"></i> Pembayaran Online</span>
                        <span style="font-size:0.85rem; color:var(--text-muted); margin-top:4px">Bank Transfer / E-Wallet (Otomatis)</span>
                    </div>
                </label>
                <label style="display:flex; align-items:center; gap:12px; background:var(--surface); padding:16px; border:1px solid var(--border); border-radius:8px; cursor:pointer; flex:1; transition:all 0.2s">
                    <input type="radio" name="metode_pembayaran" value="langsung" required style="width:20px;height:20px;accent-color:var(--primary)">
                    <div style="display:flex; flex-direction:column;">
                        <span style="font-weight:700; color:var(--text-main)"><i class="bi bi-cash"></i> Bayar Langsung</span>
                        <span style="font-size:0.85rem; color:var(--text-muted); margin-top:4px">Konfirmasi manual oleh Admin</span>
                    </div>
                </label>
            </div>
        </div>
        <?php endif; ?>

        <!-- Preview Total -->
        <div id="total_biaya_preview" style="background:rgba(108,99,255,0.1);border:1px solid rgba(108,99,255,0.3);border-radius:8px;padding:12px 16px;font-weight:700;color:var(--accent-light);margin-bottom:16px;display:none">
        </div>

        <?php if ($isAdmin): ?>
        <div class="form-grid">
            <div class="form-group">
                <label><i class="bi bi-cash"></i> Uang Muka (DP)</label>
                <input type="number" name="uang_muka" class="form-control" placeholder="0" min="0" value="<?= old('uang_muka', 0) ?>">
            </div>
        </div>

        <div style="font-size:0.85rem;font-weight:700;color:var(--accent);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border);margin-top:8px">
            <i class="bi bi-clipboard2-check"></i> Kondisi Kendaraan Keluar
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Level BBM Saat Keluar</label>
                <select name="bbm_keluar" class="form-control">
                    <option value="Full">⛽ Full</option>
                    <option value="3/4">⛽ 3/4</option>
                    <option value="Half">⛽ Half</option>
                    <option value="1/4">⛽ 1/4</option>
                </select>
            </div>
            <div class="form-group">
                <label>STNK Tersedia</label>
                <select name="stnk_tersedia" class="form-control">
                    <option value="1">✅ Ya, STNK ada</option>
                    <option value="0">❌ Tidak ada</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Catatan Kondisi Fisik Keluar (baret, lecet, dll)</label>
            <textarea name="fisik_keluar" class="form-control" rows="3" placeholder="Contoh: Mulus, ban serep lengkap, tidak ada kerusakan"><?= old('fisik_keluar') ?></textarea>
        </div>
        <?php endif; ?>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="bi bi-save"></i> <?= $isAdmin ? 'Simpan Transaksi' : 'Ajukan Booking' ?></button>
            <a href="<?= $backUrl ?>" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
// Show preview when values change
function updatePreview() {
    const tgl1   = document.getElementById('tgl_sewa').value;
    const tgl2   = document.getElementById('tgl_kembali').value;
    const mobil  = document.getElementById('id_mobil');
    const jenis  = document.getElementById('jenis_sewa').value;
    const preview = document.getElementById('total_biaya_preview');

    if (!tgl1 || !tgl2 || !mobil.value) { preview.style.display='none'; return; }

    const d1    = new Date(tgl1);
    const d2    = new Date(tgl2);
    const durasi = Math.max(1, Math.ceil((d2 - d1) / 86400000));
    const tarif  = parseFloat(mobil.options[mobil.selectedIndex]?.getAttribute('data-tarif') || 0);
    const sopir  = jenis === 'dengan sopir' ? 200000 : 0;
    const total  = (tarif + sopir) * durasi;

    preview.style.display = 'block';
    preview.innerHTML = `<i class="bi bi-calculator"></i> Estimasi Total: <strong>Rp ${total.toLocaleString('id-ID')}</strong> (${durasi} hari × Rp ${(tarif+sopir).toLocaleString('id-ID')}/hari)`;
}

// Trigger initial check in case values are prefilled (like the selected car)
document.addEventListener('DOMContentLoaded', () => {
    updatePreview();
    ['tgl_sewa', 'tgl_kembali', 'id_mobil', 'jenis_sewa'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', updatePreview);
    });
});
</script>

<?php $this->endSection() ?>
