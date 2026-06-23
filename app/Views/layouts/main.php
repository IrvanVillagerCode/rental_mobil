<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'AutoVora – Premium Car Marketplace' ?></title>
    <meta name="description" content="AutoVora – Premium Car Rental & Marketplace">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Flatpickr Premium Calendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=') . time() ?>">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="<?= base_url('/') ?>" class="sidebar-brand" style="gap: 15px;">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="AutoVora Logo" class="logo" style="max-height: 50px; width: auto; object-fit: contain;">
            <div style="display:flex; flex-direction:column; justify-content:center;">
                <div class="brand-name" style="line-height:1.2;">AutoVora</div>
                <div class="brand-sub" style="line-height:1.2;">Premium Marketplace</div>
            </div>
        </a>

        <nav class="sidebar-nav">
            <div class="nav-label">MENU UTAMA</div>
            <a href="<?= base_url('dashboard') ?>" class="nav-item <?= (uri_string() === 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <?php if (session()->get('role') === 'admin'): ?>
            <div class="nav-label">MANAJEMEN</div>
            <a href="<?= base_url('mobil') ?>" class="nav-item <?= str_starts_with(uri_string(), 'mobil') ? 'active' : '' ?>">
                <i class="bi bi-car-front"></i>
                <span>Armada Mobil</span>
            </a>
            <a href="<?= base_url('penyewaan') ?>" class="nav-item <?= str_starts_with(uri_string(), 'penyewaan') ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text"></i>
                <span>Penyewaan</span>
            </a>
            <a href="<?= base_url('transaksi/monitoring') ?>" class="nav-item <?= str_starts_with(uri_string(), 'transaksi/monitoring') ? 'active' : '' ?>">
                <i class="bi bi-wallet2"></i>
                <span>Monitoring Payment</span>
            </a>
            <a href="<?= base_url('biaya') ?>" class="nav-item <?= str_starts_with(uri_string(), 'biaya') ? 'active' : '' ?>">
                <i class="bi bi-cash-stack"></i>
                <span>Biaya Operasional</span>
            </a>

            <div class="nav-label">LAPORAN</div>
            <a href="<?= base_url('cetak/harian?tanggal=' . date('Y-m-d')) ?>" class="nav-item" target="_blank">
                <i class="bi bi-calendar-day"></i>
                <span>Laporan Harian</span>
            </a>
            <a href="#modalBulanan" data-bs-toggle="modal" class="nav-item">
                <i class="bi bi-calendar-month"></i>
                <span>Laporan Bulanan</span>
            </a>
            <a href="#modalTahunan" data-bs-toggle="modal" class="nav-item">
                <i class="bi bi-graph-up-arrow"></i>
                <span>Laporan Tahunan</span>
            </a>
            <?php else: ?>
            <div class="nav-label">TRANSAKSI</div>
            <a href="<?= base_url('transaksi/riwayat') ?>" class="nav-item <?= str_starts_with(uri_string(), 'transaksi/riwayat') ? 'active' : '' ?>">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Pembayaran</span>
            </a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-user">
            <div class="user-avatar"><?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?></div>
            <div class="user-info">
                <div class="user-name"><?= esc(session()->get('nama') ?? 'User') ?></div>
                <div class="user-role badge-role-<?= session()->get('role') ?>"><?= strtoupper(session()->get('role') ?? '') ?></div>
            </div>
            <a href="<?= base_url('logout') ?>" class="logout-btn" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <header class="topbar">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="topbar-title"><?= $pageTitle ?? 'Dashboard' ?></div>
            <div class="topbar-right">
                <span class="topbar-date"><?= date('d F Y') ?></span>
            </div>
        </header>

        <div class="content-body">
            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert-toast success">
                <i class="bi bi-check-circle-fill"></i>
                <?= session()->getFlashdata('success') ?>
                <button onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
            </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-toast error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= session()->getFlashdata('error') ?>
                <button onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
            </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Modal Laporan Bulanan -->
    <div class="modal-overlay" id="modalBulanan">
        <div class="modal-box">
            <h3><i class="bi bi-calendar-month"></i> Laporan Bulanan</h3>
            <form action="<?= base_url('cetak/bulanan') ?>" method="GET" target="_blank">
                <div class="form-group">
                    <label>Bulan</label>
                    <select name="bulan" class="form-control">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= (date('m') == $i) ? 'selected' : '' ?>><?= date('F', mktime(0,0,0,$i,1)) ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="<?= date('Y') ?>">
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn-primary"><i class="bi bi-file-pdf"></i> Cetak PDF</button>
                    <button type="button" class="btn-secondary" onclick="document.getElementById('modalBulanan').style.display='none'">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Laporan Tahunan -->
    <div class="modal-overlay" id="modalTahunan">
        <div class="modal-box">
            <h3><i class="bi bi-graph-up-arrow"></i> Laporan Tahunan</h3>
            <form action="<?= base_url('cetak/tahunan') ?>" method="GET" target="_blank">
                <div class="form-group">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="<?= date('Y') ?>">
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn-primary"><i class="bi bi-file-pdf"></i> Cetak PDF</button>
                    <button type="button" class="btn-secondary" onclick="document.getElementById('modalTahunan').style.display='none'">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Flatpickr Premium Calendar globally for all type="date"
            flatpickr('input[type="date"]', {
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d",
                locale: "id", // Indonesian
                theme: "dark",
                disableMobile: "true"
            });
        });
    </script>
</body>
</html>
