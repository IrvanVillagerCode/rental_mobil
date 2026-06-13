<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Mobil - Sewa Kendaraan Berkualitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #dc2626;
            --accent-color: #0891b2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* ─── NAVBAR ─── */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i {
            font-size: 1.8rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-left: 1rem;
        }

        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }

        .btn-login {
            background-color: #fff;
            color: var(--primary-color);
            font-weight: 600;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #f0f0f0;
            transform: scale(1.05);
        }

        /* ─── HERO SECTION ─── */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 80px 0 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M0,50 Q300,0 600,50 T1200,50 L1200,120 L0,120 Z" fill="rgba(255,255,255,0.05)"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        /* ─── STATISTICS SECTION ─── */
        .stats-section {
            background: white;
            padding: 40px 0;
            margin-top: -30px;
            position: relative;
            z-index: 10;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        }

        .stat-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .stat-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-card p {
            color: #666;
            margin: 0;
            font-size: 0.95rem;
        }

        /* ─── SEARCH SECTION ─── */
        .search-section {
            padding: 40px 0;
            background: #fff;
        }

        .search-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .search-input-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-input-group input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input-group input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            outline: none;
        }

        .btn-search {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        }

        /* ─── VEHICLES SECTION ─── */
        .vehicles-section {
            padding: 40px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
        }

        /* ─── VEHICLE CARD ─── */
        .vehicle-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .vehicle-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .vehicle-image {
            position: relative;
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-size: 3rem;
            color: #bbb;
        }

        .vehicle-image i {
            font-size: 4rem;
        }

        .vehicle-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--secondary-color);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .vehicle-info {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .vehicle-brand {
            font-size: 0.85rem;
            color: var(--accent-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .vehicle-model {
            font-size: 1.3rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 10px;
        }

        .vehicle-specs {
            display: flex;
            gap: 15px;
            margin: 15px 0;
            flex-wrap: wrap;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #666;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .spec-item i {
            color: var(--primary-color);
            font-size: 1rem;
        }

        .vehicle-price {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-tag {
            display: flex;
            flex-direction: column;
        }

        .price-label {
            font-size: 0.8rem;
            color: #999;
            text-transform: uppercase;
        }

        .price-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--secondary-color);
        }

        .btn-booking {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-booking:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
        }

        /* ─── NO VEHICLES ─── */
        .no-vehicles {
            text-align: center;
            padding: 60px 20px;
        }

        .no-vehicles i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .no-vehicles h3 {
            color: #666;
            margin-bottom: 10px;
        }

        .no-vehicles p {
            color: #999;
        }

        /* ─── FOOTER ─── */
        footer {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-section h5 {
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--accent-color);
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: white;
            padding-left: 5px;
        }

        .footer-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 20px 0;
        }

        .footer-bottom {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .search-input-group {
                flex-direction: column;
            }

            .btn-search {
                width: 100%;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .vehicle-card {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .hero-section {
                padding: 50px 0 40px;
            }

            .hero-content h1 {
                font-size: 1.5rem;
            }

            .section-title h2 {
                font-size: 1.5rem;
            }

            .stat-card i {
                font-size: 2rem;
            }

            .stat-card h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <i class="fas fa-car"></i>
                <span>RentalMobil</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#vehicles">Kendaraan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Hubungi Kami</a>
                    </li>
                    <?php if (session()->get('logged_in')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="<?= base_url('login') ?>" class="btn btn-login ms-2">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Sewa Mobil Impian Anda Sekarang</h1>
                <p>Layanan rental mobil terpercaya dengan armada lengkap dan harga terjangkau</p>
            </div>
        </div>
    </section>

    <!-- STATISTICS SECTION -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <i class="fas fa-car"></i>
                        <h3><?= isset($statistik['total']) ? $statistik['total'] : 0 ?></h3>
                        <p>Total Kendaraan</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <i class="fas fa-check-circle"></i>
                        <h3><?= isset($statistik['tersedia']) ? $statistik['tersedia'] : 0 ?></h3>
                        <p>Tersedia</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <i class="fas fa-calendar-check"></i>
                        <h3><?= isset($statistik['disewa']) ? $statistik['disewa'] : 0 ?></h3>
                        <p>Sedang Disewa</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <i class="fas fa-tools"></i>
                        <h3><?= isset($statistik['perawatan']) ? $statistik['perawatan'] : 0 ?></h3>
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
                    <input type="text" id="searchInput" placeholder="Cari mobil berdasarkan merek atau model..." class="form-control">
                    <button class="btn-search" onclick="searchMobil()">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- VEHICLES SECTION -->
    <section class="vehicles-section" id="vehicles">
        <div class="container">
            <div class="section-title">
                <h2>Daftar Kendaraan Tersedia</h2>
                <p>Pilih kendaraan impian Anda untuk pengalaman rental terbaik</p>
            </div>

            <div id="vehiclesContainer" class="row">
                <?php if (empty($mobil_tersedia)): ?>
                    <div class="col-12">
                        <div class="no-vehicles">
                            <i class="fas fa-inbox"></i>
                            <h3>Tidak Ada Kendaraan Tersedia</h3>
                            <p>Maaf, saat ini tidak ada kendaraan yang tersedia untuk disewa.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($mobil_tersedia as $mobil): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="vehicle-card">
                                <div class="vehicle-image">
                                    <i class="fas fa-car"></i>
                                    <span class="vehicle-badge">Tersedia</span>
                                </div>
                                <div class="vehicle-info">
                                    <div class="vehicle-brand"><?= htmlspecialchars($mobil['merek']) ?></div>
                                    <div class="vehicle-model"><?= htmlspecialchars($mobil['model']) ?></div>

                                    <div class="vehicle-specs">
                                        <div class="spec-item">
                                            <i class="fas fa-calendar"></i>
                                            <span><?= $mobil['tahun_perolehan'] ?></span>
                                        </div>
                                        <div class="spec-item">
                                            <i class="fas fa-id-card"></i>
                                            <span><?= htmlspecialchars($mobil['nopol_mobil']) ?></span>
                                        </div>
                                    </div>

                                    <div class="vehicle-price">
                                        <div class="price-tag">
                                            <span class="price-label">Per Hari</span>
                                            <span class="price-value">Rp<?= number_format($mobil['harga_sewa_perhari'], 0, ',', '.') ?></span>
                                        </div>
                                        <?php if (session()->get('logged_in')): ?>
                                            <button class="btn-booking" onclick="bookingMobil(<?= $mobil['id_mobil'] ?>)">
                                                <i class="fas fa-shopping-cart"></i> Booking
                                            </button>
                                        <?php else: ?>
                                            <a href="<?= base_url('login') ?>" class="btn-booking" style="text-decoration: none;">
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
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5><i class="fas fa-car"></i> Tentang Kami</h5>
                    <p>Kami menyediakan layanan rental mobil terpercaya dengan berbagai pilihan kendaraan berkualitas untuk memenuhi kebutuhan perjalanan Anda.</p>
                </div>
                <div class="footer-section">
                    <h5>Layanan</h5>
                    <ul>
                        <li><a href="#vehicles">Sewa Mobil</a></li>
                        <li><a href="#vehicles">Paket Liburan</a></li>
                        <li><a href="#contact">Bantuan Pelanggan</a></li>
                        <li><a href="#about">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5>Kontak Kami</h5>
                    <ul>
                        <li><a href="tel:+62812345678"><i class="fas fa-phone"></i> +62 812 345 678</a></li>
                        <li><a href="mailto:info@rentalmobil.com"><i class="fas fa-envelope"></i> info@rentalmobil.com</a></li>
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5>Ikuti Kami</h5>
                    <ul>
                        <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="#"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-divider"></div>

            <div class="footer-bottom">
                <p>&copy; 2026 RentalMobil. Hak Cipta Dilindungi. Semua Hak Terpelihara.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        function searchMobil() {
            const searchValue = document.getElementById('searchInput').value.trim();

            if (searchValue === '') {
                location.reload();
                return;
            }

            fetch(`<?= base_url('home/get-mobil-ajax') ?>?search=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    displayMobil(data.data);
                })
                .catch(error => console.error('Error:', error));
        }

        function displayMobil(mobil) {
            const container = document.getElementById('vehiclesContainer');

            if (mobil.length === 0) {
                container.innerHTML = `
                    <div class="col-12">
                        <div class="no-vehicles">
                            <i class="fas fa-search"></i>
                            <h3>Tidak Ada Hasil</h3>
                            <p>Maaf, tidak ada kendaraan yang sesuai dengan pencarian Anda.</p>
                        </div>
                    </div>
                `;
                return;
            }

            let html = '';
            mobil.forEach(m => {
                const isLoggedIn = <?= session()->get('logged_in') ? 'true' : 'false' ?>;
                const bookingBtn = isLoggedIn ?
                    `<button class="btn-booking" onclick="bookingMobil(${m.id_mobil})"><i class="fas fa-shopping-cart"></i> Booking</button>` :
                    `<a href="<?= base_url('login') ?>" class="btn-booking" style="text-decoration: none;"><i class="fas fa-lock"></i> Login</a>`;

                html += `
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="vehicle-card">
                            <div class="vehicle-image">
                                <i class="fas fa-car"></i>
                                <span class="vehicle-badge">Tersedia</span>
                            </div>
                            <div class="vehicle-info">
                                <div class="vehicle-brand">${m.merek}</div>
                                <div class="vehicle-model">${m.model}</div>

                                <div class="vehicle-specs">
                                    <div class="spec-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>${m.tahun_perolehan}</span>
                                    </div>
                                    <div class="spec-item">
                                        <i class="fas fa-id-card"></i>
                                        <span>${m.nopol_mobil}</span>
                                    </div>
                                </div>

                                <div class="vehicle-price">
                                    <div class="price-tag">
                                        <span class="price-label">Per Hari</span>
                                        <span class="price-value">Rp${new Intl.NumberFormat('id-ID').format(m.harga_sewa_perhari)}</span>
                                    </div>
                                    ${bookingBtn}
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
    </script>
</body>

</html>