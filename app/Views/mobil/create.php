<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<?php $title = $pageTitle = 'Tambah Armada'; ?>

<div class="page-header">
    <h2><i class="bi bi-plus-circle"></i> Tambah Armada Baru</h2>
    <a href="<?= base_url('mobil') ?>" class="btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="max-width:720px">
    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert-toast error">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <ul style="margin:0;padding-left:16px">
            <?php foreach (session()->getFlashdata('errors') as $e): ?>
            <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?= base_url('mobil/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-grid">
            <div class="form-group">
                <label><i class="bi bi-tag"></i> Merek</label>
                <input type="text" name="merek" class="form-control" placeholder="Toyota, Honda, dll" value="<?= old('merek') ?>" required>
            </div>
            <div class="form-group">
                <label><i class="bi bi-car-front"></i> Model</label>
                <input type="text" name="model" class="form-control" placeholder="Avanza, Brio, dll" value="<?= old('model') ?>" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label><i class="bi bi-123"></i> Nomor Polisi</label>
                <input type="text" name="nopol_mobil" class="form-control" placeholder="B 1234 XX" value="<?= old('nopol_mobil') ?>" required style="text-transform:uppercase">
            </div>
            <div class="form-group">
                <label><i class="bi bi-calendar3"></i> Tahun Perolehan</label>
                <input type="number" name="tahun_perolehan" class="form-control" placeholder="2022" min="1990" max="<?= date('Y') ?>" value="<?= old('tahun_perolehan') ?>" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label><i class="bi bi-currency-dollar"></i> Harga Perolehan (Rp)</label>
                <input type="number" name="harga_perolehan" class="form-control" placeholder="250000000" min="0" value="<?= old('harga_perolehan') ?>" required>
            </div>
            <div class="form-group">
                <label><i class="bi bi-cash-coin"></i> Harga Sewa per Hari (Rp)</label>
                <input type="number" name="harga_sewa_perhari" class="form-control" placeholder="350000" min="0" value="<?= old('harga_sewa_perhari') ?>" required>
            </div>
        </div>

        <div class="form-group" style="max-width:280px">
            <label><i class="bi bi-toggle-on"></i> Status Armada</label>
            <select name="status_mobil" class="form-control">
                <option value="tersedia" <?= old('status_mobil') === 'tersedia' ? 'selected' : '' ?>>✅ Tersedia</option>
                <option value="disewa" <?= old('status_mobil') === 'disewa' ? 'selected' : '' ?>>🔑 Sedang Disewa</option>
                <option value="perawatan" <?= old('status_mobil') === 'perawatan' ? 'selected' : '' ?>>🔧 Perawatan</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="bi bi-save"></i> Simpan Armada</button>
            <a href="<?= base_url('mobil') ?>" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php $this->endSection() ?>
