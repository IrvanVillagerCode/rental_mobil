<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>

<?php
$title     = 'Dashboard Pelanggan';
$pageTitle = 'Dashboard Pelanggan';
?>

<!-- Realtime Alerts Container -->
<div id="realtime-alerts"></div>

<div class="welcome-banner">
    <div class="welcome-content">
        <h2>Selamat Datang kembali, <?= esc(session()->get('nama') ?? 'Pelanggan') ?>! 👋</h2>
        <p>Kelola penyewaan mobil Anda dengan mudah dan efisien secara realtime.</p>
    </div>
    <div class="welcome-date">
        <i class="bi bi-clock"></i> Update: <span id="welcome-update-time"><?= date('H:i') ?></span> WIB
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple"><i class="bi bi-file-earmark-text"></i></div>
        <div class="stat-info">
            <div class="stat-label">Total Penyewaan</div>
            <div class="stat-value" id="user-stat-total"><?= $total_sewa ?></div>
            <div class="stat-sub">Semua transaksi Anda</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
        <div class="stat-info">
            <div class="stat-label">Penyewaan Aktif</div>
            <div class="stat-value" id="user-stat-aktif"><?= $sewa_aktif ?></div>
            <div class="stat-sub">Booking & berjalan</div>
        </div>
    </div>
    <div class="stat-card featured-stat">
        <div class="stat-icon blue"><i class="bi bi-cash-coin"></i></div>
        <div class="stat-info">
            <div class="stat-label">Total Pengeluaran</div>
            <div class="stat-value" id="user-stat-pengeluaran" style="font-size:1.3rem">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
            <div class="stat-sub">Dari transaksi berjalan/selesai</div>
        </div>
    </div>
</div>

<!-- Dashboard Grid (2 Columns: History & Live Fleet) -->
<div class="dashboard-grid">
    <!-- Left Column: Rental History -->
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-clock-history"></i> Riwayat Penyewaan Terbaru</div>
            <a href="<?= base_url('/#vehicles') ?>" class="btn-secondary btn-sm"><i class="bi bi-plus-circle"></i> Sewa Baru</a>
        </div>
        <?php if (empty($my_rentals)): ?>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Anda belum memiliki riwayat penyewaan mobil.</p>
        </div>
        <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kendaraan</th>
                        <th>Tgl Sewa</th>
                        <th>Tgl Kembali</th>
                        <th>Total Biaya</th>
                        <th>Status / Sisa Waktu</th>
                        <th style="text-align: center">Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($my_rentals as $s): ?>
                    <tr id="rental-row-<?= $s['id_sewa'] ?>" data-tarif-harian="<?= (float)$s['harga_sewa_perhari'] ?>">
                        <td>
                            <div style="font-weight:600;color:var(--text-primary)"><?= esc($s['merek'] . ' ' . $s['model']) ?></div>
                            <div style="font-size:0.75rem;color:var(--text-muted)"><?= esc($s['nopol_mobil']) ?></div>
                        </td>
                        <td><?= date('d/m/Y', strtotime($s['tgl_sewa'])) ?></td>
                        <td class="col-tgl-kembali"><?= date('d/m/Y', strtotime($s['tgl_kembali'])) ?></td>
                        <td class="col-total-biaya" style="color:var(--success);font-weight:600">Rp <?= number_format($s['total_biaya'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge badge-<?= $s['status_transaksi'] ?>"><?= $s['status_transaksi'] ?></span>
                            <?php if ($s['status_transaksi'] === 'berjalan'): ?>
                            <div style="font-size:0.72rem;color:var(--success);font-weight:700;margin-top:4px">
                                <i class="bi bi-patch-check-fill"></i> Berhasil menyewa mobil
                            </div>
                            <div class="rental-timer" data-sewa-id="<?= $s['id_sewa'] ?>" style="font-size:0.72rem;color:var(--accent-light);font-weight:600;margin-top:2px">
                                <i class="bi bi-hourglass-split"></i> Loading timer...
                            </div>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center">
                            <?php if (in_array($s['status_transaksi'], ['booking', 'berjalan', 'selesai'])): ?>
                            <a href="<?= base_url('penyewaan/invoice/' . $s['id_sewa']) ?>" class="btn-secondary btn-sm" target="_blank" title="Cetak Nota Transaksi">
                                <i class="bi bi-printer" style="color: var(--primary)"></i> Cetak Nota
                            </a>
                            <?php elseif ($s['status_transaksi'] === 'menunggu_pembayaran'): ?>
                            <a href="<?= base_url('penyewaan/bayar-online/' . $s['id_sewa']) ?>" class="btn-primary btn-sm">
                                <i class="bi bi-wallet2"></i> Bayar
                            </a>
                            <?php else: ?>
                            <span style="font-size:0.75rem; color:var(--text-muted)">Menunggu...</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- Right Column: Live Fleet & CS Link -->
    <div style="display:flex;flex-direction:column;gap:20px">
        <!-- Live Fleet Status -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="bi bi-car-front"></i> Status Armada Terkini</div>
            </div>
            <div class="table-wrapper" style="margin-top:8px">
                <table style="width: 100%">
                    <thead>
                        <tr>
                            <th>Mobil</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="live-fleet-body">
                        <?php foreach ($mobil_list as $m): ?>
                        <tr>
                            <td>
                                <div style="font-weight:600;font-size:0.85rem;color:var(--text-primary)"><?= esc($m['merek'] . ' ' . $m['model']) ?></div>
                                <div style="font-size:0.7rem;color:var(--text-muted)"><?= esc($m['nopol_mobil']) ?></div>
                            </td>
                            <td>
                                <?php
                                $statusClass = 'badge-tersedia';
                                $statusLabel = 'Tersedia';
                                if ($m['status_mobil'] === 'disewa') {
                                    $statusClass = 'badge-disewa';
                                    $statusLabel = 'Sedang Jalan';
                                } elseif ($m['status_mobil'] === 'perawatan') {
                                    $statusClass = 'badge-perawatan';
                                    $statusLabel = 'Perbaikan';
                                }
                                ?>
                                <span class="badge <?= $statusClass ?>" style="font-size:0.65rem;padding:2px 8px"><?= $statusLabel ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="bi bi-lightning"></i> Menu Pintasan</div>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;margin-top:8px">
                <a href="<?= base_url('/#vehicles') ?>" class="btn-primary" style="justify-content: center">
                    <i class="bi bi-search"></i> Cari & Booking Mobil
                </a>
                
                <a href="https://wa.me/6281234567890?text=Halo%20RentaCar,%20saya%20butuh%20bantuan%20terkait%20penyewaan" target="_blank" class="btn-secondary" style="justify-content: center">
                    <i class="bi bi-whatsapp" style="color:#25d366"></i> Hubungi Customer Service
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Perpanjangan Sewa -->
<div class="modal-overlay" id="modalExtend" style="display: none;">
    <div class="modal-box">
        <h3><i class="bi bi-cash-coin"></i> Pembayaran Online (Perpanjangan)</h3>
        <p style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:16px">
            Perpanjang sewa mobil Anda selama 1 hari dengan melakukan pembayaran online secara realtime.
        </p>
        <div style="background:rgba(255,255,255,0.02);padding:12px;border-radius:8px;margin-bottom:16px;border:1px solid var(--border)">
            <div style="font-size:0.85rem;color:var(--text-muted)">Estimasi Biaya Tambahan (1 Hari):</div>
            <div id="extend-cost" style="font-size:1.2rem;font-weight:800;color:var(--success)">Rp 0</div>
        </div>
        
        <form id="formExtend" onsubmit="submitExtension(event)">
            <input type="hidden" id="extend-sewa-id">
            
            <div class="form-group">
                <label>Metode Pembayaran</label>
                <select id="payment-method" class="form-control" required>
                    <option value="gopay">📱 E-Wallet (GoPay / OVO / DANA)</option>
                    <option value="bca">🏦 Virtual Account BCA</option>
                    <option value="cc">💳 Kartu Kredit</option>
                </select>
            </div>
            
            <div id="cc-details" style="display:none;margin-bottom:12px">
                <div class="form-group" style="margin-bottom:8px">
                    <label>Nomor Kartu</label>
                    <input type="text" class="form-control" placeholder="4111 2222 3333 4444" minlength="16" maxlength="16">
                </div>
                <div class="form-grid" style="margin-bottom:8px">
                    <div class="form-group" style="margin-bottom:0">
                        <label>Valid Thru</label>
                        <input type="text" class="form-control" placeholder="12/29">
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label>CVV</label>
                        <input type="text" class="form-control" placeholder="123" minlength="3" maxlength="3">
                    </div>
                </div>
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn-primary" id="btn-submit-extend" style="flex: 1">
                    <span class="btn-text"><i class="bi bi-credit-card-2-back"></i> Bayar Sekarang</span>
                    <span class="btn-loader" style="display:none"><i class="bi bi-arrow-repeat spin"></i> Memproses...</span>
                </button>
                <button type="button" class="btn-secondary" onclick="closeExtendModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Pulsing effect for warning notification */
@keyframes pulseAlert {
    0%, 100% { box-shadow: 0 4px 15px rgba(239, 68, 68, 0.15); border-color: rgba(239, 68, 68, 0.3); }
    50% { box-shadow: 0 4px 25px rgba(239, 68, 68, 0.4); border-color: rgba(239, 68, 68, 0.8); }
}
</style>

<script>
// Expose timers to global JS scope
let activeTimers = <?= json_encode($active_timers ?? []) ?>;
let tagihanBelumLunas = [];

document.addEventListener('DOMContentLoaded', () => {
    function formatRupiah(num) {
        return 'Rp ' + parseFloat(num || 0).toLocaleString('id-ID');
    }

    // Toggle credit card fields
    const paymentSelect = document.getElementById('payment-method');
    if (paymentSelect) {
        paymentSelect.addEventListener('change', (e) => {
            const ccDetails = document.getElementById('cc-details');
            if (ccDetails) {
                ccDetails.style.display = e.target.value === 'cc' ? 'block' : 'none';
            }
        });
    }

    // Real-time clock for Update Time (Asia/Jakarta WIB)
    function updateRealTimeClock() {
        const timeEl = document.getElementById('welcome-update-time');
        if (timeEl) {
            const now = new Date();
            const str = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'Asia/Jakarta' }).replace(/\./g, ':');
            timeEl.textContent = str;
        }
    }
    // Start real-time clock
    setInterval(updateRealTimeClock, 1000);
    updateRealTimeClock();

    // Poll stats from AJAX
    function updateCustomerStats() {
        fetch('<?= base_url("dashboard/get-stats-ajax") ?>')
            .then(response => response.json())
            .then(data => {
                // Not updating time from AJAX anymore since we use JS clock
                const totalEl = document.getElementById('user-stat-total');
                const aktifEl = document.getElementById('user-stat-aktif');
                const pengeluaranEl = document.getElementById('user-stat-pengeluaran');

                if (totalEl) totalEl.textContent = data.total_sewa;
                if (aktifEl) aktifEl.textContent = data.sewa_aktif;
                if (pengeluaranEl) pengeluaranEl.textContent = formatRupiah(data.total_pengeluaran);

                // Update active timers map
                activeTimers = data.active_timers ?? {};
                tagihanBelumLunas = data.tagihan_belum_lunas || [];

                // Update Live Fleet Statuses dynamically
                const fleetBody = document.getElementById('live-fleet-body');
                if (fleetBody && data.mobil_list) {
                    let html = '';
                    data.mobil_list.forEach(m => {
                        let statusClass = 'badge-tersedia';
                        let statusLabel = 'Tersedia';
                        if (m.status_mobil === 'disewa') {
                            statusClass = 'badge-disewa';
                            statusLabel = 'Sedang Jalan';
                        } else if (m.status_mobil === 'perawatan') {
                            statusClass = 'badge-perawatan';
                            statusLabel = 'Perbaikan';
                        }
                        html += `
                            <tr>
                                <td>
                                    <div style="font-weight:600;font-size:0.85rem;color:var(--text-primary)">${m.merek} ${m.model}</div>
                                    <div style="font-size:0.7rem;color:var(--text-muted)">${m.nopol_mobil}</div>
                                </td>
                                <td>
                                    <span class="badge ${statusClass}" style="font-size:0.65rem;padding:2px 8px">${statusLabel}</span>
                                </td>
                            </tr>
                        `;
                    });
                    fleetBody.innerHTML = html;
                }
            })
            .catch(err => console.error('Error updating customer statistics:', err));
    }

    // Ticking countdown timer
    function startTimerCountdown() {
        setInterval(() => {
            const now = Math.floor(Date.now() / 1000);
            const alertsContainer = document.getElementById('realtime-alerts');
            let warningHtml = '';

            // Render sisa tagihan warnings
            tagihanBelumLunas.forEach(tagihan => {
                warningHtml += `
                    <div class="alert-toast" style="margin-bottom:12px;cursor:pointer;border-left:4px solid #f59e0b;background:rgba(245, 158, 11, 0.1);padding:12px;border-radius:4px;display:flex;align-items:center;" onclick="window.location.href='<?= base_url('penyewaan/bayar-online/') ?>${tagihan.id_sewa}'">
                        <i class="bi bi-wallet2" style="color:#f59e0b;font-size:1.5rem"></i>
                        <div style="flex: 1; margin-left:12px;">
                            <strong>Pembayaran Belum Lunas!</strong> Transaksi #${tagihan.id_sewa} memiliki sisa tagihan sebesar <strong>Rp ${tagihan.sisa.toLocaleString('id-ID')}</strong>. 
                            <span style="text-decoration:underline;font-weight:700;color:#d97706">Klik di sini untuk melunasi sisa tagihan.</span>
                        </div>
                    </div>
                `;
            });

            Object.keys(activeTimers).forEach(idSewa => {
                const expiryTime = activeTimers[idSewa];
                const remaining = expiryTime - now;
                const timerEl = document.querySelector(`.rental-timer[data-sewa-id="${idSewa}"]`);

                if (remaining > 0) {
                    const minutes = Math.floor(remaining / 60);
                    const seconds = remaining % 60;
                    const formattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                    if (timerEl) {
                        timerEl.innerHTML = `<i class="bi bi-hourglass-split"></i> Sisa Waktu: <strong style="color:var(--warning)">${formattedTime}</strong>`;
                    }

                    // Less than 5 minutes (300 seconds) warning notification
                    if (remaining <= 300) {
                        warningHtml += `
                            <div class="alert-toast error" style="margin-bottom:12px;animation:pulseAlert 2s infinite;cursor:pointer" onclick="openExtendModal(${idSewa})">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <div style="flex: 1">
                                    <strong>Masa Sewa Hampir Habis!</strong> Sisa waktu Anda tinggal <strong>${formattedTime}</strong>. 
                                    <span style="text-decoration:underline;font-weight:700">Klik di sini untuk memperpanjang sewa (Online)</span>.
                                </div>
                            </div>
                        `;
                    }
                } else {
                    if (timerEl) {
                        timerEl.innerHTML = `<i class="bi bi-hourglass-bottom" style="color:var(--danger)"></i> Waktu habis!`;
                    }
                    warningHtml += `
                        <div class="alert-toast error" style="margin-bottom:12px;border-left:4px solid #ef4444;background:rgba(239, 68, 68, 0.1);padding:12px;border-radius:4px;display:flex;align-items:center;">
                            <i class="bi bi-exclamation-octagon-fill" style="color:#ef4444;font-size:1.5rem"></i>
                            <div style="flex: 1; margin-left:12px;">
                                <strong>Peringatan Denda!</strong> Masa sewa transaksi #${idSewa} telah habis! Harap kembalikan unit atau Anda akan dikenakan denda keterlambatan sebesar <strong>Rp 50.000/jam</strong>.
                            </div>
                        </div>
                    `;
                }
            });

            if (alertsContainer) {
                alertsContainer.innerHTML = warningHtml;
            }
        }, 1000);
    }

    // Run polling and countdown
    setInterval(updateCustomerStats, 5000);
    startTimerCountdown();
});

// Modal functions exposed to global scope
function openExtendModal(idSewa) {
    const modal = document.getElementById('modalExtend');
    const input = document.getElementById('extend-sewa-id');
    const costBox = document.getElementById('extend-cost');

    if (modal && input && costBox) {
        input.value = idSewa;
        
        // Read daily rate of vehicle from table row data attribute
        const row = document.getElementById(`rental-row-${idSewa}`);
        const tarif = parseFloat(row.getAttribute('data-tarif-harian') || 0);
        costBox.textContent = 'Rp ' + tarif.toLocaleString('id-ID');
        
        modal.style.display = 'flex';
    }
}

function closeExtendModal() {
    const modal = document.getElementById('modalExtend');
    if (modal) modal.style.display = 'none';
}

function submitExtension(e) {
    e.preventDefault();
    const idSewa = document.getElementById('extend-sewa-id').value;
    const btn = document.getElementById('btn-submit-extend');

    // Show button loader
    const text = btn.querySelector('.btn-text');
    const loader = btn.querySelector('.btn-loader');
    if (text && loader) {
        text.style.display = 'none';
        loader.style.display = 'inline-block';
    }
    btn.disabled = true;

    // Simulate online bank/e-wallet checkout latency (1.5s)
    setTimeout(() => {
        fetch(`<?= base_url("penyewaan/extend-ajax") ?>/${idSewa}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                // Update countdown locally instantly
                activeTimers[idSewa] = Math.floor(Date.now() / 1000) + 600; // Reset virtual timer to 10 minutes

                // Update row values directly
                const row = document.getElementById(`rental-row-${idSewa}`);
                if (row) {
                    const tglKembaliEl = row.querySelector('.col-tgl-kembali');
                    if (tglKembaliEl) tglKembaliEl.textContent = data.new_tgl_kembali;

                    const totalBiayaEl = row.querySelector('.col-total-biaya');
                    if (totalBiayaEl) totalBiayaEl.textContent = 'Rp ' + data.new_total_biaya;
                }

                alert(data.message);
                closeExtendModal();
            } else {
                alert(data.message || 'Gagal memperpanjang sewa.');
            }
        })
        .catch(err => {
            console.error('Error extending sewa:', err);
            alert('Terjadi kesalahan koneksi.');
        })
        .finally(() => {
            if (text && loader) {
                text.style.display = 'inline-block';
                loader.style.display = 'none';
            }
            btn.disabled = false;
        });
    }, 1500);
}
</script>

<?php $this->endSection() ?>
