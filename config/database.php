<?php
/**
 * File konfigurasi koneksi database
 * 
 * Fungsi: Menghubungkan aplikasi dengan database MySQL
 * @author: Naufal Kholif Nashuha
 * @date: 21 Februari 2026
 */

// Konfigurasi database
$db_host = 'localhost';  // Host database
$db_user = 'root';       // Username database
$db_pass = '';           // Password database
$db_name = 'db_mahasiswa'; // Nama database

// Membuat koneksi
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset ke UTF-8
mysqli_set_charset($conn, "utf8");

/**
 * Fungsi untuk menutup koneksi database
 * @param mysqli $conn Objek koneksi database
 */
function closeConnection($conn) {
    if ($conn) {
        mysqli_close($conn);
    }
}
?>