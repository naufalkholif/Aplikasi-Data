# APLIKASI DATA MAHASISWA

![PHP](https://img.shields.io/badge/PHP-7.4+-green)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![License](https://img.shields.io/badge/license-MIT-red)

---

## DESKRIPSI

**Aplikasi Data Mahasiswa** adalah sistem informasi berbasis web yang dikembangkan untuk mengelola data mahasiswa secara efektif dan efisien. Aplikasi ini memungkinkan pengguna untuk melakukan operasi CRUD (Create, Read, Update, Delete) pada data mahasiswa, dilengkapi dengan fitur pencarian dan statistik real-time.

Dibangun dengan **PHP Native** dan **MySQL**, aplikasi ini mengimplementasikan prinsip pemrograman terstruktur dan best practices dalam pengembangan web.

---

## FITUR UTAMA

### Halaman HOME
| Fitur | Deskripsi |
|-------|-----------|
| **Tampil Data** | Menampilkan seluruh data mahasiswa dalam bentuk tabel |
| **Urutan Descending** | Data diurutkan berdasarkan NIM dari terbesar ke terkecil |
| **Pencarian** | Mencari data mahasiswa berdasarkan nama (partial search) |
| **Statistik Real-time** | Menampilkan total mahasiswa, jumlah laki-laki, dan jumlah perempuan |

### Halaman ADMIN
| Fitur | Deskripsi |
|-------|-----------|
| **Tambah Data** | Form input untuk menambahkan data mahasiswa baru |
| **Edit Data** | Mengubah data mahasiswa yang sudah ada (NIM tidak dapat diubah) |
| **Hapus Data** | Menghapus data mahasiswa dengan konfirmasi |
| **Validasi Input** | Memastikan data yang masuk sesuai ketentuan |

### Fitur Tambahan
- **Responsive Design** - Tampilan menyesuaikan dengan berbagai ukuran layar
- **Animasi Halus** - Menggunakan AOS (Animate on Scroll)
- **Icon Modern** - Dipercantik dengan Font Awesome 6
- **Notifikasi** - Alert sukses/gagal untuk setiap operasi

---

## TEKNOLOGI YANG DIGUNAKAN

### Backend
| Teknologi | Versi | Kegunaan |
|-----------|-------|----------|
| **PHP** | 7.4 / 8.x | Bahasa pemrograman utama |
| **MySQL** | 5.7+ | Database management system |
| **Apache** | 2.4 | Web server |

### Frontend
| Teknologi | Versi | Kegunaan |
|-----------|-------|----------|
| **HTML5** | - | Struktur halaman web |
| **CSS3** | - | Styling dan layout |
| **JavaScript** | ES6 | Interaktivitas |

### Library & Framework
| Library | Versi | Kegunaan | Sumber |
|---------|-------|----------|--------|
| **Bootstrap** | 5.3.0 | Framework CSS responsif | CDN |
| **Font Awesome** | 6.4.0 | Icon library | CDN |
| **jQuery** | 3.6.0 | Manipulasi DOM | CDN |
| **AOS** | 2.3.1 | Animasi scroll | CDN |
| **Google Fonts** | Poppins | Typography | CDN |

---

## STRUKTUR FOLDER
project_mahasiswa/
├── assets/
│   ├── css/
│   │   └── style.css              # File CSS utama
│   └── js/
│       └── script.js              # File JavaScript utama
|
├── config/
│   └── database.php               # Konfigurasi koneksi database
│
├── functions/
│   └── mahasiswa_functions.php    # Fungsi-fungsi CRUD
│
├── includes/
│   ├── header.php                 # Template header
│   └── footer.php                 # Template footer
|
├── index.php                    # Halaman utama (HOME)
├── admin.php                    # Halaman admin (CRUD)
├── README.md                    # Dokumentasi aplikasi
└── manual.pdf                   # Buku panduan

---

## STRUKTUR DATABASE

### Nama Database: `db_mahasiswa`

### Tabel: `mahasiswa`

sql
CREATE TABLE mahasiswa (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    tanggal_lahir DATE,
    gender ENUM('Laki-laki', 'Perempuan') NOT NULL,
    usia INT(3),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


Deskripsi Kolom

Kolom Tipe Data Keterangan
id INT(11) Primary Key, auto increment
nim VARCHAR(20) Nomor Induk Mahasiswa (unik)
nama VARCHAR(100) Nama lengkap mahasiswa
alamat TEXT Alamat mahasiswa (cukup kota)
tanggal_lahir DATE Tanggal lahir (YYYY-MM-DD)
gender ENUM Jenis kelamin (Laki-laki/Perempuan)
usia INT(3) Usia dalam tahun (dihitung otomatis)
created_at TIMESTAMP Waktu data dibuat
updated_at TIMESTAMP Waktu data terakhir diupdate

---


