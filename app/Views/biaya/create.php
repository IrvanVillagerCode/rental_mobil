<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<?php $title = $pageTitle = 'Catat Biaya Operasional'; ?>

<div class="page-header">
    <h2><i class="bi bi-plus-circle"></i> Catat Biaya Operasional</h2>
    <a href="<?= base_url('biaya') ?>" class="btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="max-width:600px">
    <form action="<?= base_url('biaya/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label><i class="bi bi-tag"></i> Kategori Biaya</label>
            <select name="kategori_biaya" class="form-control" required>
                <option value="gaji sopir">🧑‍✈️ Gaji Sopir</option>
                <option value="cuci mobil">🚿 Cuci Mobil</option>
                <option value="marketing">📣 Marketing / Iklan</option>
                <option value="ganti oli">🔧 Ganti Oli</option>
                <option value="sparepart">⚙️ Sparepart</option>
                <option value="pajak kendaraan">📄 Pajak Kendaraan (STNK)</option>
                <option value="lainnya">📋 Lainnya</option>
            </select>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label><i class="bi bi-cash-coin"></i> Jumlah Pengeluaran (Rp)</label>
                <input type="number" name="jumlah_pengeluaran" class="form-control" placeholder="50000" min="0" required>
            </div>
            <div class="form-group">
                <label><i class="bi bi-calendar3"></i> Tanggal Pengeluaran</label>
                <input type="date" name="tanggal_pengeluaran" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label><i class="bi bi-chat-left-text"></i> Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan detail pengeluaran..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="bi bi-save"></i> Simpan Biaya</button>
            <a href="<?= base_url('biaya') ?>" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php $this->endSection() ?>
