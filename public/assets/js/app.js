// =============================
// RentaCar – App JS (Vanilla ES6)
// =============================

document.addEventListener('DOMContentLoaded', () => {
    // Sidebar toggle
    const toggle    = document.getElementById('sidebarToggle');
    const sidebar   = document.getElementById('sidebar');
    const mainCont  = document.getElementById('mainContent');

    if (toggle && sidebar) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        // Close sidebar on outside click (mobile)
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    }

    // Auto-close alert toasts after 4 seconds
    const toasts = document.querySelectorAll('.alert-toast');
    toasts.forEach(t => {
        setTimeout(() => {
            t.style.opacity = '0';
            t.style.transform = 'translateY(-8px)';
            t.style.transition = 'all 0.3s ease';
            setTimeout(() => t.remove(), 300);
        }, 4000);
    });

    // Modal open via data-modal attribute
    document.querySelectorAll('[data-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modalId = btn.getAttribute('data-modal');
            const modal   = document.getElementById(modalId);
            if (modal) modal.style.display = 'flex';
        });
    });

    // Close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
    });

    // Search table filter
    const searchInput = document.getElementById('tableSearch');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q     = searchInput.value.toLowerCase();
            const rows  = document.querySelectorAll('tbody tr[data-search]');
            rows.forEach(row => {
                const text = row.getAttribute('data-search').toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        });
    }

    // Format currency inputs
    document.querySelectorAll('input[data-currency]').forEach(input => {
        input.addEventListener('blur', () => {
            const val = parseFloat(input.value.replace(/\D/g, ''));
            if (!isNaN(val)) {
                input.value = val;
            }
        });
    });

    // Auto-calculate total biaya on create penyewaan
    const tglSewa    = document.getElementById('tgl_sewa');
    const tglKembali = document.getElementById('tgl_kembali');
    const idMobil    = document.getElementById('id_mobil');
    const jenisSewa  = document.getElementById('jenis_sewa');
    const totalField = document.getElementById('total_biaya_preview');

    function hitungTotal() {
        if (!tglSewa || !tglKembali || !idMobil || !totalField) return;
        const t1     = new Date(tglSewa.value);
        const t2     = new Date(tglKembali.value);
        const durasi = Math.max(1, Math.ceil((t2 - t1) / 86400000));
        const opt    = idMobil.options[idMobil.selectedIndex];
        if (!opt) return;
        const tarif  = parseFloat(opt.getAttribute('data-tarif') || 0);
        const sopir  = jenisSewa && jenisSewa.value === 'dengan sopir' ? 200000 : 0;
        const total  = (tarif + sopir) * durasi;
        totalField.textContent = 'Total: Rp ' + total.toLocaleString('id-ID');
    }

    if (tglSewa)    tglSewa.addEventListener('change', hitungTotal);
    if (tglKembali) tglKembali.addEventListener('change', hitungTotal);
    if (idMobil)    idMobil.addEventListener('change', hitungTotal);
    if (jenisSewa)  jenisSewa.addEventListener('change', hitungTotal);
});

// Format rupiah
function formatRupiah(num) {
    return 'Rp ' + parseFloat(num || 0).toLocaleString('id-ID');
}
