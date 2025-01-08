<?php
// Koneksi ke database menggunakan PDO
$host = 'localhost';           // Host database (biasanya localhost)
$dbname = 'db_ilkom';          // Nama database
$username = 'root';            // Username untuk koneksi database
$password = '';                // Password untuk koneksi database (kosong untuk localhost)

try {
    // Membuat koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Mengatur mode error PDO menjadi Exception untuk menangani error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error
    die("Koneksi gagal: " . $e->getMessage());
}

// Mendapatkan ID dari parameter URL
$id = $_GET['id'] ?? null; // Mengambil nilai 'id' dari parameter GET
if (!$id) {
    // Jika ID tidak ditemukan, hentikan proses dan tampilkan pesan
    die("ID tidak ditemukan.");
}

// Mendapatkan data kerjasama berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM kerjasama WHERE id = ?"); // Query untuk mengambil data berdasarkan ID
$stmt->execute([$id]); // Menjalankan query dengan parameter ID
$kerjasama = $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil hasil sebagai array asosiatif
if (!$kerjasama) {
    // Jika data tidak ditemukan, hentikan proses dan tampilkan pesan
    die("Data kerjasama tidak ditemukan.");
}

// Menangani form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Mengecek apakah form dikirimkan
    // Mengambil data dari form
    $nama = $_POST['nama'] ?? '';
    $level = $_POST['level'] ?? '';
    $jenis = $_POST['jenis'] ?? '';
    $pihak1 = $_POST['pihak1'] ?? '';
    $pihak2 = $_POST['pihak2'] ?? '';
    $tgl = $_POST['tgl'] ?? '';
    $durasi = $_POST['durasi'] ?? '';
    $link = $_POST['link'] ?? '';

    // Query untuk mengupdate data di tabel kerjasama
    $stmt = $pdo->prepare("UPDATE kerjasama SET nama = ?, level = ?, jenis = ?, pihak1 = ?, pihak2 = ?, tgl = ?, durasi = ?, link = ? WHERE id = ?");
    // Menjalankan query dengan parameter yang diambil dari form
    $stmt->execute([$nama, $level, $jenis, $pihak1, $pihak2, $tgl, $durasi, $link, $id]);

    // Redirect ke halaman kelola_kerjasama.php setelah data berhasil diperbarui
    header("Location: kelola_kerjasama.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kerjasama</title>
    <style>
        /* Styling halaman form */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9; /* Warna latar belakang */
        }
        .container {
            max-width: 600px; /* Lebar maksimal form */
            margin: 20px auto; /* Form di tengah halaman */
            padding: 20px;
            background: #fff; /* Warna latar belakang form */
            border-radius: 8px; /* Sudut membulat */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan form */
        }
        h1 {
            text-align: center;
            color: #333; /* Warna teks */
        }
        .form-group {
            margin-bottom: 15px; /* Jarak antar elemen form */
        }
        label {
            display: block;
            margin-bottom: 5px; /* Jarak antara label dan input */
            color: #555; /* Warna teks label */
        }
        input, select, button {
            width: 100%; /* Lebar penuh */
            padding: 10px; /* Padding elemen */
            margin: 5px 0;
            border: 1px solid #ccc; /* Warna border */
            border-radius: 5px; /* Sudut membulat */
        }
        button {
            background-color: #007bff; /* Warna tombol */
            color: white; /* Warna teks tombol */
            cursor: pointer; /* Kursor menjadi pointer */
        }
        button:hover {
            background-color: #0056b3; /* Warna tombol saat hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Kerjasama</h1>
        <!-- Form untuk mengedit data kerjasama -->
        <form method="POST">
            <!-- Nama Kerjasama -->
            <div class="form-group">
                <label for="nama">Nama Kerjasama</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($kerjasama['nama']) ?>" required>
            </div>
            <!-- Level -->
            <div class="form-group">
                <label for="level">Level</label>
                <select id="level" name="level" required>
                    <option value="">-- Pilih Level --</option>
                    <option value="Local" <?= $kerjasama['level'] === 'Local' ? 'selected' : '' ?>>Local</option>
                    <option value="Nasional" <?= $kerjasama['level'] === 'Nasional' ? 'selected' : '' ?>>Nasional</option>
                    <option value="Internasional" <?= $kerjasama['level'] === 'Internasional' ? 'selected' : '' ?>>Internasional</option>
                </select>
            </div>
            <!-- Jenis Kerjasama -->
            <div class="form-group">
                <label for="jenis">Jenis Kerjasama</label>
                <input type="text" id="jenis" name="jenis" value="<?= htmlspecialchars($kerjasama['jenis']) ?>" required>
            </div>
            <!-- Pihak 1 -->
            <div class="form-group">
                <label for="pihak1">Pihak 1</label>
                <input type="text" id="pihak1" name="pihak1" value="<?= htmlspecialchars($kerjasama['pihak1']) ?>" required>
            </div>
            <!-- Pihak 2 -->
            <div class="form-group">
                <label for="pihak2">Pihak 2</label>
                <input type="text" id="pihak2" name="pihak2" value="<?= htmlspecialchars($kerjasama['pihak2']) ?>" required>
            </div>
            <!-- Tanggal Kerjasama -->
            <div class="form-group">
                <label for="tgl">Tanggal Kerjasama</label>
                <input type="date" id="tgl" name="tgl" value="<?= htmlspecialchars($kerjasama['tgl']) ?>" required>
            </div>
            <!-- Durasi Kerjasama -->
            <div class="form-group">
                <label for="durasi">Durasi (Tahun)</label>
                <input type="number" id="durasi" name="durasi" value="<?= htmlspecialchars($kerjasama['durasi']) ?>" required>
            </div>
            <!-- Link Dokumen -->
            <div class="form-group">
                <label for="link">Link Dokumen</label>
                <input type="url" id="link" name="link" value="<?= htmlspecialchars($kerjasama['link']) ?>" required>
            </div>
            <!-- Tombol Simpan -->
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
