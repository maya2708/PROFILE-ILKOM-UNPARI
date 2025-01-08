<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'db_ilkom';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Fungsi untuk mengambil data kerjasama
function getKerjasama($pdo) {
    $stmt = $pdo->query("SELECT * FROM kerjasama");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle form submission untuk menyimpan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $level = $_POST['level'] ?? '';
    $jenis = $_POST['jenis'] ?? '';
    $pihak1 = $_POST['pihak1'] ?? '';
    $pihak2 = $_POST['pihak2'] ?? '';
    $tgl = $_POST['tgl'] ?? '';
    $durasi = $_POST['durasi'] ?? '';
    $link = filter_var($_POST['link'] ?? '', FILTER_SANITIZE_URL);

    // Validasi URL sebelum disimpan
    if (!filter_var($link, FILTER_VALIDATE_URL)) {
        die("Link dokumen tidak valid! Pastikan URL yang dimasukkan benar.");
    }

    $stmt = $pdo->prepare("INSERT INTO kerjasama (nama, level, jenis, pihak1, pihak2, tgl, durasi, link) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $level, $jenis, $pihak1, $pihak2, $tgl, $durasi, $link]);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$kerjasamaList = getKerjasama($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kerjasama</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 12px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, button {
            width: 97%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .no-data {
            text-align: center;
            font-style: italic;
        }
        /* Styling untuk tombol */
        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #007bff; /* Biru */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #0056b3; /* Biru lebih gelap saat hover */
        }

        .btn-back i {
            margin-right: 8px;
        }
        /* CSS untuk Modal */
        .modal {
            display: none; /* Modal tidak ditampilkan secara default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Latar belakang gelap */
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .close-btn {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 5px;
            right: 15px;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
        }

        button {
            margin: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        #confirmDelete {
            background-color: #dc3545;
            color: white;
        }

        #confirmDelete:hover {
            background-color: #c82333;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Kelola Kerjasama</h1>
        <a href="dashboard.php" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a><br><br>
        <form method="POST">
            <div class="form-group">
                <label for="nama">Nama Kerjasama</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select id="level" name="level" required>
                    <option value="">-- Pilih Level --</option>
                    <option value="Local">Local</option>
                    <option value="Nasional">Nasional</option>
                    <option value="Internasional">Internasional</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jenis">Jenis Kerjasama</label>
                <input type="text" id="jenis" name="jenis" required>
            </div>
            <div class="form-group">
                <label for="pihak1">Pihak 1</label>
                <input type="text" id="pihak1" name="pihak1" required>
            </div>
            <div class="form-group">
                <label for="pihak2">Pihak 2</label>
                <input type="text" id="pihak2" name="pihak2" required>
            </div>
            <div class="form-group">
                <label for="tgl">Tanggal Kerjasama</label>
                <input type="date" id="tgl" name="tgl" required>
            </div>
            <div class="form-group">
                <label for="durasi">Durasi (Tahun)</label>
                <input type="number" id="durasi" name="durasi" required>
            </div>
            <div class="form-group">
                <label for="link">Link Dokumen</label>
                <input type="url" id="link" name="link" required>
            </div>
            <button type="submit">Simpan</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Level</th>
                    <th>Jenis</th>
                    <th>Pihak 1</th>
                    <th>Pihak 2</th>
                    <th>Tanggal</th>
                    <th>Durasi</th>
                    <th>Link</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kerjasamaList as $kerjasama): ?>
                    <tr>
                        <td><?= htmlspecialchars($kerjasama['nama']) ?></td>
                        <td><?= htmlspecialchars($kerjasama['level']) ?></td>
                        <td><?= htmlspecialchars($kerjasama['jenis']) ?></td>
                        <td><?= htmlspecialchars($kerjasama['pihak1']) ?></td>
                        <td><?= htmlspecialchars($kerjasama['pihak2']) ?></td>
                        <td><?= htmlspecialchars($kerjasama['tgl']) ?></td>
                        <td><?= htmlspecialchars($kerjasama['durasi']) ?></td>
                        <td>
                            <?php if (!empty($kerjasama['link'])): ?>
                                <a href="<?= htmlspecialchars($kerjasama['link']) ?>" target="_blank">Lihat Bukti MoU</a>
                            <?php else: ?>
                                <span class="no-data">Tidak ada link</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_kerjasama.php?id=<?= htmlspecialchars($kerjasama['id']) ?>" class="btn">Edit</a>
                            <a href="javascript:void(0)" class="btn-danger" onclick="showModal('hapus_kerjasama.php?id=<?= htmlspecialchars($kerjasama['id']) ?>')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($kerjasamaList)): ?>
                    <tr>
                        <td colspan="9" class="no-data">Tidak ada data kerjasama</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Konfirmasi Penghapusan</h2>
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <button id="confirmDelete" class="btn btn-danger">Ya, Hapus</button>
            <button onclick="closeModal()" class="btn">Batal</button>
        </div>
    </div>

    <script>
        let deleteModal = document.getElementById('deleteModal');
        let confirmDeleteButton = document.getElementById('confirmDelete');
        let deleteUrl = '';

        // Fungsi untuk menampilkan modal
        function showModal(url) {
            deleteUrl = url; // Simpan URL penghapusan
            deleteModal.style.display = 'block'; // Tampilkan modal
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            deleteModal.style.display = 'none'; // Sembunyikan modal
        }

        // Konfirmasi penghapusan data
        confirmDeleteButton.addEventListener('click', function() {
            window.location.href = deleteUrl; // Redirect ke URL penghapusan
        });

        // Menutup modal saat klik di luar modal
        window.onclick = function(event) {
            if (event.target === deleteModal) {
                closeModal();
            }
        };
    </script>

</body>
</html>
