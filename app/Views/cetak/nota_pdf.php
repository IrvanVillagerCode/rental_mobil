<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Nota Sewa #<?= $sewa['id_sewa'] ?></title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; color: #1f2937; background: #fff; }
.page { padding: 20px; }
.header { border-bottom: 2px solid #111827; padding-bottom: 10px; margin-bottom: 14px; }
.brand { font-size: 18px; font-weight: 800; letter-spacing: 0.5px; }
.subbrand { font-size: 9px; color: #6b7280; margin-top: 2px; }
.header-grid { width: 100%; }
.header-grid td { vertical-align: top; }
.header-grid td:last-child { text-align: right; }
.nota-chip { display: inline-block; padding: 4px 10px; border: 1px solid #111827; border-radius: 999px; font-size: 9px; font-weight: 700; }
.muted { color: #6b7280; }
.section { margin-top: 12px; }
.section-title { font-size: 9px; font-weight: 800; color: #111827; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.7px; }
.info-table { width: 100%; border-collapse: collapse; }
.info-table td { padding: 4px 0; vertical-align: top; }
.info-table td:first-child { width: 34%; color: #6b7280; }
.status { display: inline-block; padding: 3px 8px; border-radius: 999px; font-size: 8px; font-weight: 800; text-transform: uppercase; }
.status-booking { background: #dbeafe; color: #1d4ed8; }
.status-berjalan { background: #ede9fe; color: #6d28d9; }
.status-selesai { background: #dcfce7; color: #15803d; }
.status-dibatalkan { background: #fee2e2; color: #b91c1c; }
.summary { width: 100%; border-collapse: collapse; margin-top: 6px; }
.summary th,
.summary td { border: 1px solid #e5e7eb; padding: 7px 8px; }
.summary th { text-align: left; background: #f9fafb; font-size: 9px; }
.summary td:last-child,
.summary th:last-child { text-align: right; }
.grand-total { margin-top: 12px; padding: 10px 12px; background: #111827; color: #fff; border-radius: 8px; }
.grand-total .label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8; }
.grand-total .value { font-size: 18px; font-weight: 800; margin-top: 2px; }
.foot-grid { width: 100%; margin-top: 18px; }
.foot-grid td { width: 50%; vertical-align: bottom; }
.sign { text-align: center; padding-top: 34px; }
.sign-line { border-top: 1px solid #111827; width: 130px; margin: 0 auto 5px; }
.note-box { margin-top: 12px; padding: 8px 10px; border: 1px dashed #d1d5db; border-radius: 6px; color: #4b5563; font-size: 9px; line-height: 1.5; }
</style>
</head>
<body>
<?php
    $durasi = max(1, (int)((strtotime($sewa['tgl_kembali']) - strtotime($sewa['tgl_sewa'])) / 86400));
    $tarifPerHari = (float)($sewa['harga_sewa_perhari'] ?? 0);
    $subTotal = $durasi * $tarifPerHari;
    $uangMuka = (float)$sewa['uang_muka'];
    $pelunasan = (float)$sewa['pelunasan'];
    $denda = (float)$sewa['denda'];
    $totalBiaya = (float)$sewa['total_biaya'];
    $totalBayar = $uangMuka + $pelunasan;
    $sisaTagihan = max(0, $totalBiaya + $denda - $totalBayar);
?>
<div class="page">
    <div class="header">
        <table class="header-grid">
            <tr>
                <td>
                    <div class="brand">RentaCar</div>
                    <div class="subbrand">Nota transaksi penyewaan kendaraan</div>
                    <div class="subbrand">Kelompok 2 - Teknik Informatika</div>
                </td>
                <td>
                    <div class="nota-chip">NOTA #<?= str_pad((string) $sewa['id_sewa'], 5, '0', STR_PAD_LEFT) ?></div>
                    <div class="muted" style="margin-top:6px;">Dicetak: <?= date('d/m/Y H:i') ?></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <table class="info-table">
            <tr>
                <td>Status Transaksi</td>
                <td>
                    <span class="status status-<?= esc($sewa['status_transaksi']) ?>">
                        <?= esc(strtoupper($sewa['status_transaksi'])) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td>Tanggal Transaksi</td>
                <td><?= date('d F Y H:i', strtotime($sewa['created_at'])) ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Data Penyewa</div>
        <table class="info-table">
            <tr><td>Nama</td><td><?= esc($sewa['nama_penyewa']) ?></td></tr>
            <tr><td>Kontak</td><td><?= esc($sewa['kontak']) ?></td></tr>
            <tr><td>ID User</td><td><?= esc($sewa['id_user'] ?: '-') ?></td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Data Kendaraan</div>
        <table class="info-table">
            <tr><td>Kendaraan</td><td><?= esc(trim(($sewa['merek'] ?? '') . ' ' . ($sewa['model'] ?? ''))) ?></td></tr>
            <tr><td>No. Polisi</td><td><?= esc($sewa['nopol_mobil'] ?? '-') ?></td></tr>
            <tr><td>Jenis Sewa</td><td><?= esc(ucwords($sewa['jenis_sewa'])) ?></td></tr>
            <tr><td>Mulai Sewa</td><td><?= date('d F Y', strtotime($sewa['tgl_sewa'])) ?></td></tr>
            <tr><td>Kembali</td><td><?= date('d F Y', strtotime($sewa['tgl_kembali'])) ?></td></tr>
            <tr><td>Durasi</td><td><?= $durasi ?> hari</td></tr>
        </table>
    </div>

    <?php if ($kondisi): ?>
    <div class="section">
        <div class="section-title">Kondisi Kendaraan</div>
        <table class="info-table">
            <tr><td>STNK</td><td><?= $kondisi['stnk_tersedia'] ? 'Tersedia' : 'Tidak tersedia' ?></td></tr>
            <tr><td>BBM Keluar</td><td><?= esc($kondisi['bbm_keluar'] ?? '-') ?></td></tr>
            <tr><td>BBM Kembali</td><td><?= esc($kondisi['bbm_kembali'] ?? '-') ?></td></tr>
            <tr><td>Fisik Keluar</td><td><?= esc($kondisi['fisik_keluar'] ?? 'Tidak ada catatan') ?></td></tr>
            <tr><td>Fisik Kembali</td><td><?= esc($kondisi['fisik_kembali'] ?? 'Belum ada catatan') ?></td></tr>
        </table>
    </div>
    <?php endif; ?>

    <div class="section">
        <div class="section-title">Rincian Pembayaran</div>
        <table class="summary">
            <tr>
                <th>Uraian</th>
                <th>Nominal</th>
            </tr>
            <tr>
                <td>Tarif sewa per hari</td>
                <td>Rp <?= number_format($tarifPerHari, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Subtotal sewa (<?= $durasi ?> hari)</td>
                <td>Rp <?= number_format($subTotal, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Uang muka</td>
                <td>Rp <?= number_format($uangMuka, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Pelunasan</td>
                <td>Rp <?= number_format($pelunasan, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Denda</td>
                <td>Rp <?= number_format($denda, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Total dibayar</td>
                <td>Rp <?= number_format($totalBayar, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Sisa tagihan</td>
                <td>Rp <?= number_format($sisaTagihan, 0, ',', '.') ?></td>
            </tr>
        </table>
        <div class="grand-total">
            <div class="label">Total tagihan transaksi</div>
            <div class="value">Rp <?= number_format($totalBiaya + $denda, 0, ',', '.') ?></div>
        </div>
    </div>

    <div class="note-box">
        Nota ini merupakan bukti transaksi penyewaan kendaraan. Simpan nota ini sebagai arsip pembayaran dan verifikasi saat pengembalian kendaraan.
    </div>

    <table class="foot-grid">
        <tr>
            <td>
                <div class="sign">
                    <div class="sign-line"></div>
                    <div>Penyewa</div>
                    <div class="muted"><?= esc($sewa['nama_penyewa']) ?></div>
                </div>
            </td>
            <td>
                <div class="sign">
                    <div class="sign-line"></div>
                    <div>Petugas</div>
                    <div class="muted">RentaCar Management</div>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
