<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>

<?php
$title     = 'Riwayat Transaksi AutoVora';
$pageTitle = 'Riwayat Transaksi';
?>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="bi bi-clock-history"></i> Riwayat Pembayaran Midtrans</div>
    </div>
    
    <?php if (empty($transactions)): ?>
        <div class="empty-state">
            <i class="bi bi-receipt"></i>
            <p>Belum ada riwayat transaksi pembayaran.</p>
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Kendaraan</th>
                        <th>Total Pembayaran</th>
                        <th>Metode</th>
                        <th>Status Transaksi</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                    <tr>
                        <td><strong style="color: var(--text-primary);"><?= esc($t['order_id']) ?></strong></td>
                        <td>
                            <div style="font-weight:600;"><?= esc($t['merek'] . ' ' . $t['model']) ?></div>
                            <div style="font-size:0.75rem; color:var(--text-muted);"><?= esc($t['nopol_mobil']) ?></div>
                        </td>
                        <td style="font-weight:700; color:var(--success);">Rp <?= number_format($t['amount'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($t['payment_type']): ?>
                                <span class="badge badge-secondary" style="text-transform:uppercase;"><?= esc($t['payment_type']) ?></span>
                            <?php else: ?>
                                <span style="color:var(--text-muted); font-size:0.8rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                                $status = strtolower($t['transaction_status']);
                                $badgeClass = 'badge-warning'; // pending
                                if (in_array($status, ['success', 'capture', 'settlement'])) $badgeClass = 'badge-tersedia'; // hijau
                                else if (in_array($status, ['deny', 'cancel', 'failed'])) $badgeClass = 'badge-perawatan'; // merah
                                else if ($status == 'expire') $badgeClass = 'badge-disewa'; // abu-abu/biru
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= strtoupper($status) ?></span>
                        </td>
                        <td><?= date('d M Y, H:i', strtotime($t['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
