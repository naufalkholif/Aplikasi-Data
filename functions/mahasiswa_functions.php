<?php
/**
 * File fungsi-fungsi pengelolaan data mahasiswa
 * 
 * Berisi semua fungsi CRUD (Create, Read, Update, Delete)
 * untuk data mahasiswa
 * 
 * @author: Naufal Kholif Nashuha
 * @date: 21 Februari 2026
 */

require_once __DIR__ . '/../config/database.php';

/**
 * Menghitung usia berdasarkan tanggal lahir
 * 
 * @param string $tanggal_lahir Format YYYY-MM-DD
 * @return int Usia dalam tahun
 */
function hitungUsia($tanggal_lahir) {
    $lahir = new DateTime($tanggal_lahir);
    $sekarang = new DateTime();
    $usia = $sekarang->diff($lahir);
    return $usia->y;
}

/**
 * Mengambil semua data mahasiswa (urut descending NIM)
 * 
 * @param mysqli $conn Koneksi database
 * @return array Array asosiatif data mahasiswa
 */
function getAllMahasiswa($conn) {
    $sql = "SELECT * FROM mahasiswa ORDER BY nim DESC";
    $result = mysqli_query($conn, $sql);
    
    $data = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

/**
 * Mencari mahasiswa berdasarkan nama
 * 
 * @param mysqli $conn Koneksi database
 * @param string $keyword Kata kunci pencarian
 * @return array Array asosiatif data mahasiswa yang sesuai
 */
function searchMahasiswaByName($conn, $keyword) {
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $sql = "SELECT * FROM mahasiswa WHERE nama LIKE '%$keyword%' ORDER BY nim DESC";
    $result = mysqli_query($conn, $sql);
    
    $data = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

/**
 * Mengambil data mahasiswa berdasarkan ID
 * 
 * @param mysqli $conn Koneksi database
 * @param int $id ID mahasiswa
 * @return array|null Array data mahasiswa atau null jika tidak ditemukan
 */
function getMahasiswaById($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM mahasiswa WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

/**
 * Menambah data mahasiswa baru
 * 
 * @param mysqli $conn Koneksi database
 * @param array $data Data mahasiswa [nim, nama, alamat, tanggal_lahir, gender]
 * @return bool True jika berhasil, false jika gagal
 */
function tambahMahasiswa($conn, $data) {
    // Escape string untuk keamanan
    $nim = mysqli_real_escape_string($conn, $data['nim']);
    $nama = mysqli_real_escape_string($conn, $data['nama']);
    $alamat = mysqli_real_escape_string($conn, $data['alamat']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $data['tanggal_lahir']);
    $gender = mysqli_real_escape_string($conn, $data['gender']);
    
    // Hitung usia otomatis
    $usia = hitungUsia($tanggal_lahir);
    
    // Query insert
    $sql = "INSERT INTO mahasiswa (nim, nama, alamat, tanggal_lahir, gender, usia) 
            VALUES ('$nim', '$nama', '$alamat', '$tanggal_lahir', '$gender', $usia)";
    
    return mysqli_query($conn, $sql);
}

/**
 * Mengupdate data mahasiswa (NIM tidak bisa diubah)
 * 
 * @param mysqli $conn Koneksi database
 * @param int $id ID mahasiswa
 * @param array $data Data baru [nama, alamat, tanggal_lahir, gender]
 * @return bool True jika berhasil, false jika gagal
 */
function updateMahasiswa($conn, $id, $data) {
    $id = mysqli_real_escape_string($conn, $id);
    $nama = mysqli_real_escape_string($conn, $data['nama']);
    $alamat = mysqli_real_escape_string($conn, $data['alamat']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $data['tanggal_lahir']);
    $gender = mysqli_real_escape_string($conn, $data['gender']);
    
    // Hitung ulang usia
    $usia = hitungUsia($tanggal_lahir);
    
    // Query update (NIM tidak diupdate)
    $sql = "UPDATE mahasiswa SET 
            nama = '$nama',
            alamat = '$alamat',
            tanggal_lahir = '$tanggal_lahir',
            gender = '$gender',
            usia = $usia
            WHERE id = '$id'";
    
    return mysqli_query($conn, $sql);
}

/**
 * Menghapus data mahasiswa
 * 
 * @param mysqli $conn Koneksi database
 * @param int $id ID mahasiswa
 * @return bool True jika berhasil, false jika gagal
 */
function hapusMahasiswa($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "DELETE FROM mahasiswa WHERE id = '$id'";
    return mysqli_query($conn, $sql);
}

/**
 * Mendapatkan statistik gender mahasiswa
 * 
 * @param mysqli $conn Koneksi database
 * @return array Array statistik [total, laki, perempuan]
 */
function getStatistikGender($conn) {
    $statistik = [
        'total' => 0,
        'laki' => 0,
        'perempuan' => 0
    ];
    
    // Hitung total
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa");
    if ($row = mysqli_fetch_assoc($result)) {
        $statistik['total'] = $row['total'];
    }
    
    // Hitung laki-laki
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa WHERE gender = 'Laki-laki'");
    if ($row = mysqli_fetch_assoc($result)) {
        $statistik['laki'] = $row['total'];
    }
    
    // Hitung perempuan
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa WHERE gender = 'Perempuan'");
    if ($row = mysqli_fetch_assoc($result)) {
        $statistik['perempuan'] = $row['total'];
    }
    
    return $statistik;
}

/**
 * Validasi data mahasiswa sebelum insert/update
 * 
 * @param array $data Data yang akan divalidasi
 * @return array Array dengan status validasi dan pesan error
 */
function validasiDataMahasiswa($data) {
    $errors = [];
    
    // Validasi NIM (hanya untuk tambah data)
    if (isset($data['nim']) && empty(trim($data['nim']))) {
        $errors[] = "NIM tidak boleh kosong";
    }
    
    // Validasi Nama
    if (empty(trim($data['nama']))) {
        $errors[] = "Nama tidak boleh kosong";
    }
    
    // Validasi Alamat
    if (empty(trim($data['alamat']))) {
        $errors[] = "Alamat tidak boleh kosong";
    }
    
    // Validasi Tanggal Lahir
    if (empty($data['tanggal_lahir'])) {
        $errors[] = "Tanggal lahir tidak boleh kosong";
    }
    
    // Validasi Gender
    if (empty($data['gender'])) {
        $errors[] = "Gender harus dipilih";
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}
?>