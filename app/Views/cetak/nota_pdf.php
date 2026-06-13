<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Nota Sewa #<?= $sewa['id_sewa'] ?></title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; color: #1a1a2e; background: #fff; }
.container { width: 100%; max-width: 700px; margin: 0 auto; padding: 20px; }
.header { text-align: center; border-bottom: 3px solid #6c63ff; padding-bottom: 14px; margin-bottom: 18px; }
.header h1 { font-size: 22px; font-weight: 900; color: #6c63ff; letter-spacing: -0.5px; }
.header p { font-size: 10px; color: #666; margin-top: 2px; }
.nota-id { display: inline-block; background: #6c63ff; color: #fff; padding: 4px 14px; border-radius: 99px; font-size: 10px; font-weight: 700; margin-top: 6px; }
.section-title { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #6c63ff; background: #f0eeff; padding: 6px 12px; border-left: 3px solid #6c63ff; margin: 14px 0 8px; }
table.info { width: 100%; border-collapse: collapse; }
table.info td { padding: 5px 8px; font-size: 10.5px; vertical-align: top; }
table.info td:first-child { width: 35%; color: #555; font-weight: 600; }
table.info td:last-child { color: #1a1a2e; font-weight: 500; }
.divider { border: none; border-top: 1px dashed #ddd; margin: 12px 0; }
.total-box { background: linear-gradient(135deg, #6c63ff, #8b5cf6); color: #fff; border-radius: 8px; padding: 14px 18px; margin-top: 16px; }
.total-box .label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85; }
.total-box .amount { font-size: 22px; font-weight: 900; margin-top: 2px; }
.total-grid { display: flex; gap: 16px; margin-top: 12px; }
.total-item { flex: 1; background: rgba(255,255,255,0.15); border-radius: 6px; padding: 8px 12px; }
.total-item .item-label { font-size: 9px; opacity: 0.8; }
.total-item .item-val { font-size: 13px; font-weight: 800; }
.badge-status { display: inline-block; padding: 3px 10px; border-radius: 99px; font-size: 9px; font-weight: 800; text-transform: uppercase; }
.badge-selesai    { background: #d1fae5; color: #059669; }
.badge-berjalan   { background: #ede9fe; color: #6c63ff; }
.badge-booking    { background: #dbeafe; color: #2563eb; }
.badge-dibatalkan { background: #fee2e2; color: #dc2626; }
.kondisi-grid { display: flex; gap: 12px; }
.kondisi-col { flex: 1; }
.kondisi-item { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px solid #f0f0f0; }
.kondisi-label { color: #777; font-size: 10px; }
.kondisi-val { font-weight: 700; font-size: 10px; }
.footer { margin-top: 24px; border-top: 1px solid #eee; padding-top: 14px; display: flex; justify-content: space-between; }
.sign-box { text-align: center; }
.sign-box .sign-line { width: 140px; border-top: 1px solid #333; margin-top: 50px; }
.sign-box .sign-label { font-size: 9px; color: #555; margin-top: 4px; }
.watermark { color: #f0eeff; font-size: 80px; font-weight: 900; position: fixed; top: 35%; left: 50%; transform: translate(-50%, -50%) rotate(-35deg); opacity: 0.06; pointer-events: none; white-space: nowrap; z-index: -1; }
</style>
</head>
<body>
<div class="watermark">RENTACAR</div>
<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>🚗 RentaCar</h1>
        <p>Sistem Informasi Rental Mobil – Kelompok 2, Teknik Informatika</p>
        <span class="nota-id">NOTA SEWA #<?= str_pad($sewa['id_sewa'], 5, '0', STR_PAD_LEFT) ?></span>
    </div>

    <!-- Status -->
    <div style="text-align:right;margin-bottom:8px">
        <span class="badge-status badge-<?= $sewa['status_transaksi'] ?>"><?= strtoupper($sewa['status_transaksi']) ?></span>
        <span style="font-size:9px;color:#777;margin-left:8px">Dibuat: <?= date('d/m/Y H:i', strtotime($sewa['created_at'])) ?></span>
    </div>

    <!-- Data Penyewa -->
    <div class="section-title">Data Penyewa</div>
    <table class="info">
        <tr><td>Nama Penyewa</td><td>: <?= esc($sewa['nama_penyewa']) ?></td></tr>
        <tr><td>No. Kontak</td><td>: <?= esc($sewa['kontak']) ?></td></tr>
    </table>

    <!-- Data Kendaraan -->
    <div class="section-title">Data Kendaraan</div>
    <table class="info">
        <tr><td>Kendaraan</td><td>: <?= esc(($sewa['merek'] ?? '') . ' ' . ($sewa['model'] ?? '')) ?></td></tr>
        <tr><td>No. Polisi</td><td>: <strong><?= esc($sewa['nopol_mobil'] ?? '-') ?></strong></td></tr>
        <tr><td>Jenis Sewa</td><td>: <?= esc($sewa['jenis_sewa']) ?></td></tr>
        <tr><td>Tanggal Mulai</td><td>: <?= date('d F Y', strtotime($sewa['tgl_sewa'])) ?></td></tr>
        <tr><td>Tanggal Kembali</td><td>: <?= date('d F Y', strtotime($sewa['tgl_kembali'])) ?></td></tr>
        <?php
            $durasi = max(1, (int)((strtotime($sewa['tgl_kembali']) - strtotime($sewa['tgl_sewa'])) / 86400));
        ?>
        <tr><td>Durasi Sewa</td><td>: <strong><?= $durasi ?> hari</strong></td></tr>
        <tr><td>Tarif/Hari</td><td>: Rp <?= number_format($sewa['harga_sewa_perhari'] ?? 0, 0, ',', '.') ?></td></tr>
    </table>

    <!-- Kondisi Kendaraan -->
    <?php if ($kondisi): ?>
    <div class="section-title">Kondisi Kendaraan</div>
    <div class="kondisi-grid">
        <div class="kondisi-col">
            <div style="font-size:9px;font-weight:800;color:#555;margin-bottom:6px;text-transform:uppercase">Saat Keluar</div>
            <div class="kondisi-item"><span class="kondisi-label">STNK</span><span class="kondisi-val"><?= $kondisi['stnk_tersedia'] ? '✅ Ada' : '❌ Tidak Ada' ?></span></div>
            <div class="kondisi-item"><span class="kondisi-label">BBM</span><span class="kondisi-val"><?= esc($kondisi['bbm_keluar'] ?? '-') ?></span></div>
            <div class="kondisi-item"><span class="kondisi-label">Fisik</span><span class="kondisi-val"><?= esc($kondisi['fisik_keluar'] ?? 'Mulus') ?></span></div>
        </div>
        <div class="kondisi-col">
            <div style="font-size:9px;font-weight:800;color:#555;margin-bottom:6px;text-transform:uppercase">Saat Kembali</div>
            <div class="kondisi-item"><span class="kondisi-label">BBM</span><span class="kondisi-val"><?= esc($kondisi['bbm_kembali'] ?? '-') ?></span></div>
            <div class="kondisi-item"><span class="kondisi-label">Fisik</span><span class="kondisi-val"><?= esc($kondisi['fisik_kembali'] ?? 'Belum kembali') ?></span></div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Rincian Pembayaran -->
    <div class="total-box">
        <div class="label">Total Biaya Sewa</div>
        <div class="amount">Rp <?= number_format($sewa['total_biaya'], 0, ',', '.') ?></div>
        <div class="total-grid">
            <div class="total-item">
                <div class="item-label">Uang Muka (DP)</div>
                <div class="item-val">Rp <?= number_format($sewa['uang_muka'], 0, ',', '.') ?></div>
            </div>
            <div class="total-item">
                <div class="item-label">Pelunasan</div>
                <div class="item-val">Rp <?= number_format($sewa['pelunasan'], 0, ',', '.') ?></div>
            </div>
            <div class="total-item">
                <div class="item-label">Denda</div>
                <div class="item-val">Rp <?= number_format($sewa['denda'], 0, ',', '.') ?></div>
            </div>
            <div class="total-item">
                <div class="item-label">Sisa Tagihan</div>
                <div class="item-val">Rp <?= number_format(max(0, $sewa['total_biaya'] - $sewa['uang_muka'] - $sewa['pelunasan']), 0, ',', '.') ?></div>
            </div>
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="footer">
        <div class="sign-box">
            <div class="sign-line"></div>
            <div class="sign-label">Penyewa</div>
            <div style="font-size:10px;font-weight:700;margin-top:4px"><?= esc($sewa['nama_penyewa']) ?></div>
        </div>
        <div style="text-align:center;color:#aaa;font-size:9px;align-self:flex-end">
            <p>Nota dicetak: <?= date('d/m/Y H:i') ?></p>
            <p style="margin-top:2px">Kelompok 2 – Teknik Informatika</p>
        </div>
        <div class="sign-box">
            <div class="sign-line"></div>
            <div class="sign-label">Petugas / Pengelola</div>
            <div style="font-size:10px;font-weight:700;margin-top:4px">RentaCar Management</div>
        </div>
    </div>
</div>
</body>
</html>
