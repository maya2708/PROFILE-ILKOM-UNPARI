<?php
// Koneksi ke database
$host = 'localhost'; // Ganti dengan host database Anda
$user = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda
$dbname = 'db_ilkom'; // Ganti dengan nama database Anda

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil semua data prestasi
$sql = "SELECT * FROM prestasi";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Prestasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #4a90e2;
            margin-top: 30px;
            font-size: 36px;
        }

        table {
            width: 90%;
            margin: 40px auto;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4a90e2;
            color: white;
            font-size: 18px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        td a {
            padding: 5px 10px;
            background-color: #e0eaf0;
            border-radius: 5px;
            border: 1px solid #4a90e2;
            font-weight: bold;
        }

        td a:hover {
            background-color: #4a90e2;
            color: white;
        }

        .no-data {
            text-align: center;
            font-size: 18px;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Daftar Prestasi</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Prestasi</th>
                <th>Raihan Prestasi</th>
                <th>Nama Peraih</th>
                <th>Status</th>
                <th>Tanggal Raih</th>
                <th>Level Prestasi</th>
                <th>Pemberi/Penyelenggara</th>
                <th>Bukti Prestasi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nama_prestasi'] ?></td>
                        <td><?= $row['raihan_peringkat_prestasi'] ?></td>
                        <td><?= $row['nama_peraih'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td><?= $row['tanggal_raih'] ?></td>
                        <td><?= $row['level_prestasi'] ?></td>
                        <td><?= $row['penyelenggara'] ?></td>
                        <td>
                            <?php if (!empty($row['link_bukti_prestasi'])): ?>
                                <a href="<?= $row['link_bukti_prestasi'] ?>" target="_blank">LihatBukti</a>
                            <?php else: ?>
                                Tidak ada bukti
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="no-data">Tidak ada data prestasi yang ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php
    // Menutup koneksi
    $conn->close();
    ?>
</body>
</html>
