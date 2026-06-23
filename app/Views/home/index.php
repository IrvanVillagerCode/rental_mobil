<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoVora - Premium Car Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0d0f18;
            --bg-surface: #13172a;
            --bg-card: #1a1f35;
            --bg-hover: #22294a;
            --accent: #6c63ff;
            --accent-light: #8b83ff;
            --accent-glow: rgba(108, 99, 255, 0.25);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border: rgba(255, 255, 255, 0.07);
            --border-accent: rgba(108, 99, 255, 0.4);
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
            --shadow-glow: 0 0 40px rgba(108, 99, 255, 0.15);
            --transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* ─── NAVBAR ─── */
        .navbar {
            background: rgba(13, 15, 24, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
            transition: all var(--transition);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-primary) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i {
            color: var(--accent);
            font-size: 1.8rem;
            filter: drop-shadow(0 0 8px var(--accent-glow));
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            transition: all var(--transition);
            margin-left: 1rem;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: var(--text-primary) !important;
            text-shadow: 0 0 8px rgba(255,255,255,0.3);
            transform: translateY(-1px);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            color: #fff !important;
            font-weight: 600;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 99px;
            transition: all var(--transition);
            box-shadow: 0 4px 14px var(--accent-glow);
            margin-left: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108,99,255,0.4);
            filter: brightness(1.1);
        }

        /* ─── HERO SECTION ─── */
        .hero-section {
            position: relative;
            padding: 120px 0 100px;
            text-align: center;
            overflow: hidden;
        }

        .hero-bg-orbs {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            animation: floatOrb 10s ease-in-out infinite;
        }
        
        .hero-orb-1 {
            width: 600px; height: 600px; background: rgba(108, 99, 255, 0.15); top: -200px; left: -100px;
        }
        
        .hero-orb-2 {
            width: 450px; height: 450px; background: rgba(139, 92, 246, 0.1); bottom: -100px; right: -50px; animation-delay: -5s;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0,0) scale(1); }
            50% { transform: translate(30px, 20px) scale(1.05); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 24px;
            line-height: 1.2;
            background: linear-gradient(135deg, #fff, var(--text-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ─── STATISTICS SECTION ─── */
        .stats-section {
            position: relative;
            z-index: 10;
            margin-top: -50px;
            padding-bottom: 40px;
        }

        .stat-card {
            background: rgba(26, 31, 53, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.05);
            text-align: center;
            padding: 30px 20px;
            border-radius: var(--radius);
            transition: all var(--transition);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--border-accent);
            box-shadow: 0 15px 40px rgba(108,99,255,0.15);
        }

        .stat-card i {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 15px;
            filter: drop-shadow(0 0 8px var(--accent-glow));
        }

        .stat-card h3 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        .stat-card p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 0.95rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ─── SEARCH SECTION ─── */
        .search-section {
            padding: 40px 0 20px;
            position: relative;
            z-index: 2;
        }

        .search-container {
            background: rgba(26, 31, 53, 0.5);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08);
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            margin-bottom: 40px;
        }

        .search-input-group {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .search-input-group input {
            flex: 1;
            padding: 16px 24px;
            background: rgba(13, 15, 24, 0.6);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-size: 1rem;
            transition: all var(--transition);
        }

        .search-input-group input::placeholder {
            color: var(--text-muted);
        }

        .search-input-group input:focus {
            border-color: var(--accent);
            background: rgba(13, 15, 24, 0.9);
            box-shadow: 0 0 0 4px var(--accent-glow);
            outline: none;
        }

        .btn-search {
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            color: white;
            border: none;
            padding: 16px 36px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all var(--transition);
            box-shadow: 0 4px 15px var(--accent-glow);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108,99,255,0.4);
        }

        /* ─── VEHICLES SECTION ─── */
        .vehicles-section {
            padding: 60px 0;
            position: relative;
            z-index: 2;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .section-title p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* ─── VEHICLE CARD ─── */
        .vehicle-card {
            background: rgba(26, 31, 53, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .vehicle-card:hover {
            transform: translateY(-10px);
            border-color: rgba(108,99,255,0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 20px rgba(108,99,255,0.1);
            background: rgba(30, 36, 62, 0.6);
        }

        .vehicle-image {
            position: relative;
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, rgba(13, 15, 24, 0.8), rgba(26, 31, 53, 0.8));
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid rgba(255,255,255,0.03);
        }

        .vehicle-image i {
            font-size: 5rem;
            color: var(--accent);
            opacity: 0.5;
            transition: all var(--transition);
        }

        .vehicle-card:hover .vehicle-image i {
            transform: scale(1.1);
            opacity: 0.8;
            filter: drop-shadow(0 0 15px var(--accent-glow));
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            border: 1px solid transparent;
        }

        .category-filters {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            background: rgba(26, 31, 53, 0.6);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-secondary);
            padding: 10px 24px;
            border-radius: 99px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(8px);
        }
        
        .filter-btn:hover {
            color: var(--text-primary);
            background: rgba(255,255,255,0.05);
            transform: translateY(-2px);
        }
        
        .filter-btn.active {
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px var(--accent-glow);
        }

        .vehicle-card {
            animation: fadeUpCard 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        
        @keyframes fadeUpCard {
            to { opacity: 1; transform: translateY(0); }
        }

        .vehicle-info {
            padding: 24px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .vehicle-brand {
            font-size: 0.85rem;
            color: var(--accent-light);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .vehicle-model {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .vehicle-specs {
            display: flex;
            gap: 12px;
            margin: 16px 0;
            flex-wrap: wrap;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            padding: 8px 14px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: var(--radius-sm);
        }

        .spec-item i {
            color: var(--accent);
            font-size: 0.95rem;
        }

        .vehicle-price {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-tag {
            display: flex;
            flex-direction: column;
        }

        .price-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .price-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-primary);
        }

        .price-value span {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .btn-booking {
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all var(--transition);
            white-space: nowrap;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-booking:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--accent-glow);
            color: white;
        }

        /* ─── NO VEHICLES ─── */
        .no-vehicles {
            text-align: center;
            padding: 80px 20px;
            background: rgba(26, 31, 53, 0.4);
            border-radius: 16px;
            border: 1px dashed rgba(255,255,255,0.1);
        }

        .no-vehicles i {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .no-vehicles h3 {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 12px;
        }

        .no-vehicles p {
            color: var(--text-secondary);
        }

        /* ─── FOOTER ─── */
        footer {
            background: rgba(13, 15, 24, 0.95);
            border-top: 1px solid rgba(255,255,255,0.05);
            padding: 60px 0 30px;
            margin-top: 80px;
            position: relative;
            z-index: 10;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h5 {
            font-weight: 800;
            margin-bottom: 24px;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-section h5 i {
            color: var(--accent);
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 12px;
        }

        .footer-section ul li a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: all var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .footer-section ul li a i {
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .footer-section ul li a:hover {
            color: var(--accent-light);
            padding-left: 6px;
        }

        .footer-divider {
            border-top: 1px solid rgba(255,255,255,0.05);
            margin: 30px 0;
        }

        .footer-bottom {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .hero-content h1 { font-size: 2.5rem; }
            .hero-content p { font-size: 1rem; }
            .search-input-group { flex-direction: column; }
            .btn-search { width: 100%; justify-content: center; }
            .section-title h2 { font-size: 2rem; }
            .navbar { padding: 0.5rem 0; }
        }

        @media (max-width: 576px) {
            .hero-section { padding: 80px 0 60px; }
            .hero-content h1 { font-size: 2rem; }
            .stat-card h3 { font-size: 1.8rem; }
            .stat-card i { font-size: 2rem; }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>" style="display:flex; align-items:center; gap:10px;">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="AutoVora Logo" class="logo" style="max-height: 50px; width: auto; object-fit: contain;">
                <span>AutoVora</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="border-color: rgba(255,255,255,0.1);">
                <i class="fas fa-bars" style="color: var(--text-primary);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#vehicles">Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Hubungi Kami</a>
                    </li>
                    <?php if (session()->get('logged_in')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('dashboard') ?>" style="color: var(--accent-light) !important;">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item mt-2 mt-lg-0">
                            <a href="<?= base_url('login') ?>" class="btn btn-login">
                                <i class="fas fa-user-circle me-1"></i> Login Pelanggan
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="hero-bg-orbs">
            <div class="hero-orb hero-orb-1"></div>
            <div class="hero-orb hero-orb-2"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1>Sewa Kendaraan Masa Depan,<br>Mulai Hari Ini.</h1>
                <p>Platform rental mobil terpercaya dengan armada berkualitas premium, harga transparan, dan pelayanan tanpa batas.</p>
            </div>
        </div>
    </section>

    <!-- STATISTICS SECTION -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6">
                    <div class="stat-card">
                        <i class="fas fa-layer-group"></i>
                        <h3 id="stat-total"><?= isset($statistik['total']) ? $statistik['total'] : 0 ?></h3>
                        <p>Total Armada</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="stat-card">
                        <i class="fas fa-check-shield"></i>
                        <h3 id="stat-tersedia" style="color: var(--success);"><?= isset($statistik['tersedia']) ? $statistik['tersedia'] : 0 ?></h3>
                        <p>Siap Disewa</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="stat-card">
                        <i class="fas fa-route"></i>
                        <h3 id="stat-disewa" style="color: var(--accent-light);"><?= isset($statistik['disewa']) ? $statistik['disewa'] : 0 ?></h3>
                        <p>Sedang Jalan</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="stat-card">
                        <i class="fas fa-wrench"></i>
                        <h3 id="stat-perawatan" style="color: var(--warning);"><?= isset($statistik['perawatan']) ? $statistik['perawatan'] : 0 ?></h3>
                        <p>Perawatan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEARCH SECTION -->
    <section class="search-section">
        <div class="container">
            <div class="search-container">
                <div class="search-input-group">
                    <input type="text" id="searchInput" placeholder="Ketik merek atau model mobil impian Anda...">
                    <button class="btn-search" onclick="searchMobil()">
                        <i class="fas fa-search"></i> Temukan
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- VEHICLES SECTION -->
    <section class="vehicles-section" id="vehicles">
        <div class="container">
            <div class="section-title">
                <h2>Katalog Eksklusif</h2>
                <p>Pilih dari koleksi armada premium kami yang selalu terawat dan siap menemani perjalanan Anda.</p>
                <div style="margin-top: 20px;">
                    <button onclick="history.back()" class="btn-back" style="background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid rgba(255,255,255,0.1); padding: 8px 20px; border-radius: 99px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Sebelumnya
                    </button>
                </div>
            </div>

            <div class="category-filters" id="categoryFilters">
                <button class="filter-btn active" data-filter="all">Semua Armada</button>
                <button class="filter-btn" data-filter="honda">Honda</button>
                <button class="filter-btn" data-filter="toyota">Toyota</button>
                <button class="filter-btn" data-filter="wuling">Wuling</button>
                <button class="filter-btn" data-filter="mitsubishi">Mitsubishi</button>
            </div>

            <div id="vehiclesContainer" class="row g-4">
                <?php if (empty($mobil_list)): ?>
                    <div class="col-12">
                        <div class="no-vehicles">
                            <i class="fas fa-car-slash"></i>
                            <h3>Armada Belum Tersedia</h3>
                            <p>Maaf, saat ini seluruh kendaraan sedang kosong.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($mobil_list as $idx => $mobil): ?>
                        <?php
                        $statusVal = $mobil['status_mobil'];
                        $badgeStyle = '';
                        $badgeText = '';
                        $btnExtra = '';
                        $btnClass = 'btn-booking';
                        $btnIcon = 'fa-arrow-right';
                        $btnText = 'Booking';

                        if ($statusVal === 'tersedia') {
                            $badgeStyle = 'background: rgba(16,185,129,0.1); color: var(--success); border-color: rgba(16,185,129,0.3);';
                            $badgeText = '<i class="fas fa-check-circle"></i> Tersedia';
                            $btnText = 'Booking';
                            $btnIcon = 'fa-arrow-right';
                        } elseif ($statusVal === 'disewa') {
                            $badgeStyle = 'background: rgba(108,99,255,0.1); color: var(--accent-light); border-color: rgba(108,99,255,0.3);';
                            $badgeText = '<i class="fas fa-route"></i> Sedang Disewa';
                            $btnExtra = 'disabled style="opacity: 0.5; cursor: not-allowed; background: var(--bg-hover); box-shadow: none;"';
                            $btnText = 'Sedang Jalan';
                            $btnIcon = 'fa-ban';
                        } elseif ($statusVal === 'perawatan') {
                            $badgeStyle = 'background: rgba(245,158,11,0.1); color: var(--warning); border-color: rgba(245,158,11,0.3);';
                            $badgeText = '<i class="fas fa-wrench"></i> Perbaikan';
                            $btnExtra = 'disabled style="opacity: 0.5; cursor: not-allowed; background: var(--bg-hover); box-shadow: none;"';
                            $btnText = 'Perbaikan';
                            $btnIcon = 'fa-wrench';
                        }
                        ?>
                        <div class="col-lg-4 col-md-6 vehicle-item" data-category="<?= strtolower($mobil['merek']) ?>" style="animation-delay: <?= $idx * 0.1 ?>s">
                            <div class="vehicle-card">
                                <div class="vehicle-image">
                                    <img src="<?= $mobil['image_url'] ?>" alt="Mobil" style="width:100%; height:100%; object-fit:cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                                <div class="vehicle-info">
                                    <div class="status-pill" style="<?= $badgeStyle ?>"><?= $badgeText ?></div>
                                    <div class="vehicle-brand"><?= htmlspecialchars($mobil['merek']) ?></div>
                                    <div class="vehicle-model"><?= htmlspecialchars($mobil['model']) ?></div>

                                    <div class="vehicle-specs">
                                        <div class="spec-item">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span><?= $mobil['tahun_perolehan'] ?></span>
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-hashtag"></i>
                                            <span><?= htmlspecialchars($mobil['nopol_mobil']) ?></span>
                                        </div>
                                    </div>

                                    <div class="vehicle-price">
                                        <div class="price-tag">
                                            <span class="price-label">Tarif Sewa</span>
                                            <div class="price-value">Rp<?= number_format($mobil['harga_sewa_perhari'], 0, ',', '.') ?><span>/hari</span></div>
                                        </div>
                                        <?php if ($statusVal !== 'tersedia'): ?>
                                            <button class="<?= $btnClass ?>" <?= $btnExtra ?>>
                                                <i class="fas <?= $btnIcon ?>"></i> <?= $btnText ?>
                                            </button>
                                        <?php elseif (session()->get('logged_in')): ?>
                                            <button class="btn-booking" onclick="bookingMobil(<?= $mobil['id_mobil'] ?>)">
                                                <i class="fas fa-arrow-right"></i> Booking
                                            </button>
                                        <?php else: ?>
                                            <a href="<?= base_url('login') ?>" class="btn-booking">
                                                <i class="fas fa-lock"></i> Login
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="about">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5 style="display:flex; align-items:center; gap:10px;">
                        <img src="<?= base_url('assets/images/logo.png') ?>" alt="AutoVora Logo" class="logo" style="max-height: 30px;">
                        AutoVora
                    </h5>
                    <p style="color: var(--text-secondary); line-height: 1.6;">AutoVora menghadirkan revolusi pengalaman penyewaan mobil dengan armada modern, harga transparan, dan ekosistem digital yang efisien untuk setiap perjalanan Anda.</p>
                </div>
                <div class="footer-section">
                    <h5>Navigasi</h5>
                    <ul>
                        <li><a href="#vehicles"><i class="fas fa-chevron-right"></i> Katalog Mobil</a></li>
                        <li><a href="#about"><i class="fas fa-chevron-right"></i> Tentang Kami</a></li>
                        <li><a href="<?= base_url('login') ?>"><i class="fas fa-chevron-right"></i> Portal Pelanggan</a></li>
                    </ul>
                </div>
                <div class="footer-section" id="contact">
                    <h5>Kontak Info</h5>
                    <ul>
                        <li><a href="#"><i class="fas fa-headset"></i> +62 812-3456-7890</a></li>
                        <li><a href="#"><i class="fas fa-envelope-open-text"></i> hello@autovora.id</a></li>
                        <li><a href="#"><i class="fas fa-map-marked-alt"></i> Tech District, Jakarta</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5>Sosial Media</h5>
                    <div style="display: flex; gap: 12px; margin-top: 10px;">
                        <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-primary); transition: all 0.3s;" onmouseover="this.style.background='var(--accent)';" onmouseout="this.style.background='rgba(255,255,255,0.05)';"><i class="fab fa-instagram"></i></a>
                        <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-primary); transition: all 0.3s;" onmouseover="this.style.background='var(--info)';" onmouseout="this.style.background='rgba(255,255,255,0.05)';"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-primary); transition: all 0.3s;" onmouseover="this.style.background='#1877f2';" onmouseout="this.style.background='rgba(255,255,255,0.05)';"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-divider"></div>

            <div class="footer-bottom">
                <p>&copy; 2026 AutoVora by Kelompok 2 Teknik Informatika. Dibuat dengan presisi tinggi.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animations and Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(13, 15, 24, 0.95)';
                navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.5)';
            } else {
                navbar.style.background = 'rgba(13, 15, 24, 0.7)';
                navbar.style.boxShadow = 'none';
            }
        });

        // Category Filter Logic
        document.addEventListener('DOMContentLoaded', () => {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const vehicles = document.querySelectorAll('.vehicle-item');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class from all
                    filterBtns.forEach(b => b.classList.remove('active'));
                    // Add active to clicked
                    btn.classList.add('active');

                    const filterValue = btn.getAttribute('data-filter');

                    vehicles.forEach((item, index) => {
                        // Reset animation
                        item.style.animation = 'none';
                        item.offsetHeight; // trigger reflow

                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'block';
                            // Re-apply animation with slight delay stagger
                            item.style.animation = `fadeUpCard 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards`;
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });

        // Booking action
        function bookingMobil(id) {
            window.location.href = `<?= base_url('penyewaan/create?mobil=') ?>${id}`;
        }

        function searchMobil() {
            const searchValue = document.getElementById('searchInput').value.trim();

            if (searchValue === '') {
                location.reload();
                return;
            }

            // Reset category filters when searching
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            document.querySelector('.filter-btn[data-filter="all"]').classList.add('active');

            fetch(`<?= base_url('home/get-mobil-ajax') ?>?search=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    displayMobil(data.data);
                    document.getElementById('vehicles').scrollIntoView({behavior: 'smooth'});
                })
                .catch(error => console.error('Error:', error));
        }

        function displayMobil(mobil) {
            const container = document.getElementById('vehiclesContainer');

            if (mobil.length === 0) {
                container.innerHTML = `
                    <div class="col-12">
                        <div class="no-vehicles">
                            <i class="fas fa-search-minus"></i>
                            <h3>Pencarian Tidak Ditemukan</h3>
                            <p>Armada dengan merek atau model "${document.getElementById('searchInput').value}" tidak ditemukan.</p>
                        </div>
                    </div>
                `;
                return;
            }

            let html = '';
            mobil.forEach((m, idx) => {
                const isLoggedIn = <?= session()->get('logged_in') ? 'true' : 'false' ?>;
                
                let badgeStyle = '';
                let badgeText = '';
                let btnHtml = '';

                if (m.status_mobil === 'tersedia') {
                    badgeStyle = 'background: rgba(16,185,129,0.1); color: var(--success); border-color: rgba(16,185,129,0.3);';
                    badgeText = '<i class="fas fa-check-circle"></i> Tersedia';
                    
                    btnHtml = isLoggedIn ?
                        `<button class="btn-booking" onclick="bookingMobil(${m.id_mobil})"><i class="fas fa-arrow-right"></i> Booking</button>` :
                        `<a href="<?= base_url('login') ?>" class="btn-booking"><i class="fas fa-lock"></i> Login</a>`;
                } else if (m.status_mobil === 'disewa') {
                    badgeStyle = 'background: rgba(108,99,255,0.1); color: var(--accent-light); border-color: rgba(108,99,255,0.3);';
                    badgeText = '<i class="fas fa-route"></i> Sedang Disewa';
                    btnHtml = `<button class="btn-booking" disabled style="opacity: 0.5; cursor: not-allowed; background: var(--bg-hover); box-shadow: none;"><i class="fas fa-ban"></i> Sedang Jalan</button>`;
                } else if (m.status_mobil === 'perawatan') {
                    badgeStyle = 'background: rgba(245,158,11,0.1); color: var(--warning); border-color: rgba(245,158,11,0.3);';
                    badgeText = '<i class="fas fa-wrench"></i> Perbaikan';
                    btnHtml = `<button class="btn-booking" disabled style="opacity: 0.5; cursor: not-allowed; background: var(--bg-hover); box-shadow: none;"><i class="fas fa-wrench"></i> Perbaikan</button>`;
                }

                html += `
                    <div class="col-lg-4 col-md-6 vehicle-item" data-category="${m.merek.toLowerCase()}" style="animation-delay: ${idx * 0.1}s">
                        <div class="vehicle-card">
                            <div class="vehicle-image">
                                <img src="${m.image_url}" alt="Mobil" style="width:100%; height:100%; object-fit:cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            </div>
                            <div class="vehicle-info">
                                <div class="status-pill" style="${badgeStyle}">${badgeText}</div>
                                <div class="vehicle-brand">${m.merek}</div>
                                <div class="vehicle-model">${m.model}</div>

                                <div class="vehicle-specs">
                                    <div class="spec-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>${m.tahun_perolehan}</span>
                                    </div>
                                    <div class="spec-item">
                                        <i class="fas fa-hashtag"></i>
                                        <span>${m.nopol_mobil}</span>
                                    </div>
                                </div>

                                <div class="vehicle-price">
                                    <div class="price-tag">
                                        <span class="price-label">Tarif Sewa</span>
                                        <div class="price-value">Rp${parseInt(m.harga_sewa_perhari).toLocaleString('id-ID')}<span>/hari</span></div>
                                    </div>
                                    ${btnHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        // Booking function
        function bookingMobil(idMobil) {
            window.location.href = `<?= base_url('penyewaan/create?mobil=') ?>${idMobil}`;
        }

        // Search on Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchMobil();
            }
        });

        // Real-time statistics updater
        function updateStatistics() {
            fetch('<?= base_url("home/get-statistik-ajax") ?>')
                .then(response => response.json())
                .then(data => {
                    const totalEl = document.getElementById('stat-total');
                    const tersediaEl = document.getElementById('stat-tersedia');
                    const disewaEl = document.getElementById('stat-disewa');
                    const perawatanEl = document.getElementById('stat-perawatan');

                    if (totalEl) totalEl.textContent = data.total ?? 0;
                    if (tersediaEl) tersediaEl.textContent = data.tersedia ?? 0;
                    if (disewaEl) disewaEl.textContent = data.disewa ?? 0;
                    if (perawatanEl) perawatanEl.textContent = data.perawatan ?? 0;
                })
                .catch(err => console.error('Error fetching statistics:', err));
        }

        // Run on load and then every 5 seconds
        updateStatistics();
        setInterval(updateStatistics, 5000);
    </script>
</body>

</html>