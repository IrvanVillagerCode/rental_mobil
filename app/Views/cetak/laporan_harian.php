<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Harian – <?= $tanggal ?></title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color: #1a1a2e; background: #fff; }
.container { width: 100%; padding: 20px; }
.header { text-align: center; border-bottom: 3px solid #6c63ff; padding-bottom: 12px; margin-bottom: 14px; }
.header h1 { font-size: 20px; font-weight: 900; color: #6c63ff; }
.header h2 { font-size: 12px; font-weight: 600; color: #333; margin-top: 3px; }
.header p { font-size: 9px; color: #777; margin-top: 2px; }
.section-title { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #6c63ff; background: #f0eeff; padding: 5px 10px; border-left: 3px solid #6c63ff; margin: 12px 0 8px; }
table { width: 100%; border-collapse: collapse; }
th { background: #6c63ff; color: #fff; padding: 7px 8px; font-size: 9px; text-align: left; text-transform: uppercase; }
td { padding: 6px 8px; font-size: 9.5px; border-bottom: 1px solid #eee; vertical-align: top; }
tr:nth-child(even) td { background: #fafafa; }
.badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 8px; font-weight: 800; text-transform: uppercase; }
.badge-selesai { background: #d1fae5; color: #059669; }
.badge-berjalan { background: #ede9fe; color: #6c63ff; }
.badge-booking { background: #dbeafe; color: #2563eb; }
.summary-grid { display: flex; gap: 12px; margin-top: 14px; }
.summary-box { flex: 1; border: 1px solid #ddd; border-radius: 6px; padding: 10px 12px; }
.summary-box .s-label { font-size: 9px; color: #777; font-weight: 600; text-transform: uppercase; }
.summary-box .s-val { font-size: 14px; font-weight: 900; color: #6c63ff; margin-top: 2px; }
.footer { margin-top: 20px; text-align: center; font-size: 9px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px; }
.empty { text-align: center; padding: 24px; color: #aaa; font-style: italic; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🚗 RentaCar</h1>
        <h2>LAPORAN HARIAN OPERASIONAL & TRANSAKSI</h2>
        <p>Tanggal: <strong><?= date('d F Y', strtotime($tanggal)) ?></strong> | Dicetak: <?= date('d/m/Y H:i') ?></p>
    </div>

    <!-- Log Penyewaan -->
    <div class="section-title">Log Penyewaan Hari Ini</div>
    <?php if (empty($data)): ?>
    <div class="empty">Tidak ada penyewaan pada tanggal ini.</div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Penyewa</th>
                <th>No. Telepon</th>
                <th>Kendaraan</th>
                <th>No. Polisi</th>
                <th>Jenis Sewa</th>
                <th>Tgl Kembali</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalPendapatan = 0;
            $totalDP = 0;
            foreach ($data as $i => $row):
                $totalPendapatan += $row['total_biaya'];
                $totalDP += $row['uang_muka'];
            ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($row['nama_penyewa']) ?></td>
                <td><?= esc($row['kontak']) ?></td>
                <td><?= esc(($row['merek'] ?? '') . ' ' . ($row['model'] ?? '')) ?></td>
                <td><strong><?= esc($row['nopol_mobil'] ?? '-') ?></strong></td>
                <td><?= esc($row['jenis_sewa']) ?></td>
                <td><?= date('d/m/Y', strtotime($row['tgl_kembali'])) ?></td>
                <td>Rp <?= number_format($row['total_biaya'], 0, ',', '.') ?></td>
                <td><span class="badge badge-<?= $row['status_transaksi'] ?>"><?= $row['status_transaksi'] ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary-grid">
        <div class="summary-box">
            <div class="s-label">Total Transaksi</div>
            <div class="s-val"><?= count($data) ?></div>
        </div>
        <div class="summary-box">
            <div class="s-label">Total Uang Muka (DP)</div>
            <div class="s-val">Rp <?= number_format($totalDP, 0, ',', '.') ?></div>
        </div>
        <div class="summary-box">
            <div class="s-label">Total Pendapatan</div>
            <div class="s-val">Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></div>
        </div>
    </div>
    <?php endif; ?>

    <div class="footer">
        Laporan Harian RentaCar – Kelompok 2, Teknik Informatika | Dicetak oleh Sistem Otomatis
    </div>
</div>
</body>
</html>
