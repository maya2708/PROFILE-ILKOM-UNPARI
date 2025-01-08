<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ilkom";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch publications
$query = "SELECT * FROM publikasi";
$result = $conn->query($query);
$publikasi = [];
while ($row = $result->fetch_assoc()) {
    $publikasi[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publikasi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f8ff;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #4682b4;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #b0e0e6;
            color: #333;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e0f7ff;
        }
        a {
            color: #007acc;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .icon {
            margin-right: 8px;
            color: #4682b4;
        }
    </style>
</head>
<body>
    <h1>Daftar Publikasi</h1>

    <!-- Publications Table -->
    <table>
        <thead>
            <tr>
                <th><i class="fas fa-book icon"></i>Judul</th>
                <th><i class="fas fa-user icon"></i>Penulis</th>
                <th><i class="fas fa-newspaper icon"></i>Nama Jurnal</th>
                <th><i class="fas fa-level-up-alt icon"></i>Level Jurnal</th>
                <th><i class="fas fa-calendar-alt icon"></i>Tanggal Terbit</th>
                <th><i class="fas fa-bookmark icon"></i>Volume</th>
                <th><i class="fas fa-archive icon"></i>Edisi</th>
                <th><i class="fas fa-file-alt icon"></i>Halaman</th>
                <th><i class="fas fa-link icon"></i>Link</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($publikasi as $item): ?>
                <tr>
                    <td><?php echo $item['judul']; ?></td>
                    <td><?php echo $item['penulis']; ?></td>
                    <td><?php echo $item['nama_jurnal']; ?></td>
                    <td><?php echo $item['level_jurnal']; ?></td>
                    <td><?php echo $item['tanggal_terbit']; ?></td>
                    <td><?php echo $item['volume_jurnal']; ?></td>
                    <td><?php echo $item['edisi_jurnal']; ?></td>
                    <td><?php echo $item['halaman']; ?></td>
                    <td><a href="<?php echo $item['link_jurnal']; ?>" target="_blank"><i class="fas fa-external-link-alt icon"></i>Lihat</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
