<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<?php $title = $pageTitle = 'Biaya Operasional'; ?>

<div class="page-header">
    <h2><i class="bi bi-cash-stack"></i> Biaya Operasional</h2>
    <a href="<?= base_url('biaya/create') ?>" class="btn-primary">
        <i class="bi bi-plus-circle"></i> Catat Biaya
    </a>
</div>

<div class="card">
    <div class="filter-bar">
        <input type="text" id="tableSearch" class="search-input" placeholder="🔍 Cari kategori atau keterangan...">
    </div>

    <?php if (empty($biaya_list)): ?>
    <div class="empty-state"><i class="bi bi-cash-coin"></i><p>Belum ada catatan biaya operasional.</p></div>
    <?php else: ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalBiaya = 0;
                foreach ($biaya_list as $i => $b):
                    $totalBiaya += $b['jumlah_pengeluaran'];
                    $badgeColor = match($b['kategori_biaya']) {
                        'gaji sopir' => 'badge-berjalan',
                        'ganti oli', 'sparepart' => 'badge-perawatan',
                        'cuci mobil' => 'badge-tersedia',
                        'pajak kendaraan' => 'badge-disewa',
                        'marketing' => 'badge-booking',
                        default => 'badge-dibatalkan',
                    };
                ?>
                <tr data-search="<?= strtolower($b['kategori_biaya'] . ' ' . $b['keterangan']) ?>">
                    <td style="color:var(--text-muted)"><?= $i + 1 ?></td>
                    <td><?= date('d/m/Y', strtotime($b['tanggal_pengeluaran'])) ?></td>
                    <td><span class="badge <?= $badgeColor ?>"><?= esc($b['kategori_biaya']) ?></span></td>
                    <td style="color:var(--danger);font-weight:700">Rp <?= number_format($b['jumlah_pengeluaran'], 0, ',', '.') ?></td>
                    <td style="color:var(--text-muted);font-size:0.82rem"><?= esc($b['keterangan'] ?? '-') ?></td>
                    <td>
                        <a href="<?= base_url('biaya/delete/' . $b['id_biaya']) ?>"
                           class="btn-danger-sm btn-sm"
                           onclick="return confirm('Hapus catatan biaya ini?')">
                            <i class="bi bi-trash3"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;font-weight:700;color:var(--text-secondary);padding:14px 16px">TOTAL PENGELUARAN:</td>
                    <td style="font-weight:800;color:var(--danger);padding:14px 16px;font-size:1rem">Rp <?= number_format($totalBiaya, 0, ',', '.') ?></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
