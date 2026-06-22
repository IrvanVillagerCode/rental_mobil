<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>

<?php
$title     = 'Dashboard';
$pageTitle = 'Dashboard';
?>

<div class="welcome-banner">
    <div class="welcome-content">
        <h2>Selamat Datang kembali, <?= esc(session()->get('nama') ?? 'Admin') ?>! 👋</h2>
        <p>Berikut adalah ringkasan performa penyewaan armada Anda hari ini.</p>
    </div>
    <div class="welcome-date">
        <i class="bi bi-clock"></i> Update: <span id="welcome-update-time"><?= date('H:i') ?></span> WIB
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple"><i class="bi bi-car-front-fill"></i></div>
        <div class="stat-info">
            <div class="stat-label">Total Armada</div>
            <div class="stat-value" id="dashboard-stat-total"><?= $statistik_mobil['total'] ?></div>
            <div class="stat-sub" id="dashboard-stat-total-sub"><?= $statistik_mobil['tersedia'] ?> tersedia</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
        <div class="stat-info">
            <div class="stat-label">Mobil Tersedia</div>
            <div class="stat-value" id="dashboard-stat-tersedia"><?= $statistik_mobil['tersedia'] ?></div>
            <div class="stat-sub">Siap disewa</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow"><i class="bi bi-file-earmark-text"></i></div>
        <div class="stat-info">
            <div class="stat-label">Transaksi Aktif</div>
            <div class="stat-value" id="dashboard-stat-transaksi-aktif"><?= $transaksi_aktif ?></div>
            <div class="stat-sub">Booking & berjalan</div>
        </div>
    </div>
    <div class="stat-card featured-stat">
        <div class="stat-icon blue"><i class="bi bi-cash-coin"></i></div>
        <div class="stat-info">
            <div class="stat-label">Pendapatan Hari Ini</div>
            <div class="stat-value" id="dashboard-stat-pendapatan-hari" style="font-size:1.3rem">Rp <?= number_format($pendapatan_hari, 0, ',', '.') ?></div>
            <div class="stat-sub"><?= date('d F Y') ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-graph-up"></i></div>
        <div class="stat-info">
            <div class="stat-label">Pendapatan Bulan Ini</div>
            <div class="stat-value" id="dashboard-stat-pendapatan-bulan" style="font-size:1.2rem">Rp <?= number_format($pendapatan_bulan, 0, ',', '.') ?></div>
            <div class="stat-sub"><?= date('F Y') ?></div>
        </div>
    </div>
    <div class="stat-card featured-stat">
        <div class="stat-icon <?= $laba_kotor >= 0 ? 'green' : 'red' ?>" id="dashboard-stat-laba-icon"><i class="bi bi-bar-chart-line"></i></div>
        <div class="stat-info">
            <div class="stat-label">Laba Kotor Bulan Ini</div>
            <div class="stat-value" id="dashboard-stat-laba-kotor" style="font-size:1.3rem;color:<?= $laba_kotor >= 0 ? '#10b981' : '#ef4444' ?>">
                Rp <?= number_format(abs($laba_kotor), 0, ',', '.') ?>
            </div>
            <div class="stat-sub" id="dashboard-stat-biaya-bulan">Biaya: Rp <?= number_format($biaya_bulan, 0, ',', '.') ?></div>
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
            <div class="status-row" data-status-key="<?= $key ?>" data-status-label="<?= $label ?>" data-status-color="<?= $color ?>">
                <div style="display:flex;justify-content:space-between;margin-bottom:6px">
                    <span style="font-size:0.82rem;font-weight:600;color:var(--text-primary)"><?= $label ?></span>
                    <span class="status-text-val" style="font-size:0.82rem;font-weight:700;color:<?= $color ?>"><?= $count ?> unit (<?= $pct ?>%)</span>
                </div>
                <div style="height:10px;background:rgba(255,255,255,0.04);border-radius:99px;overflow:hidden;box-shadow:inset 0 1px 3px rgba(0,0,0,0.2)">
                    <div class="status-bar-val" style="width:<?= $pct ?>%;height:100%;background:linear-gradient(90deg, <?= $color ?>, transparent 200%);border-radius:99px;transition:width 1.5s cubic-bezier(0.4, 0, 0.2, 1);"></div>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    function formatRupiah(num) {
        return 'Rp ' + parseFloat(num || 0).toLocaleString('id-ID');
    }

    function updateDashboardStats() {
        fetch('<?= base_url("dashboard/get-stats-ajax") ?>')
            .then(response => response.json())
            .then(data => {
                // Update Welcome Time
                const timeEl = document.getElementById('welcome-update-time');
                if (timeEl) timeEl.textContent = data.update_time;

                // Update Stats Grid
                const totalEl = document.getElementById('dashboard-stat-total');
                const totalSubEl = document.getElementById('dashboard-stat-total-sub');
                const tersediaEl = document.getElementById('dashboard-stat-tersedia');
                const aktifEl = document.getElementById('dashboard-stat-transaksi-aktif');
                const hariEl = document.getElementById('dashboard-stat-pendapatan-hari');
                const bulanEl = document.getElementById('dashboard-stat-pendapatan-bulan');
                const labaEl = document.getElementById('dashboard-stat-laba-kotor');
                const labaIconEl = document.getElementById('dashboard-stat-laba-icon');
                const biayaEl = document.getElementById('dashboard-stat-biaya-bulan');

                if (totalEl) totalEl.textContent = data.statistik_mobil.total;
                if (totalSubEl) totalSubEl.textContent = data.statistik_mobil.tersedia + ' tersedia';
                if (tersediaEl) tersediaEl.textContent = data.statistik_mobil.tersedia;
                if (aktifEl) aktifEl.textContent = data.transaksi_aktif;
                if (hariEl) hariEl.textContent = formatRupiah(data.pendapatan_hari);
                if (bulanEl) bulanEl.textContent = formatRupiah(data.pendapatan_bulan);
                
                if (labaEl) {
                    labaEl.textContent = formatRupiah(Math.abs(data.laba_kotor));
                    labaEl.style.color = data.laba_kotor >= 0 ? '#10b981' : '#ef4444';
                }
                if (labaIconEl) {
                    labaIconEl.className = 'stat-icon ' + (data.laba_kotor >= 0 ? 'green' : 'red');
                }
                if (biayaEl) {
                    biayaEl.textContent = 'Biaya: ' + formatRupiah(data.biaya_bulan);
                }

                // Update Status Armada Progress Bars
                const totalMobil = parseInt(data.statistik_mobil.total) || 1;
                document.querySelectorAll('.status-row').forEach(row => {
                    const key = row.getAttribute('data-status-key');
                    const count = parseInt(data.statistik_mobil[key]) || 0;
                    const pct = Math.round(count / totalMobil * 100);

                    const textVal = row.querySelector('.status-text-val');
                    const barVal = row.querySelector('.status-bar-val');

                    if (textVal) {
                        textVal.textContent = count + ' unit (' + pct + '%)';
                    }
                    if (barVal) {
                        barVal.style.width = pct + '%';
                    }
                });
            })
            .catch(err => console.error('Error fetching dashboard stats:', err));
    }

    // Real-time clock for Update Time (Asia/Jakarta WIB)
    function updateRealTimeClock() {
        const timeEl = document.getElementById('welcome-update-time');
        if (timeEl) {
            const now = new Date();
            const str = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'Asia/Jakarta' }).replace(/\./g, ':');
            timeEl.textContent = str;
        }
    }
    // Start real-time clock
    setInterval(updateRealTimeClock, 1000);
    updateRealTimeClock();

    // Poll server for stats every 5 seconds
    setInterval(updateDashboardStats, 5000);
});
</script>

<?php $this->endSection() ?>
