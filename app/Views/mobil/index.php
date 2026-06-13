<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<?php $title = $pageTitle = 'Manajemen Armada'; ?>

<div class="page-header">
    <h2><i class="bi bi-car-front"></i> Manajemen Armada</h2>
    <a href="<?= base_url('mobil/create') ?>" class="btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Armada
    </a>
</div>

<div class="card">
    <div class="filter-bar">
        <input type="text" id="tableSearch" class="search-input" placeholder="🔍 Cari merek, model, atau nopol...">
    </div>

    <?php if (empty($mobil_list)): ?>
    <div class="empty-state"><i class="bi bi-car-front"></i><p>Belum ada data armada. Tambahkan sekarang!</p></div>
    <?php else: ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kendaraan</th>
                    <th>No. Polisi</th>
                    <th>Tahun</th>
                    <th>Harga Perolehan</th>
                    <th>Tarif/Hari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mobil_list as $i => $m): ?>
                <tr data-search="<?= strtolower($m['merek'] . ' ' . $m['model'] . ' ' . $m['nopol_mobil']) ?>">
                    <td style="color:var(--text-muted)"><?= $i + 1 ?></td>
                    <td>
                        <div style="font-weight:600;color:var(--text-primary)"><?= esc($m['merek'] . ' ' . $m['model']) ?></div>
                        <div style="font-size:0.75rem;color:var(--text-muted)">ID: #<?= $m['id_mobil'] ?></div>
                    </td>
                    <td>
                        <span style="font-family:monospace;background:rgba(108,99,255,0.1);color:var(--accent-light);padding:3px 8px;border-radius:6px;font-weight:700">
                            <?= esc($m['nopol_mobil']) ?>
                        </span>
                    </td>
                    <td><?= $m['tahun_perolehan'] ?></td>
                    <td>Rp <?= number_format($m['harga_perolehan'], 0, ',', '.') ?></td>
                    <td style="color:var(--success);font-weight:600">Rp <?= number_format($m['harga_sewa_perhari'], 0, ',', '.') ?>/hari</td>
                    <td><span class="badge badge-<?= $m['status_mobil'] ?>"><?= $m['status_mobil'] ?></span></td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                            <a href="<?= base_url('mobil/edit/' . $m['id_mobil']) ?>" class="btn-info-sm btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="<?= base_url('mobil/delete/' . $m['id_mobil']) ?>"
                               class="btn-danger-sm btn-sm"
                               onclick="return confirm('Hapus armada <?= esc($m['merek'] . ' ' . $m['model']) ?>?')">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
