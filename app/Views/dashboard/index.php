<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>

<?php
$title     = 'Dashboard';
$pageTitle = 'Dashboard';
?>

<div class="page-header">
    <h2><i class="bi bi-speedometer2"></i> Dashboard Overview</h2>
    <span style="font-size:0.8rem;color:var(--text-muted)">Update realtime per <?= date('H:i') ?> WIB</span>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple"><i class="bi bi-car-front-fill"></i></div>
        <div class="stat-info">
            <div class="stat-label">Total Armada</div>
            <div class="stat-value"><?= $statistik_mobil['total'] ?></div>
            <div class="stat-sub"><?= $statistik_mobil['tersedia'] ?> tersedia</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
        <div class="stat-info">
            <div class="stat-label">Mobil Tersedia</div>
            <div class="stat-value"><?= $statistik_mobil['tersedia'] ?></div>
            <div class="stat-sub">Siap disewa</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow"><i class="bi bi-file-earmark-text"></i></div>
        <div class="stat-info">
            <div class="stat-label">Transaksi Aktif</div>
            <div class="stat-value"><?= $transaksi_aktif ?></div>
            <div class="stat-sub">Booking & berjalan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="bi bi-cash-coin"></i></div>
        <div class="stat-info">
            <div class="stat-label">Pendapatan Hari Ini</div>
            <div class="stat-value" style="font-size:1.1rem">Rp <?= number_format($pendapatan_hari, 0, ',', '.') ?></div>
            <div class="stat-sub"><?= date('d F Y') ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-graph-up"></i></div>
        <div class="stat-info">
            <div class="stat-label">Pendapatan Bulan Ini</div>
            <div class="stat-value" style="font-size:1.1rem">Rp <?= number_format($pendapatan_bulan, 0, ',', '.') ?></div>
            <div class="stat-sub"><?= date('F Y') ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon <?= $laba_kotor >= 0 ? 'green' : 'red' ?>"><i class="bi bi-bar-chart-line"></i></div>
        <div class="stat-info">
            <div class="stat-label">Laba Kotor Bulan Ini</div>
            <div class="stat-value" style="font-size:1.1rem;color:<?= $laba_kotor >= 0 ? '#10b981' : '#ef4444' ?>">
                Rp <?= number_format(abs($laba_kotor), 0, ',', '.') ?>
            </div>
            <div class="stat-sub">Biaya: Rp <?= number_format($biaya_bulan, 0, ',', '.') ?></div>
        </div>
    </div>
</div>

<!-- Status Armada & Recent Transactions -->
<div class="dashboard-grid">
    <!-- Recent Transactions -->
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-clock-history"></i> Transaksi Terbaru</div>
            <a href="<?= base_url('penyewaan') ?>" class="btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <?php if (empty($recent_sewa)): ?>
        <div class="empty-state"><i class="bi bi-inbox"></i><p>Belum ada transaksi</p></div>
        <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Penyewa</th>
                        <th>Kendaraan</th>
                        <th>Tgl Sewa</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_sewa as $s): ?>
                    <tr>
                        <td>
                            <div style="font-weight:600;color:var(--text-primary)"><?= esc($s['nama_penyewa']) ?></div>
                            <div style="font-size:0.75rem;color:var(--text-muted)"><?= esc($s['kontak']) ?></div>
                        </td>
                        <td>
                            <div><?= esc($s['merek'] . ' ' . $s['model']) ?></div>
                            <div style="font-size:0.75rem;color:var(--text-muted)"><?= esc($s['nopol_mobil']) ?></div>
                        </td>
                        <td><?= date('d/m/Y', strtotime($s['tgl_sewa'])) ?></td>
                        <td style="color:var(--success);font-weight:600">Rp <?= number_format($s['total_biaya'], 0, ',', '.') ?></td>
                        <td><span class="badge badge-<?= $s['status_transaksi'] ?>"><?= $s['status_transaksi'] ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- Status Armada -->
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-pie-chart"></i> Status Armada</div>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;margin-top:8px">
            <?php
            $total = $statistik_mobil['total'] ?: 1;
            $statuses = [
                ['tersedia', 'Tersedia', '#10b981', $statistik_mobil['tersedia']],
                ['disewa', 'Sedang Disewa', '#6c63ff', $statistik_mobil['disewa']],
                ['perawatan', 'Perawatan', '#f59e0b', $statistik_mobil['perawatan']],
            ];
            foreach ($statuses as [$key, $label, $color, $count]):
                $pct = round($count / $total * 100);
            ?>
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:6px">
                    <span style="font-size:0.82rem;font-weight:500;color:var(--text-secondary)"><?= $label ?></span>
                    <span style="font-size:0.82rem;font-weight:700;color:<?= $color ?>"><?= $count ?> unit (<?= $pct ?>%)</span>
                </div>
                <div style="height:8px;background:rgba(255,255,255,0.06);border-radius:99px;overflow:hidden">
                    <div style="width:<?= $pct ?>%;height:100%;background:<?= $color ?>;border-radius:99px;transition:width 1s ease"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="margin-top:24px">
            <div class="card-title" style="margin-bottom:14px"><i class="bi bi-lightning"></i> Quick Actions</div>
            <div style="display:flex;flex-direction:column;gap:8px">
                <a href="<?= base_url('penyewaan/create') ?>" class="btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Penyewaan Baru
                </a>
                <a href="<?= base_url('mobil/create') ?>" class="btn-secondary">
                    <i class="bi bi-plus-circle"></i> Tambah Armada Baru
                </a>
                <a href="<?= base_url('cetak/harian?tanggal=' . date('Y-m-d')) ?>" class="btn-secondary" target="_blank">
                    <i class="bi bi-file-pdf"></i> Laporan Harian Hari Ini
                </a>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
