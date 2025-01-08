<?php
// Koneksi database
$conn = new mysqli('localhost', 'root', '', 'db_ilkom');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data kegiatan
$result = $conn->query("SELECT * FROM kegiatan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kegiatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #4682b4;
            margin-top: 20px;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #dcdcdc;
        }
        th, td {
            padding: 12px;
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
        img {
            width: 80px;
            height: auto;
            margin: 5px;
            border-radius: 5px;
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
    <h1>Daftar Kegiatan</h1>

    <table>
        <tr>
            <th><i class="fas fa-id-card icon"></i>ID</th>
            <th><i class="fas fa-heading icon"></i>Judul</th>
            <th><i class="fas fa-align-left icon"></i>Deskripsi</th>
            <th><i class="fas fa-globe icon"></i>Lingkup</th>
            <th><i class="fas fa-list icon"></i>Jenis Kegiatan</th>
            <th><i class="fas fa-calendar-alt icon"></i>Tanggal Awal</th>
            <th><i class="fas fa-calendar-alt icon"></i>Tanggal Akhir</th>
            <th><i class="fas fa-image icon"></i>Foto</th>
            <th><i class="fas fa-file-alt icon"></i>Link Laporan</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['judul']; ?></td>
            <td><?php echo $row['deskripsi']; ?></td>
            <td><?php echo $row['lingkup']; ?></td>
            <td><?php echo $row['jenis_kegiatan']; ?></td>
            <td><?php echo $row['tanggal_awal']; ?></td>
            <td><?php echo $row['tanggal_akhir']; ?></td>
            <td>
                <?php
                $foto_array = json_decode($row['foto'], true);
                foreach ($foto_array as $foto): ?>
                    <img src="<?php echo $foto; ?>" alt="Foto Kegiatan">
                <?php endforeach; ?>
            </td>
            <td><a href="<?php echo $row['link_laporan']; ?>" target="_blank"><i class="fas fa-external-link-alt"></i> Lihat Laporan</a></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
