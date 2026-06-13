<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<?php $title = $pageTitle = 'Edit Armada'; ?>

<div class="page-header">
    <h2><i class="bi bi-pencil-square"></i> Edit Armada</h2>
    <a href="<?= base_url('mobil') ?>" class="btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="max-width:720px">
    <form action="<?= base_url('mobil/update/' . $mobil['id_mobil']) ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-grid">
            <div class="form-group">
                <label>Merek</label>
                <input type="text" name="merek" class="form-control" value="<?= esc($mobil['merek']) ?>" required>
            </div>
            <div class="form-group">
                <label>Model</label>
                <input type="text" name="model" class="form-control" value="<?= esc($mobil['model']) ?>" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Nomor Polisi</label>
                <input type="text" name="nopol_mobil" class="form-control" value="<?= esc($mobil['nopol_mobil']) ?>" required style="text-transform:uppercase">
            </div>
            <div class="form-group">
                <label>Tahun Perolehan</label>
                <input type="number" name="tahun_perolehan" class="form-control" value="<?= $mobil['tahun_perolehan'] ?>" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Harga Perolehan (Rp)</label>
                <input type="number" name="harga_perolehan" class="form-control" value="<?= $mobil['harga_perolehan'] ?>" required>
            </div>
            <div class="form-group">
                <label>Harga Sewa per Hari (Rp)</label>
                <input type="number" name="harga_sewa_perhari" class="form-control" value="<?= $mobil['harga_sewa_perhari'] ?>" required>
            </div>
        </div>

        <div class="form-group" style="max-width:280px">
            <label>Status Armada</label>
            <select name="status_mobil" class="form-control">
                <option value="tersedia"  <?= $mobil['status_mobil'] === 'tersedia'  ? 'selected' : '' ?>>✅ Tersedia</option>
                <option value="disewa"    <?= $mobil['status_mobil'] === 'disewa'    ? 'selected' : '' ?>>🔑 Sedang Disewa</option>
                <option value="perawatan" <?= $mobil['status_mobil'] === 'perawatan' ? 'selected' : '' ?>>🔧 Perawatan</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="bi bi-save"></i> Perbarui Data</button>
            <a href="<?= base_url('mobil') ?>" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php $this->endSection() ?>
