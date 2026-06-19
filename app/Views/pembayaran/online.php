<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<?php $sisaTagihan = $sewa['total_biaya'] - $sewa['uang_muka']; ?>
<div class="page-header">
    <h2><i class="bi bi-wallet2"></i> Pembayaran Online</h2>
</div>
<div class="card" style="max-width:600px; margin:auto">
    <div style="text-align:center; margin-bottom:24px">
        <h4 style="margin:0; color:var(--text-main)">Sisa Tagihan</h4>
        <h2 style="color:var(--primary); font-weight:800; margin:8px 0">Rp <?= number_format($sisaTagihan, 0, ',', '.') ?></h2>
        <?php if ($sewa['uang_muka'] > 0): ?>
            <span class="badge" style="background:#0ea5e9; color:#fff"><i class="bi bi-check-circle"></i> Sudah dibayar: Rp <?= number_format($sewa['uang_muka'], 0, ',', '.') ?></span>
        <?php else: ?>
            <span class="badge bg-warning text-dark"><i class="bi bi-clock-history"></i> Menunggu Pembayaran</span>
        <?php endif; ?>
    </div>

    <form action="<?= base_url('penyewaan/proses-bayar-online/' . $sewa['id_sewa']) ?>" method="POST" id="payment-form">
        <?= csrf_field() ?>
        
        <div style="font-weight:700; margin-bottom:12px"><i class="bi bi-person-vcard"></i> Informasi Pembayar</div>
        <div class="form-group" style="margin-bottom:16px">
            <label>Nomor Rekening / E-Wallet</label>
            <input type="text" name="nomor_rekening" class="form-control" placeholder="Contoh: 1234567890" required>
        </div>
        
        <div class="form-group" style="margin-bottom:24px">
            <label>Nominal Pembayaran (Bisa bayar sebagian/DP)</label>
            <input type="number" name="nominal_bayar" class="form-control" value="<?= $sisaTagihan ?>" max="<?= $sisaTagihan ?>" min="50000" required>
        </div>
        
        <div style="font-weight:700; margin-bottom:12px"><i class="bi bi-bank"></i> Pilih Metode</div>
        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:24px">
            <label style="display:flex; align-items:center; gap:12px; padding:16px; border:1px solid var(--border); border-radius:8px; cursor:pointer">
                <input type="radio" name="bank" value="bca" required style="width:18px;height:18px">
                <div><strong>BCA Virtual Account</strong></div>
            </label>
            <label style="display:flex; align-items:center; gap:12px; padding:16px; border:1px solid var(--border); border-radius:8px; cursor:pointer">
                <input type="radio" name="bank" value="mandiri" style="width:18px;height:18px">
                <div><strong>Mandiri Virtual Account</strong></div>
            </label>
            <label style="display:flex; align-items:center; gap:12px; padding:16px; border:1px solid var(--border); border-radius:8px; cursor:pointer">
                <input type="radio" name="bank" value="gopay" style="width:18px;height:18px">
                <div><strong>GoPay</strong></div>
            </label>
            <label style="display:flex; align-items:center; gap:12px; padding:16px; border:1px solid var(--border); border-radius:8px; cursor:pointer">
                <input type="radio" name="bank" value="qris" style="width:18px;height:18px">
                <div><strong>QRIS</strong></div>
            </label>
        </div>

        <button type="submit" class="btn-primary" style="width:100%; padding:14px; font-size:1.1rem" id="btn-pay" onclick="simulatePayment(event)">
            <i class="bi bi-shield-check"></i> Bayar Sekarang
        </button>
        <div id="loader" style="display:none; text-align:center; padding:16px">
            <div class="spinner-border" style="color:var(--primary); width:2rem; height:2rem" role="status"></div>
            <div style="margin-top:8px; font-weight:600">Memproses pembayaran secara real-time...</div>
        </div>
    </form>
</div>

<script>
function simulatePayment(e) {
    const form = document.getElementById('payment-form');
    if (!form.checkValidity()) return;
    e.preventDefault();
    document.getElementById('btn-pay').style.display = 'none';
    document.getElementById('loader').style.display = 'block';
    
    // Simulate API delay
    setTimeout(() => {
        form.submit();
    }, 2500);
}
</script>
<?php $this->endSection() ?>
