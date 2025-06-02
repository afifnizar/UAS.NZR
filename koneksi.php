<?php
// 1. Menentukan detail koneksi database
$host = "localhost";        // Alamat server database, biasanya 'localhost'
$user = "root";             // Username MySQL (default untuk XAMPP adalah 'root')
$password = "";             // Password MySQL (default di XAMPP biasanya kosong)
$database = "db_mhs"; // Nama database yang ingin dikoneksikan

// 2. Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $password, $database);

// 3. Mengecek apakah koneksi berhasil atau tidak
if (!$koneksi) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan program
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
