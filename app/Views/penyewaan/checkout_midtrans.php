<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>

<?php
$title     = 'Checkout Pembayaran AutoVora';
$pageTitle = 'Checkout Pembayaran';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card" style="margin-top: 30px;">
            <div class="card-header" style="background: linear-gradient(135deg, #6C63FF, #5a52d5); color: #fff; padding: 20px;">
                <div class="card-title" style="margin:0;"><i class="bi bi-wallet2"></i> Checkout Pembayaran</div>
            </div>
            <div class="card-body" style="padding: 30px;">
                <div class="text-center mb-4">
                    <h4 style="color: var(--text-primary); font-weight: 700;">Order ID: <?= esc($orderId) ?></h4>
                    <p style="color: var(--text-secondary);">Selesaikan pembayaran untuk mengonfirmasi pesanan kendaraan Anda.</p>
                </div>

                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                    <div class="row">
                        <div class="col-sm-6">
                            <span style="color: var(--text-muted); font-size: 0.85rem;">Mobil Disewa:</span>
                            <div style="font-weight: 600; font-size: 1.1rem; color: var(--text-primary);"><?= esc($sewa['merek'] . ' ' . $sewa['model']) ?></div>
                        </div>
                        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                            <span style="color: var(--text-muted); font-size: 0.85rem;">Total Tagihan:</span>
                            <div style="font-weight: 800; font-size: 1.5rem; color: var(--success);">Rp <?= number_format($sewa['total_biaya'], 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button id="pay-button" class="btn-primary" style="padding: 12px 30px; font-size: 1.1rem; width: 100%; justify-content: center;">
                        <i class="bi bi-shield-lock-fill"></i> Bayar Sekarang dengan Midtrans
                    </button>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 15px;">
                        Pembayaran diproses secara aman oleh Midtrans. Berbagai metode tersedia (QRIS, GoPay, Transfer Bank, dll).
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= esc($clientKey) ?>"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('<?= esc($snapToken) ?>', {
            onSuccess: function(result){
                alert("Pembayaran Berhasil! Pesanan Anda telah terkonfirmasi.");
                window.location.href = "<?= base_url('transaksi/riwayat') ?>";
            },
            onPending: function(result){
                alert("Menunggu pembayaran Anda!");
                window.location.href = "<?= base_url('transaksi/riwayat') ?>";
            },
            onError: function(result){
                alert("Pembayaran Gagal!");
                window.location.href = "<?= base_url('transaksi/riwayat') ?>";
            },
            onClose: function(){
                alert('Anda menutup popup sebelum menyelesaikan pembayaran.');
            }
        });
    };
</script>

<?php $this->endSection() ?>
