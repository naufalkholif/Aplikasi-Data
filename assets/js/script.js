/**
 * APLIKASI DATA MAHASISWA
 * File JavaScript
 * Author: Naufal Kholif Nashuha
 * Tanggal: 21 Februari 2026
 */

// Menunggu dokumen siap
document.addEventListener('DOMContentLoaded', function () {
    console.log('✅ Aplikasi Data Mahasiswa siap digunakan');

    // Initialize AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
    }

    // Auto-hide alert setelah 5 detik
    autoHideAlert();

    // Initialize tooltips
    initTooltips();

    // Form validation
    initFormValidation();

    // Smooth scroll
    initSmoothScroll();
});

/**
 * Auto hide alert setelah 5 detik
 */
function autoHideAlert() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            if (alert && typeof bootstrap !== 'undefined') {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } else {
                alert.style.display = 'none';
            }
        }, 5000);
    });
}

/**
 * Initialize Bootstrap tooltips
 */
function initTooltips() {
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        if (tooltipTriggerList.length > 0) {
            [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
    }
}

/**
 * Form validation
 */
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
}

/**
 * Smooth scroll untuk anchor links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Konfirmasi hapus data
 * @param {number} id - ID mahasiswa
 * @param {string} nama - Nama mahasiswa
 */
function konfirmasiHapus(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus data mahasiswa "' + nama + '"?')) {
        document.getElementById('hapus-id').value = id;
        document.getElementById('form-hapus').submit();
    }
}

/**
 * Format tanggal ke format Indonesia
 * @param {string} dateString - Tanggal dalam format YYYY-MM-DD
 * @returns {string} Tanggal dalam format DD-MM-YYYY
 */
function formatTanggalIndonesia(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

/**
 * Reset form pencarian
 */
function resetSearch() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.value = '';
        window.location.href = 'index.php';
    }
}

/**
 * Tampilkan loading spinner
 */
function showLoading() {
    const loader = document.createElement('div');
    loader.className = 'loading-spinner';
    loader.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
    loader.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    `;
    document.body.appendChild(loader);
}

/**
 * Hilangkan loading spinner
 */
function hideLoading() {
    const loader = document.querySelector('.loading-spinner');
    if (loader) {
        loader.remove();
    }
}

/**
 * Copy text ke clipboard
 * @param {string} text - Teks yang akan di-copy
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function () {
        alert('Teks berhasil di-copy!');
    }, function (err) {
        console.error('Gagal copy: ', err);
    });
}

/**
 * Print halaman
 */
function printPage() {
    window.print();
}

// Export fungsi untuk penggunaan global
window.konfirmasiHapus = konfirmasiHapus;
window.formatTanggalIndonesia = formatTanggalIndonesia;
window.resetSearch = resetSearch;