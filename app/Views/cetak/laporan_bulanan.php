<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Bulanan – <?= date('F Y', mktime(0,0,0,$bulan,1,$tahun)) ?></title>
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
.summary-grid { display: flex; gap: 12px; margin: 14px 0; flex-wrap: wrap; }
.summary-box { flex: 1; min-width: 120px; border: 1px solid #ddd; border-radius: 6px; padding: 10px 12px; }
.summary-box .s-label { font-size: 9px; color: #777; font-weight: 600; text-transform: uppercase; }
.summary-box .s-val { font-size: 13px; font-weight: 900; margin-top: 2px; }
.green { color: #059669; }
.red   { color: #dc2626; }
.purple { color: #6c63ff; }
.laba-box { background: linear-gradient(135deg, #6c63ff, #8b5cf6); color: #fff; border-radius: 8px; padding: 14px 18px; margin: 14px 0; }
.laba-box .label { font-size: 10px; font-weight: 700; opacity: 0.85; }
.laba-box .amount { font-size: 24px; font-weight: 900; margin-top: 2px; }
.footer { margin-top: 20px; text-align: center; font-size: 9px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <!-- Use the absolute public path for dompdf -->
        <h1 style="display:flex; align-items:center; gap:10px;">
            <img src="<?= FCPATH . 'assets/images/logo.png' ?>" alt="AutoVora Logo" style="height: 40px;">
            AutoVora
        </h1>
        <h2>LAPORAN BULANAN KEUANGAN & KINERJA</h2>
        <p>Periode: <strong><?= date('F Y', mktime(0,0,0,$bulan,1,$tahun)) ?></strong> | Dicetak: <?= date('d/m/Y H:i') ?></p>
    </div>

    <!-- Ringkasan Keuangan -->
    <div class="section-title">Ringkasan Laba Rugi</div>
    <div class="summary-grid">
        <div class="summary-box">
            <div class="s-label">Total Pendapatan Sewa</div>
            <div class="s-val green">Rp <?= number_format($totalPend, 0, ',', '.') ?></div>
        </div>
        <div class="summary-box">
            <div class="s-label">Total Biaya Operasional</div>
            <div class="s-val red">Rp <?= number_format($totalBiaya, 0, ',', '.') ?></div>
        </div>
    </div>

    <?php $labaKotor = $totalPend - $totalBiaya; ?>
    <div class="laba-box">
        <div class="label">LABA KOTOR BULAN INI</div>
        <div class="amount">Rp <?= number_format(abs($labaKotor), 0, ',', '.') ?> <?= $labaKotor < 0 ? '(RUGI)' : '' ?></div>
    </div>

    <!-- Transaksi Bulanan -->
    <div class="section-title">Rincian Transaksi Sewa (<?= count($data) ?> Transaksi)</div>
    <?php if (empty($data)): ?>
    <p style="color:#aaa;text-align:center;padding:16px">Tidak ada transaksi bulan ini.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr><th>#</th><th>Penyewa</th><th>Kendaraan</th><th>Tgl Sewa</th><th>Jenis</th><th>Total</th><th>Status</th></tr>
        </thead>
        <tbody>
            <?php foreach ($data as $i => $row): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($row['nama_penyewa']) ?></td>
                <td><?= esc(($row['merek'] ?? '') . ' – ' . ($row['nopol_mobil'] ?? '')) ?></td>
                <td><?= date('d/m', strtotime($row['tgl_sewa'])) ?></td>
                <td><?= $row['jenis_sewa'] ?></td>
                <td>Rp <?= number_format($row['total_biaya'], 0, ',', '.') ?></td>
                <td><?= $row['status_transaksi'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Biaya Operasional -->
    <div class="section-title">Rincian Biaya Operasional (<?= count($biaya) ?> Item)</div>
    <?php if (empty($biaya)): ?>
    <p style="color:#aaa;text-align:center;padding:16px">Tidak ada catatan biaya bulan ini.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr><th>Tanggal</th><th>Kategori</th><th>Jumlah</th><th>Keterangan</th></tr>
        </thead>
        <tbody>
            <?php foreach ($biaya as $b): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($b['tanggal_pengeluaran'])) ?></td>
                <td><?= esc($b['kategori_biaya']) ?></td>
                <td>Rp <?= number_format($b['jumlah_pengeluaran'], 0, ',', '.') ?></td>
                <td><?= esc($b['keterangan'] ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Daftar Piutang -->
    <?php if (!empty($piutang)): ?>
    <div class="section-title">Daftar Piutang Sewa Belum Lunas</div>
    <table>
        <thead>
            <tr><th>Penyewa</th><th>Kendaraan</th><th>Total Biaya</th><th>Dibayar</th><th>Sisa</th></tr>
        </thead>
        <tbody>
            <?php foreach ($piutang as $p): ?>
            <tr>
                <td><?= esc($p['nama_penyewa']) ?></td>
                <td><?= esc(($p['merek'] ?? '') . ' ' . ($p['nopol_mobil'] ?? '')) ?></td>
                <td>Rp <?= number_format($p['total_biaya'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($p['uang_muka'] + $p['pelunasan'], 0, ',', '.') ?></td>
                <td style="font-weight:800;color:#dc2626">Rp <?= number_format($p['total_biaya'] - $p['uang_muka'] - $p['pelunasan'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <div class="footer">
        Laporan Bulanan AutoVora – Kelompok 2, Teknik Informatika | Dicetak oleh Sistem Otomatis
    </div>
</div>
</body>
</html>
