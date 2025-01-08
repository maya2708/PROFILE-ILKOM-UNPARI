<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'db_ilkom'; // Replace with your actual database name

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Create or Update
if (isset($_POST['create']) || isset($_POST['update'])) {
    $id = $_POST['id'] ?? null;
    $nama_prestasi = $_POST['nama_prestasi'];
    $raihan_peringkat_prestasi = $_POST['raihan_peringkat_prestasi'];
    $nama_peraih = $_POST['nama_peraih'];
    $status = $_POST['status'];
    $tanggal_raih = $_POST['tanggal_raih'];
    $level_prestasi = $_POST['level_prestasi'];
    $penyelenggara = $_POST['penyelenggara'];
    $link_bukti_prestasi = $_POST['link_bukti_prestasi'];

    if (isset($_POST['create'])) {
        // Insert new achievement
        $stmt = $conn->prepare("INSERT INTO prestasi (nama_prestasi, raihan_peringkat_prestasi, nama_peraih, status, tanggal_raih, level_prestasi, penyelenggara, link_bukti_prestasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $nama_prestasi, $raihan_peringkat_prestasi, $nama_peraih, $status, $tanggal_raih, $level_prestasi, $penyelenggara, $link_bukti_prestasi);
        $stmt->execute();
        $stmt->close();
    } else if (isset($_POST['update'])) {
        // Update existing achievement
        $stmt = $conn->prepare("UPDATE prestasi SET nama_prestasi = ?, raihan_peringkat_prestasi = ?, nama_peraih = ?, status = ?, tanggal_raih = ?, level_prestasi = ?, penyelenggara = ?, link_bukti_prestasi = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $nama_prestasi, $raihan_peringkat_prestasi, $nama_peraih, $status, $tanggal_raih, $level_prestasi, $penyelenggara, $link_bukti_prestasi, $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM prestasi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all achievements
$sql = "SELECT * FROM prestasi";
$result = $conn->query($sql);
$prestasi = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Prestasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4a90e2;
            margin-top: 40px;
            font-size: 36px;
        }

        h2 {
            color: #4a90e2;
            margin-top: 40px;
            text-align: center;
            font-size: 28px;
        }

        form {
            width: 70%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            background-color: #4a90e2;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border: none;
        }

        form button:hover {
            background-color: #357ab7;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
        }

        th {
            background-color: #4a90e2;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }

        td button {
            background-color: #e0eaf0;
            color: #4a90e2;
            border: 1px solid #4a90e2;
            border-radius: 4px;
            padding: 6px 12px;
            cursor: pointer;
        }

        td button:hover {
            background-color: #4a90e2;
            color: white;
        }

        td form {
            display: inline;
        }

        td form button {
            background-color: #f44336;
            color: white;
            border: none;
        }

        td form button:hover {
            background-color: #d32f2f;
        }

        /* New button for returning to dashboard */
        .back-btn {
            margin: 20px auto;
            display: block;
            background-color:rgb(74, 129, 216);
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none; /* Menghapus garis border */
            cursor: pointer;
            text-align: center;
            width: 250px;
        }

        .back-btn i {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>Kelola Prestasi</h1>
    
    <!-- Button to go back to Dashboard -->
    <a href="dashboard.php">
        <button class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </button>
    </a>

    <form method="POST">
        <input type="hidden" name="id" id="id">
        
        <label for="nama_prestasi">Nama Prestasi:</label>
        <input type="text" name="nama_prestasi" id="nama_prestasi" required>

        <label for="raihan_peringkat_prestasi">Raihan Peringkat Prestasi:</label>
        <input type="text" name="raihan_peringkat_prestasi" id="raihan_peringkat_prestasi" required>

        <label for="nama_peraih">Nama Peraih:</label>
        <input type="text" name="nama_peraih" id="nama_peraih" required>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="Dosen">Dosen</option>
            <option value="Mahasiswa">Mahasiswa</option>
        </select>

        <label for="tanggal_raih">Tanggal Raih Prestasi:</label>
        <input type="date" name="tanggal_raih" id="tanggal_raih" required>

        <label for="level_prestasi">Level Prestasi:</label>
        <select name="level_prestasi" id="level_prestasi" required>
            <option value="Lokal">Lokal</option>
            <option value="Nasional">Nasional</option>
            <option value="Internasional">Internasional</option>
        </select>

        <label for="penyelenggara">Pemberi/Penyelenggara Prestasi:</label>
        <input type="text" name="penyelenggara" id="penyelenggara" required>

        <label for="link_bukti_prestasi">Link Bukti Prestasi:</label>
        <input type="url" name="link_bukti_prestasi" id="link_bukti_prestasi" required>

        <button type="submit" name="create">Tambah</button>
        <button type="submit" name="update">Ubah</button>
    </form>

    <h2>Daftar Prestasi</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Prestasi</th>
                <th>Raihan Peringkat Prestasi</th>
                <th>Nama Peraih</th>
                <th>Status</th>
                <th>Tanggal Raih Prestasi</th>
                <th>Level Prestasi</th>
                <th>Pemberi/Penyelenggara Prestasi</th>
                <th>Link Bukti Prestasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestasi as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nama_prestasi'] ?></td>
                    <td><?= $row['raihan_peringkat_prestasi'] ?></td>
                    <td><?= $row['nama_peraih'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['tanggal_raih'] ?></td>
                    <td><?= $row['level_prestasi'] ?></td>
                    <td><?= $row['penyelenggara'] ?></td>
                    <td><a href="<?= $row['link_bukti_prestasi'] ?>" target="_blank">Lihat Bukti</a></td>
                    <td>
                        <button onclick="editPrestasi(<?= $row['id'] ?>, '<?= $row['nama_prestasi'] ?>', '<?= $row['raihan_peringkat_prestasi'] ?>', '<?= $row['nama_peraih'] ?>', '<?= $row['status'] ?>', '<?= $row['tanggal_raih'] ?>', '<?= $row['level_prestasi'] ?>', '<?= $row['penyelenggara'] ?>', '<?= $row['link_bukti_prestasi'] ?>')">Edit</button>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        function editPrestasi(id, nama_prestasi, raihan_peringkat_prestasi, nama_peraih, status, tanggal_raih, level_prestasi, penyelenggara, link_bukti_prestasi) {
            document.getElementById('id').value = id;
            document.getElementById('nama_prestasi').value = nama_prestasi;
            document.getElementById('raihan_peringkat_prestasi').value = raihan_peringkat_prestasi;
            document.getElementById('nama_peraih').value = nama_peraih;
            document.getElementById('status').value = status;
            document.getElementById('tanggal_raih').value = tanggal_raih;
            document.getElementById('level_prestasi').value = level_prestasi;
            document.getElementById('penyelenggara').value = penyelenggara;
            document.getElementById('link_bukti_prestasi').value = link_bukti_prestasi;
        }
    </script>
</body>
</html>


