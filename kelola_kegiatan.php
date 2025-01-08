<?php
// Koneksi database
$conn = new mysqli('localhost', 'root', '', 'db_ilkom');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk menambahkan kegiatan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $judul = $conn->real_escape_string($_POST['judul']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $lingkup = $conn->real_escape_string($_POST['lingkup']);
    $jenis_kegiatan = $conn->real_escape_string($_POST['jenis_kegiatan']);
    $tanggal_awal = $conn->real_escape_string($_POST['tanggal_awal']);
    $tanggal_akhir = $conn->real_escape_string($_POST['tanggal_akhir']);
    $link_laporan = $conn->real_escape_string($_POST['link_laporan']);

    $foto = [];
    $target_dir = "uploads/";

    // Proses upload banyak file
    for ($i = 1; $i <= 10; $i++) {
        if (!empty($_FILES["foto_$i"]["name"])) {
            $target_file = $target_dir . basename($_FILES["foto_$i"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["foto_$i"]["tmp_name"]);
            if ($check !== false && $_FILES["foto_$i"]["size"] <= 500000 && in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                if (move_uploaded_file($_FILES["foto_$i"]["tmp_name"], $target_file)) {
                    $foto[] = $target_file;
                } else {
                    echo "Gagal mengunggah foto: " . $_FILES["foto_$i"]["name"];
                }
            }
        }
    }

    $foto_json = json_encode($foto);

    $stmt = $conn->prepare("INSERT INTO kegiatan (judul, deskripsi, lingkup, jenis_kegiatan, tanggal_awal, tanggal_akhir, foto, link_laporan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $judul, $deskripsi, $lingkup, $jenis_kegiatan, $tanggal_awal, $tanggal_akhir, $foto_json, $link_laporan);

    if ($stmt->execute()) {
        echo "Kegiatan berhasil ditambahkan.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fungsi untuk menghapus kegiatan
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $result = $conn->query("SELECT foto FROM kegiatan WHERE id = $id");
    if ($result) {
        $row = $result->fetch_assoc();
        $foto_array = json_decode($row['foto'], true);
        foreach ($foto_array as $foto) {
            if (file_exists($foto)) {
                unlink($foto);
            }
        }
        $conn->query("DELETE FROM kegiatan WHERE id = $id");
    }
    header("Location: kelola_kegiatan.php");
    exit;
}

// Fungsi untuk mengupdate kegiatan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $judul = $conn->real_escape_string($_POST['judul']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $lingkup = $conn->real_escape_string($_POST['lingkup']);
    $jenis_kegiatan = $conn->real_escape_string($_POST['jenis_kegiatan']);
    $tanggal_awal = $conn->real_escape_string($_POST['tanggal_awal']);
    $tanggal_akhir = $conn->real_escape_string($_POST['tanggal_akhir']);
    $link_laporan = $conn->real_escape_string($_POST['link_laporan']);

    $stmt = $conn->prepare("UPDATE kegiatan SET judul=?, deskripsi=?, lingkup=?, jenis_kegiatan=?, tanggal_awal=?, tanggal_akhir=?, link_laporan=? WHERE id=?");
    $stmt->bind_param("sssssssi", $judul, $deskripsi, $lingkup, $jenis_kegiatan, $tanggal_awal, $tanggal_akhir, $link_laporan, $id);

    if ($stmt->execute()) {
        echo "Kegiatan berhasil diperbarui.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    header("Location: kelola_kegiatan.php");
    exit;
}

// Ambil data kegiatan
$result = $conn->query("SELECT * FROM kegiatan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        .btn-primary, .btn-danger {
            margin-top: 10px;
        }
        table {
            margin-top: 20px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        h1 {
            color: #007bff;
        }
        /* Button Styles */
        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            margin-bottom: 20px;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        .btn-back i {
            margin-right: 8px;
        }
        /* Mengubah warna teks pada seluruh tabel */
        .table th, .table td {
            color: black; /* Mengatur warna teks menjadi hitam */
        }

        /* Mengatur warna latar belakang untuk header */
        .table th {
            background-color: #007bff;
            color: white;
        }

        /* Styling tambahan untuk tombol dan form */
        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            margin-bottom: 20px;
            transition: background-color 0.3s ease-in-out;
        }
        /* Styling untuk tabel */
        th {
            background-color: #007bff;
            color: white;
        }
         /* Styling untuk foto-foto dalam tabel */
         .table td img {
            max-width: 50px;
            height: auto;
            border-radius: 6px;
        }
        /* Styling saat hover pada baris tabel */
        .table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-calendar"></i> Kelola Kegiatan</h1><br><br>
        <h2><i class="fas fa-plus-circle"></i> Tambah Kegiatan</h2><br>
        <!-- Back Button -->
        <a href="dashboard.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a><br>
        <form action="kelola_kegiatan.php" method="POST" enctype="multipart/form-data" class="form-control">
            <input type="text" name="judul" placeholder="Judul" class="form-control" required><br>
            <textarea name="deskripsi" placeholder="Deskripsi" class="form-control" required></textarea><br>
            <select name="lingkup" class="form-select" required>
                <option value="">Pilih Lingkup</option>
                <option value="Nasional">Nasional</option>
                <option value="Internasional">Internasional</option>
                <option value="Lokal">Lokal</option>
            </select><br>
            <select name="jenis_kegiatan" class="form-select" required>
                <option value="">Pilih Jenis Kegiatan</option>
                <option value="Seminar">Seminar</option>
                <option value="Workshop">Workshop</option>
                <option value="Pelatihan">Pelatihan</option>
                <option value="Akademik">Akademik</option>
                <option value="Non Akademik">Non Akademik</option>
            </select><br>
            <input type="date" name="tanggal_awal" class="form-control" required> Mulai<br>
            <input type="date" name="tanggal_akhir" class="form-control" required> Akhir<br>
            <div id="foto-container">
                <label>Foto 1</label><br>
                <input type="file" name="foto_1" accept="image/*" class="form-control"><br>
            </div>
            <button type="button" id="tambah-foto" class="btn btn-secondary">Tambah Foto</button><br>
            <input type="url" name="link_laporan" placeholder="Link Laporan" class="form-control" required><br>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
        </form>

        <br><br><h2><i class="fas fa-list"></i> Daftar Kegiatan</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Lingkup</th>
                    <th>Jenis Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Link Laporan</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['judul'] ?></td>
                        <td><?= $row['deskripsi'] ?></td>
                        <td><?= $row['lingkup'] ?></td>
                        <td><?= $row['jenis_kegiatan'] ?></td>
                        <td><?= $row['tanggal_awal'] ?> - <?= $row['tanggal_akhir'] ?></td>
                        <td><a href="<?= $row['link_laporan'] ?>" target="_blank" class="btn btn-link">Lihat Laporan</a></td>
                        <td>
                            <?php $foto_array = json_decode($row['foto'], true); ?>
                            <?php foreach ($foto_array as $foto): ?>
                                <img src="<?= $foto ?>" width="50" class="img-thumbnail"><br>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                            <a href="update_kegiatan.php?id=<?= $row['id'] ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <script>
            let fotoCount = 1; // Menghitung jumlah foto yang sudah ada

            document.getElementById('tambah-foto').addEventListener('click', function() {
                // Menambahkan input foto baru
                fotoCount++;
                var newFotoInput = document.createElement('div');
                newFotoInput.innerHTML = `
                    <label>Foto ${fotoCount}</label><br>
                    <input type="file" name="foto_${fotoCount}" accept="image/*" class="form-control"><br>
                `;
                document.getElementById('foto-container').appendChild(newFotoInput);
            });
        </script>
</body>
</html>

