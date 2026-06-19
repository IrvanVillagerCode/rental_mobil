<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi #<?= $sewa['id_sewa'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6fb; margin:0; padding: 20px; color:#333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 40px; border-radius: 12px; background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #6C63FF; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #6C63FF; font-size: 28px; font-weight: 800; }
        .details { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .details div { line-height: 1.6; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .table th, .table td { padding: 14px; border-bottom: 1px solid #ddd; text-align: left; }
        .table th { background: rgba(108, 99, 255, 0.05); font-weight: 700; color: #555; border-bottom: 2px solid #6C63FF; }
        .total { text-align: right; font-size: 20px; font-weight: 800; margin-top: 20px; color: #333; }
        .footer { text-align: center; margin-top: 50px; font-size: 14px; color: #777; padding-top: 20px; border-top: 1px solid #eee; }
        .btn-print { display: inline-block; background: #6C63FF; color: #fff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold; margin-bottom: 20px; cursor: pointer; border: none; font-family: inherit; font-size: 16px; box-shadow: 0 4px 12px rgba(108, 99, 255, 0.3); transition: all 0.2s;}
        .btn-print:hover { background: #5a52d5; transform: translateY(-2px); }
        .back-btn { background: #64748b; box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3); margin-left: 10px; }
        .back-btn:hover { background: #475569; }
        
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 14px; }
        .status-lunas { background: rgba(34, 197, 94, 0.1); color: #16a34a; border: 1px solid #16a34a; }
        .status-belum { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid #d97706; }

        @media print {
            body { background: #fff; padding: 0; }
            .invoice-box { box-shadow: none; border: none; padding: 0; }
            .btn-print, .back-btn { display: none !important; }
        }
    </style>
</head>
<body>
    <div style="text-align:center">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Nota Transaksi</button>
        <a href="<?= session()->get('role') === 'admin' ? base_url('penyewaan') : base_url('dashboard') ?>" class="btn-print back-btn">⬅ Kembali ke Dashboard</a>
    </div>

    <div class="invoice-box">
        <div class="header">
            <div>
                <h1>RENTAL MOBIL</h1>
                <div style="font-size:15px; margin-top:5px; color:#666; font-weight:600">Sistem Reservasi Realtime</div>
            </div>
            <div style="text-align:right">
                <strong style="font-size:18px; color:#333">NOTA TRANSAKSI #<?= str_pad($sewa['id_sewa'], 4, '0', STR_PAD_LEFT) ?></strong><br>
                <div style="color:#777; margin-top:4px; font-size:14px">Tanggal Cetak: <?= date('d/m/Y H:i') ?></div>
            </div>
        </div>

        <div class="details">
            <div>
                <strong style="color:#555; text-transform:uppercase; font-size:12px; letter-spacing:1px">Data Penyewa</strong><br>
                <div style="font-size:18px; font-weight:700; margin-top:4px"><?= esc($sewa['nama_penyewa']) ?></div>
                <div style="color:#555; margin-top:2px">Kontak: <?= esc($sewa['kontak']) ?></div>
            </div>
            <div style="text-align:right">
                <strong style="color:#555; text-transform:uppercase; font-size:12px; letter-spacing:1px">Status Pembayaran</strong><br>
                <div style="margin-top:6px; margin-bottom:6px">
                    <?php if ($sewa['status_pembayaran'] === 'lunas'): ?>
                        <span class="status-badge status-lunas">✅ LUNAS</span>
                    <?php else: ?>
                        <span class="status-badge status-belum">⏳ BELUM LUNAS</span>
                    <?php endif; ?>
                </div>
                <div style="color:#555; font-size:14px">Metode: <strong><?= strtoupper($sewa['metode_pembayaran']) ?></strong></div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Deskripsi Kendaraan</th>
                    <th>Tgl Sewa</th>
                    <th>Tgl Kembali</th>
                    <th>Jenis Sewa</th>
                    <th style="text-align:right">Biaya</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong style="font-size:15px"><?= esc($sewa['merek'] . ' ' . $sewa['model']) ?></strong><br>
                        <span style="color:#666; font-size:13px"><?= esc($sewa['nopol_mobil']) ?></span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($sewa['tgl_sewa'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($sewa['tgl_kembali'])) ?></td>
                    <td><?= ucwords($sewa['jenis_sewa']) ?></td>
                    <td style="text-align:right">Rp <?= number_format($sewa['total_biaya'], 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            Total Pembayaran: <span style="color:#6C63FF">Rp <?= number_format($sewa['total_biaya'], 0, ',', '.') ?></span>
        </div>

        <div class="footer">
            <strong>Terima kasih telah menggunakan layanan Rental Mobil kami.</strong><br>
            Nota ini sah secara sistem sebagai bukti transaksi dan konfirmasi pengambilan unit kendaraan.
        </div>
    </div>
</body>
</html>
