<?php
// Konfigurasi database
$servername = "localhost"; // Nama server database
$username = "root";        // Username untuk mengakses database
$password = "";            // Password untuk mengakses database (kosong untuk localhost)
$dbname = "db_ilkom";      // Nama database yang digunakan

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan proses
    die("Connection failed: " . $conn->connect_error);
}

// Handle operasi delete (menghapus data)
// Mengecek apakah parameter 'id' dikirim melalui URL (menggunakan metode GET)
if (isset($_GET['id'])) {
    $publikasi_id = $_GET['id']; // Menyimpan ID publikasi yang akan dihapus dari parameter URL
    
    // Menyiapkan pernyataan SQL untuk menghapus data
    $stmt = $conn->prepare("DELETE FROM publikasi WHERE id = ?");
    // Mengikat parameter ID ke pernyataan SQL
    $stmt->bind_param('i', $publikasi_id);
    // Menjalankan pernyataan SQL
    $stmt->execute();
    
    // Mengarahkan kembali pengguna ke halaman kelola_publikasi.php setelah data dihapus
    header('Location: kelola_publikasi.php');
}

// Menutup koneksi database
$conn->close();
?>
