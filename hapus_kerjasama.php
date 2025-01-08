<?php
// Set your database connection parameters
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "db_ilkom"; // Replace with your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Cek apakah ada ID yang dikirimkan untuk dihapus
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID dengan prepared statement untuk mencegah SQL injection
    $deleteQuery = "DELETE FROM kerjasama WHERE id = ?";

    // Persiapkan statement
    $stmt = mysqli_prepare($conn, $deleteQuery);
    if ($stmt === false) {
        die("Error preparing the query: " . mysqli_error($conn));
    }

    // Bind parameter (bind_param) untuk mencegah SQL injection
    mysqli_stmt_bind_param($stmt, 'i', $id); // 'i' adalah tipe data integer

    // Eksekusi query
    if (mysqli_stmt_execute($stmt)) {
        echo "Record deleted successfully!";
        header("Location: kelola_kerjasama.php"); // Redirect setelah hapus
        exit; // Make sure to stop further script execution after redirect
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Menutup statement dan koneksi
    mysqli_stmt_close($stmt);
} else {
    echo "ID tidak ditemukan!";
}

mysqli_close($conn); // Menutup koneksi database
?>
