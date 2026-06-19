<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<?php $title = $pageTitle = 'Manajemen Penyewaan'; ?>

<div class="page-header">
    <h2><i class="bi bi-file-earmark-text"></i> Manajemen Penyewaan</h2>
    <div style="display:flex;gap:10px">
        <a href="<?= base_url('cetak/harian?tanggal=' . date('Y-m-d')) ?>" class="btn-secondary" target="_blank">
            <i class="bi bi-file-pdf"></i> Laporan Harian
        </a>
        <a href="<?= base_url('penyewaan/create') ?>" class="btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Sewa
        </a>
    </div>
</div>

<div class="card">
    <div class="filter-bar">
        <input type="text" id="tableSearch" class="search-input" placeholder="🔍 Cari nama penyewa, nopol, atau status...">
        <select id="statusFilter" class="form-control" style="width:auto;min-width:140px" onchange="filterStatus(this.value)">
            <option value="">Semua Status</option>
            <option value="booking">Booking</option>
            <option value="berjalan">Berjalan</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>
    </div>

    <?php if (empty($penyewaan_list)): ?>
    <div class="empty-state"><i class="bi bi-file-earmark-x"></i><p>Belum ada data penyewaan.</p></div>
    <?php else: ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Penyewa</th>
                    <th>Kendaraan</th>
                    <th>Durasi</th>
                    <th>Jenis</th>
                    <th>DP / Pelunasan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($penyewaan_list as $i => $s):
                    $durasi = max(1, (int)((strtotime($s['tgl_kembali']) - strtotime($s['tgl_sewa'])) / 86400));
                ?>
                <tr data-search="<?= strtolower($s['nama_penyewa'] . ' ' . ($s['nopol_mobil'] ?? '') . ' ' . $s['status_transaksi']) ?>"
                    data-status="<?= $s['status_transaksi'] ?>">
                    <td style="color:var(--text-muted)"><?= $i + 1 ?></td>
                    <td>
                        <div style="font-weight:600;color:var(--text-primary)"><?= esc($s['nama_penyewa']) ?></div>
                        <div style="font-size:0.75rem;color:var(--text-muted)"><?= esc($s['kontak']) ?></div>
                    </td>
                    <td>
                        <?php if ($s['merek']): ?>
                        <div><?= esc($s['merek'] . ' ' . $s['model']) ?></div>
                        <div style="font-size:0.75rem;color:var(--accent-light);font-weight:700"><?= esc($s['nopol_mobil']) ?></div>
                        <?php else: ?><span style="color:var(--text-muted)">-</span><?php endif; ?>
                    </td>
                    <td>
                        <div style="font-size:0.8rem"><?= date('d/m/Y', strtotime($s['tgl_sewa'])) ?></div>
                        <div style="font-size:0.75rem;color:var(--text-muted)">s/d <?= date('d/m/Y', strtotime($s['tgl_kembali'])) ?></div>
                        <div style="font-size:0.72rem;color:var(--info)"><?= $durasi ?> hari</div>
                    </td>
                    <td>
                        <span class="badge <?= $s['jenis_sewa'] === 'dengan sopir' ? 'badge-berjalan' : 'badge-tersedia' ?>">
                            <?= $s['jenis_sewa'] === 'dengan sopir' ? '🧑‍✈️ Sopir' : '🔑 Lepas' ?>
                        </span>
                    </td>
                    <td>
                        <div style="font-size:0.8rem">DP: <span style="color:var(--warning)">Rp <?= number_format($s['uang_muka'], 0, ',', '.') ?></span></div>
                        <div style="font-size:0.8rem">Lunas: <span style="color:var(--success)">Rp <?= number_format($s['pelunasan'], 0, ',', '.') ?></span></div>
                        <?php if ($s['denda'] > 0): ?>
                        <div style="font-size:0.8rem">Denda: <span style="color:var(--danger)">Rp <?= number_format($s['denda'], 0, ',', '.') ?></span></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight:700;color:var(--success)">Rp <?= number_format($s['total_biaya'], 0, ',', '.') ?></td>
                    <td><span class="badge badge-<?= $s['status_transaksi'] ?>"><?= $s['status_transaksi'] ?></span></td>
                    <td>
                        <div style="display:flex;gap:5px;flex-wrap:wrap">
                            <a href="<?= base_url('penyewaan/edit/' . $s['id_sewa']) ?>" class="btn-info-sm btn-sm" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            <?php if ($s['status_transaksi'] === 'menunggu_konfirmasi'): ?>
                            <a href="<?= base_url('penyewaan/approve/' . $s['id_sewa']) ?>" class="btn-sm" title="Setujui Booking" style="background:#16a34a;color:#fff;padding:4px 8px;border-radius:4px;text-decoration:none">
                                <i class="bi bi-check-circle"></i> Setujui
                            </a>
                            <?php endif; ?>

                            <a href="<?= base_url('penyewaan/invoice/' . $s['id_sewa']) ?>" class="btn-warning-sm btn-sm" title="Cetak Nota Baru" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                            <a href="<?= base_url('penyewaan/delete/' . $s['id_sewa']) ?>"
                               class="btn-danger-sm btn-sm" title="Hapus"
                               onclick="return confirm('Hapus transaksi sewa #<?= $s['id_sewa'] ?>?')">
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

<script>
function filterStatus(val) {
    document.querySelectorAll('tbody tr[data-status]').forEach(row => {
        if (!val || row.getAttribute('data-status') === val) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>

<?php $this->endSection() ?>
