<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>

<?php
$title     = 'Monitoring Transaksi Payment AutoVora';
$pageTitle = 'Monitoring Midtrans';
?>

<div class="card mb-4">
    <div class="card-body">
        <form action="<?= base_url('transaksi/monitoring') ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-muted">Status Pembayaran</label>
                <select name="status" class="form-select">
                    <option value="all" <?= $filter_status == 'all' ? 'selected' : '' ?>>Semua Status</option>
                    <option value="success" <?= $filter_status == 'success' ? 'selected' : '' ?>>Success / Paid</option>
                    <option value="pending" <?= $filter_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="expire" <?= $filter_status == 'expire' ? 'selected' : '' ?>>Expired</option>
                    <option value="cancel" <?= $filter_status == 'cancel' ? 'selected' : '' ?>>Cancelled</option>
                    <option value="deny" <?= $filter_status == 'deny' ? 'selected' : '' ?>>Denied / Failed</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted">Tanggal Transaksi</label>
                <input type="date" name="tanggal" class="form-control" value="<?= esc($filter_tanggal) ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn-primary w-100"><i class="bi bi-filter"></i> Filter Data</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title"><i class="bi bi-activity"></i> Log Transaksi Masuk</div>
    </div>
    
    <?php if (empty($transactions)): ?>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Tidak ada transaksi yang sesuai kriteria.</p>
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Order ID</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Waktu (WIB)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                    <tr>
                        <td>
                            <div style="font-weight:600; color:var(--text-primary);"><?= esc($t['nama_lengkap']) ?></div>
                            <div style="font-size:0.75rem; color:var(--text-muted);"><?= esc($t['email']) ?></div>
                        </td>
                        <td>
                            <strong style="color:var(--accent-light); font-size: 0.85rem;"><?= esc($t['order_id']) ?></strong><br>
                            <span style="font-size:0.75rem; color:var(--text-muted);">Sewa: <?= esc($t['merek'] . ' ' . $t['model']) ?></span>
                        </td>
                        <td style="font-weight:700; color:var(--success);">Rp <?= number_format($t['amount'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($t['payment_type']): ?>
                                <span class="badge badge-secondary" style="text-transform:uppercase; font-size: 0.7rem;"><?= esc($t['payment_type']) ?></span>
                            <?php else: ?>
                                <span style="color:var(--text-muted);">-</span>
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
