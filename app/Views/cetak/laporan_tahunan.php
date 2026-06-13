<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Tahunan – <?= $tahun ?></title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color: #1a1a2e; background: #fff; }
.container { width: 100%; padding: 20px; }
.header { text-align: center; border-bottom: 3px solid #6c63ff; padding-bottom: 12px; margin-bottom: 14px; }
.header h1 { font-size: 20px; font-weight: 900; color: #6c63ff; }
.header h2 { font-size: 12px; font-weight: 600; color: #333; margin-top: 3px; }
.header p { font-size: 9px; color: #777; margin-top: 2px; }
.section-title { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #6c63ff; background: #f0eeff; padding: 5px 10px; border-left: 3px solid #6c63ff; margin: 14px 0 8px; }
table { width: 100%; border-collapse: collapse; }
th { background: #6c63ff; color: #fff; padding: 7px 8px; font-size: 9px; text-align: left; text-transform: uppercase; }
td { padding: 6px 8px; font-size: 9.5px; border-bottom: 1px solid #eee; vertical-align: top; }
tr:nth-child(even) td { background: #fafafa; }
.fin-box { border: 1px solid #ddd; border-radius: 8px; padding: 14px; margin: 12px 0; }
.fin-row { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px dashed #f0f0f0; }
.fin-row:last-child { border-bottom: none; }
.fin-label { color: #555; }
.fin-val { font-weight: 700; }
.fin-total { background: #f0eeff; font-size: 11px; font-weight: 900; color: #6c63ff; border-radius: 6px; padding: 8px 12px; margin-top: 8px; display: flex; justify-content: space-between; }
.laba-box { background: linear-gradient(135deg, #6c63ff, #8b5cf6); color: #fff; border-radius: 8px; padding: 14px 18px; margin: 14px 0; }
.laba-box .label { font-size: 10px; font-weight: 700; opacity: 0.85; }
.laba-box .amount { font-size: 24px; font-weight: 900; margin-top: 2px; }
.laba-box .sub { font-size: 9px; opacity: 0.7; margin-top: 4px; }
.neraca-grid { display: flex; gap: 16px; margin: 12px 0; }
.neraca-col { flex: 1; }
.neraca-title { font-size: 10px; font-weight: 800; color: #555; text-transform: uppercase; margin-bottom: 8px; padding-bottom: 4px; border-bottom: 2px solid #6c63ff; }
.neraca-item { display: flex; justify-content: space-between; padding: 4px 0; font-size: 9.5px; border-bottom: 1px solid #f5f5f5; }
.footer { margin-top: 20px; text-align: center; font-size: 9px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🚗 RentaCar</h1>
        <h2>LAPORAN TAHUNAN – EVALUASI ASET & PAJAK</h2>
        <p>Tahun Fiskal: <strong><?= $tahun ?></strong> | Dicetak: <?= date('d/m/Y H:i') ?></p>
    </div>

    <!-- Laba Rugi Tahunan -->
    <div class="section-title">Laporan Laba Rugi Tahunan <?= $tahun ?></div>
    <div class="laba-box">
        <div class="label">LABA BERSIH TAHUNAN</div>
        <div class="amount">Rp <?= number_format(abs($labaBersih), 0, ',', '.') ?> <?= $labaBersih < 0 ? '(RUGI)' : '' ?></div>
        <div class="sub">Pendapatan: Rp <?= number_format($totalPend, 0, ',', '.') ?> | Beban Operasional: Rp <?= number_format($totalBiaya, 0, ',', '.') ?></div>
    </div>

    <!-- Neraca -->
    <div class="section-title">Laporan Neraca (Balance Sheet) Per 31 Desember <?= $tahun ?></div>
    <?php
    $totalNilaiBuku = array_sum(array_column($armada, 'nilai_buku'));
    $totalAset = $totalNilaiBuku + $totalPend; // Aset = Nilai buku armada + kas pendapatan (estimasi)
    ?>
    <div class="neraca-grid">
        <div class="neraca-col">
            <div class="neraca-title">ASET</div>
            <div class="neraca-item"><span>Kas & Pendapatan Sewa</span><span>Rp <?= number_format($totalPend, 0, ',', '.') ?></span></div>
            <div class="neraca-item"><span>Nilai Buku Armada</span><span>Rp <?= number_format($totalNilaiBuku, 0, ',', '.') ?></span></div>
            <div style="margin-top:8px;font-weight:900;font-size:10px;color:#059669">Total Aset: Rp <?= number_format($totalNilaiBuku + $totalPend, 0, ',', '.') ?></div>
        </div>
        <div class="neraca-col">
            <div class="neraca-title">KEWAJIBAN & EKUITAS</div>
            <div class="neraca-item"><span>Beban Operasional</span><span style="color:#dc2626">Rp <?= number_format($totalBiaya, 0, ',', '.') ?></span></div>
            <div class="neraca-item"><span>Laba Ditahan</span><span style="color:#059669">Rp <?= number_format(max(0, $labaBersih), 0, ',', '.') ?></span></div>
        </div>
    </div>

    <!-- Penyusutan Armada -->
    <div class="section-title">Penyusutan Kendaraan (Depresiasi 15%/Tahun)</div>
    <table>
        <thead>
            <tr>
                <th>Kendaraan</th>
                <th>No. Polisi</th>
                <th>Thn Perolehan</th>
                <th>Harga Perolehan</th>
                <th>Usia (Thn)</th>
                <th>Total Penyusutan</th>
                <th>Nilai Buku</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($armada as $m): ?>
            <tr>
                <td><?= esc($m['merek'] . ' ' . $m['model']) ?></td>
                <td><strong><?= esc($m['nopol_mobil']) ?></strong></td>
                <td><?= $m['tahun_perolehan'] ?></td>
                <td>Rp <?= number_format($m['harga_perolehan'], 0, ',', '.') ?></td>
                <td><?= $tahun - $m['tahun_perolehan'] ?> thn</td>
                <td style="color:#dc2626">Rp <?= number_format($m['penyusutan'], 0, ',', '.') ?></td>
                <td style="font-weight:800;color:#059669">Rp <?= number_format($m['nilai_buku'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right;font-weight:800">Total Nilai Buku Armada:</td>
                <td></td>
                <td style="font-weight:900;font-size:11px;color:#6c63ff">Rp <?= number_format($totalNilaiBuku, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- Ringkasan Transaksi -->
    <div class="section-title">Ringkasan Transaksi Tahunan (<?= count($data) ?> Transaksi)</div>
    <table>
        <thead>
            <tr><th>Bulan</th><th>Jumlah Transaksi</th><th>Total Pendapatan</th></tr>
        </thead>
        <tbody>
            <?php
            $byBulan = [];
            foreach ($data as $d) {
                $bln = date('n', strtotime($d['tgl_sewa']));
                $byBulan[$bln]['count'] = ($byBulan[$bln]['count'] ?? 0) + 1;
                $byBulan[$bln]['total'] = ($byBulan[$bln]['total'] ?? 0) + $d['total_biaya'];
            }
            ksort($byBulan);
            foreach ($byBulan as $bln => $bdata):
            ?>
            <tr>
                <td><?= date('F', mktime(0,0,0,$bln,1,$tahun)) ?></td>
                <td><?= $bdata['count'] ?> transaksi</td>
                <td>Rp <?= number_format($bdata['total'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Laporan Tahunan RentaCar – Kelompok 2, Teknik Informatika | Dicetak oleh Sistem Otomatis
    </div>
</div>
</body>
</html>
