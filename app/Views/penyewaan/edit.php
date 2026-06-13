<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<?php $title = $pageTitle = 'Edit Penyewaan #' . $sewa['id_sewa']; ?>

<div class="page-header">
    <h2><i class="bi bi-pencil-square"></i> Edit Penyewaan #<?= $sewa['id_sewa'] ?></h2>
    <a href="<?= base_url('penyewaan') ?>" class="btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<!-- Info ringkasan -->
<div class="card" style="margin-bottom:16px;background:rgba(108,99,255,0.05);border-color:rgba(108,99,255,0.2)">
    <div style="display:flex;gap:24px;flex-wrap:wrap">
        <div>
            <div style="font-size:0.72rem;color:var(--text-muted)">PENYEWA</div>
            <div style="font-weight:700;color:var(--text-primary)"><?= esc($sewa['nama_penyewa']) ?></div>
        </div>
        <div>
            <div style="font-size:0.72rem;color:var(--text-muted)">KENDARAAN</div>
            <div style="font-weight:700;color:var(--accent-light)"><?= esc(($sewa['merek'] ?? '') . ' ' . ($sewa['model'] ?? '')) ?> – <?= esc($sewa['nopol_mobil'] ?? '') ?></div>
        </div>
        <div>
            <div style="font-size:0.72rem;color:var(--text-muted)">PERIODE</div>
            <div style="font-weight:600"><?= date('d/m/Y', strtotime($sewa['tgl_sewa'])) ?> → <?= date('d/m/Y', strtotime($sewa['tgl_kembali'])) ?></div>
        </div>
        <div>
            <div style="font-size:0.72rem;color:var(--text-muted)">TOTAL BIAYA</div>
            <div style="font-weight:700;color:var(--success)">Rp <?= number_format($sewa['total_biaya'], 0, ',', '.') ?></div>
        </div>
    </div>
</div>

<div class="card" style="max-width:700px">
    <form action="<?= base_url('penyewaan/update/' . $sewa['id_sewa']) ?>" method="POST">
        <?= csrf_field() ?>

        <div style="font-size:0.85rem;font-weight:700;color:var(--accent);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border)">
            <i class="bi bi-currency-exchange"></i> Update Pembayaran & Status
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Pelunasan (Rp)</label>
                <input type="number" name="pelunasan" class="form-control" value="<?= $sewa['pelunasan'] ?>" min="0">
            </div>
            <div class="form-group">
                <label>Denda Keterlambatan (Rp)</label>
                <input type="number" name="denda" class="form-control" value="<?= $sewa['denda'] ?>" min="0">
            </div>
        </div>

        <div class="form-group" style="max-width:280px">
            <label>Status Transaksi</label>
            <select name="status_transaksi" class="form-control">
                <option value="booking"     <?= $sewa['status_transaksi'] === 'booking'     ? 'selected' : '' ?>>📋 Booking</option>
                <option value="berjalan"    <?= $sewa['status_transaksi'] === 'berjalan'    ? 'selected' : '' ?>>🚗 Berjalan</option>
                <option value="selesai"     <?= $sewa['status_transaksi'] === 'selesai'     ? 'selected' : '' ?>>✅ Selesai</option>
                <option value="dibatalkan"  <?= $sewa['status_transaksi'] === 'dibatalkan'  ? 'selected' : '' ?>>❌ Dibatalkan</option>
            </select>
        </div>

        <div style="font-size:0.85rem;font-weight:700;color:var(--accent);margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border);margin-top:16px">
            <i class="bi bi-clipboard2-check-fill"></i> Kondisi Kendaraan Kembali
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Level BBM Saat Kembali</label>
                <select name="bbm_kembali" class="form-control">
                    <option value="">-- Belum Kembali --</option>
                    <option value="Full"  <?= ($kondisi['bbm_kembali'] ?? '') === 'Full'  ? 'selected' : '' ?>>⛽ Full</option>
                    <option value="3/4"   <?= ($kondisi['bbm_kembali'] ?? '') === '3/4'   ? 'selected' : '' ?>>⛽ 3/4</option>
                    <option value="Half"  <?= ($kondisi['bbm_kembali'] ?? '') === 'Half'  ? 'selected' : '' ?>>⛽ Half</option>
                    <option value="1/4"   <?= ($kondisi['bbm_kembali'] ?? '') === '1/4'   ? 'selected' : '' ?>>⛽ 1/4</option>
                </select>
                <div style="font-size:0.72rem;color:var(--text-muted);margin-top:4px">BBM keluar: <strong><?= esc($kondisi['bbm_keluar'] ?? '-') ?></strong></div>
            </div>
        </div>

        <div class="form-group">
            <label>Catatan Kondisi Fisik Kembali</label>
            <textarea name="fisik_kembali" class="form-control" rows="3" placeholder="Catatan kerusakan, baret, atau kondisi saat mobil kembali"><?= esc($kondisi['fisik_kembali'] ?? '') ?></textarea>
            <?php if (!empty($kondisi['fisik_keluar'])): ?>
            <div style="font-size:0.72rem;color:var(--text-muted);margin-top:4px">Kondisi keluar: <?= esc($kondisi['fisik_keluar']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
            <a href="<?= base_url('cetak/nota/' . $sewa['id_sewa']) ?>" class="btn-secondary" target="_blank">
                <i class="bi bi-printer"></i> Cetak Nota
            </a>
        </div>
    </form>
</div>

<?php $this->endSection() ?>
