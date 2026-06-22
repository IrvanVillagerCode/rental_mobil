<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<?php $title = $pageTitle = 'Manajemen Armada'; ?>

<div class="page-header">
    <h2><i class="bi bi-car-front"></i> Manajemen Armada</h2>
    <a href="<?= base_url('mobil/create') ?>" class="btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Armada
    </a>
</div>

<div class="card">
    <div class="filter-bar" style="display:flex; flex-direction:column; gap:20px; align-items:center;">
        <input type="text" id="tableSearch" class="search-input" placeholder="🔍 Cari merek, model, atau nopol..." style="width:100%; max-width:500px;">
        <div class="category-filters" id="categoryFilters">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="honda">Honda</button>
            <button class="filter-btn" data-filter="toyota">Toyota</button>
            <button class="filter-btn" data-filter="wuling">Wuling</button>
            <button class="filter-btn" data-filter="mitsubishi">Mitsubishi</button>
        </div>
    </div>

    <?php if (empty($mobil_list)): ?>
    <div class="empty-state"><i class="bi bi-car-front"></i><p>Belum ada data armada. Tambahkan sekarang!</p></div>
    <?php else: ?>
    <style>
    .vehicles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        margin-top: 24px;
    }
    .vehicle-card {
        background: rgba(26, 31, 53, 0.4);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        flex-direction: column;
        animation: fadeUpCard 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(30px);
    }
    @keyframes fadeUpCard {
        to { opacity: 1; transform: translateY(0); }
    }
    .vehicle-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        border-color: rgba(108,99,255,0.3);
    }
    
    .category-filters {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .filter-btn {
        background: rgba(26, 31, 53, 0.6);
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--text-secondary);
        padding: 8px 20px;
        border-radius: 99px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .filter-btn:hover {
        color: var(--text-primary);
        background: rgba(255,255,255,0.05);
    }
    .filter-btn.active {
        background: linear-gradient(135deg, var(--accent), #8b5cf6);
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 15px var(--accent-glow);
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
        width: fit-content;
    }
    .vehicle-image-wrapper {
        height: 180px;
        width: 100%;
        overflow: hidden;
        position: relative;
        background: #1a1f35;
    }
    .vehicle-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .vehicle-card:hover .vehicle-image-wrapper img {
        transform: scale(1.1);
    }
    .vehicle-details {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .vehicle-brand {
        font-size: 0.8rem;
        color: var(--accent-light);
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .vehicle-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 12px;
        line-height: 1.3;
    }
    .vehicle-specs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 16px;
    }
    .spec-item {
        font-size: 0.85rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .spec-item i {
        color: var(--accent);
    }
    .vehicle-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid rgba(255,255,255,0.05);
        display: flex;
        flex-direction: column;
    }
    .vehicle-price span {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 500;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .vehicle-actions {
        display: flex;
        gap: 8px;
        margin-top: 16px;
    }
    .vehicle-actions .btn-sm {
        flex: 1;
        justify-content: center;
    }
    </style>

    <div class="vehicles-grid">
        <?php foreach ($mobil_list as $idx => $m): ?>
        <?php
            $statusVal = $m['status_mobil'];
            $badgeStyle = '';
            $badgeText = '';

            if ($statusVal === 'tersedia') {
                $badgeStyle = 'background: rgba(16,185,129,0.1); color: var(--success); border-color: rgba(16,185,129,0.3);';
                $badgeText = '<i class="bi bi-check-circle-fill"></i> Tersedia';
            } elseif ($statusVal === 'disewa') {
                $badgeStyle = 'background: rgba(108,99,255,0.1); color: var(--accent-light); border-color: rgba(108,99,255,0.3);';
                $badgeText = '<i class="bi bi-sign-turn-right-fill"></i> Disewa';
            } elseif ($statusVal === 'perawatan') {
                $badgeStyle = 'background: rgba(245,158,11,0.1); color: var(--warning); border-color: rgba(245,158,11,0.3);';
                $badgeText = '<i class="bi bi-tools"></i> Perbaikan';
            }
        ?>
        <div class="vehicle-card" data-category="<?= strtolower($m['merek']) ?>" data-search="<?= strtolower($m['merek'] . ' ' . $m['model'] . ' ' . $m['nopol_mobil']) ?>" style="animation-delay: <?= $idx * 0.1 ?>s">
            <div class="vehicle-image-wrapper">
                <img src="<?= $m['image_url'] ?? base_url('assets/images/mobil-default.png') ?>" alt="<?= esc($m['merek'] . ' ' . $m['model']) ?>">
            </div>
            
            <div class="vehicle-details">
                <div class="status-pill" style="<?= $badgeStyle ?>"><?= $badgeText ?></div>
                <div class="vehicle-brand"><?= esc($m['merek']) ?></div>
                <div class="vehicle-name"><?= esc($m['model']) ?></div>
                
                <div class="vehicle-specs">
                    <div class="spec-item" title="Tahun">
                        <i class="bi bi-calendar3"></i> <?= $m['tahun_perolehan'] ?>
                    </div>
                    <div class="spec-item" title="Nomor Polisi">
                        <i class="bi bi-123"></i> <?= esc($m['nopol_mobil']) ?>
                    </div>
                </div>
                
                <div class="vehicle-price">
                    <span>Harga Sewa</span>
                    <div>Rp <?= number_format($m['harga_sewa_perhari'], 0, ',', '.') ?> <small style="color:var(--text-muted);font-weight:500;font-size:0.8rem">/hari</small></div>
                </div>
                
                <div class="vehicle-actions">
                    <a href="<?= base_url('mobil/edit/' . $m['id_mobil']) ?>" class="btn-info-sm btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="<?= base_url('mobil/delete/' . $m['id_mobil']) ?>" class="btn-danger-sm btn-sm" onclick="return confirm('Hapus armada <?= esc($m['merek'] . ' ' . $m['model']) ?>?')">
                        <i class="bi bi-trash3"></i> Hapus
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('tableSearch');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.vehicle-card');

        function filterCards() {
            const q = searchInput ? searchInput.value.toLowerCase() : '';
            const activeFilterBtn = document.querySelector('.filter-btn.active');
            const activeCategory = activeFilterBtn ? activeFilterBtn.getAttribute('data-filter') : 'all';

            cards.forEach(card => {
                const text = card.getAttribute('data-search').toLowerCase();
                const category = card.getAttribute('data-category');
                
                const matchesSearch = text.includes(q);
                const matchesCategory = (activeCategory === 'all' || category === activeCategory);

                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                    // Reset animation
                    card.style.animation = 'none';
                    card.offsetHeight; /* trigger reflow */
                    card.style.animation = 'fadeUpCard 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterCards);
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterCards();
            });
        });
    });
    </script>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
