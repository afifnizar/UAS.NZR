<?php
include 'koneksi.php';

if (isset($_GET['id'])) {  // Get the 'id' parameter from URL
    $id = $_GET['id'];      // Get the 'id' parameter
    
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string(mysql: $koneksi, string: $id);
    
    // Query untuk menghapus data - now using the correct variable
    $query = "DELETE FROM kegiatan WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        // Check if any rows were actually deleted
        if (mysqli_affected_rows(mysql: $koneksi) > 0) {
            header("Location: index.php?status=sukses");
        } else {
            header("Location: index.php?status=gagal&pesan=Data tidak ditemukan");
        }
    } else {
        // Redirect dengan status gagal jika error
        header("Location: index.php?status=gagal&pesan=" . urlencode(mysqli_error($koneksi)));
    }
} else {
    // Redirect jika tidak ada ID
    header("Location: index.php?status=gagal&pesan=ID tidak ditemukan");
}
?>