<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'db_ilkom');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data kegiatan berdasarkan ID
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID kegiatan tidak ditemukan.");
}

$result = $conn->query("SELECT * FROM kegiatan WHERE id = $id");
$kegiatan = $result->fetch_assoc();
if (!$kegiatan) {
    die("Kegiatan tidak ditemukan.");
}

// Fungsi untuk memperbarui kegiatan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $lingkup = $_POST['lingkup'];
    $jenis_kegiatan = $_POST['jenis_kegiatan'];
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $link_laporan = $_POST['link_laporan'];

    // Proses foto lama
    $foto_lama = json_decode($kegiatan['foto'], true) ?? [];
    $foto = [];
    $target_dir = "uploads/";

    // Jika ada foto lama yang harus dihapus
    if (isset($_POST['hapus_foto'])) {
        foreach ($_POST['hapus_foto'] as $hapus_foto) {
            if (file_exists($hapus_foto)) {
                unlink($hapus_foto);
            }
            $foto_lama = array_filter($foto_lama, fn($item) => $item !== $hapus_foto);
        }
    }

    // Proses upload foto baru
    for ($i = 1; $i <= 10; $i++) {
        if (!empty($_FILES["foto_$i"]["name"])) {
            $target_file = $target_dir . basename($_FILES["foto_$i"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["foto_$i"]["tmp_name"]);
            if ($check !== false && $_FILES["foto_$i"]["size"] <= 500000 && in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                move_uploaded_file($_FILES["foto_$i"]["tmp_name"], $target_file);
                $foto[] = $target_file;
            }
        }
    }

    // Gabungkan foto lama dan baru
    $foto = array_merge($foto_lama, $foto);
    $foto_json = json_encode($foto);

    // Update data ke database
    $sql = "UPDATE kegiatan SET 
                judul='$judul', 
                deskripsi='$deskripsi', 
                lingkup='$lingkup', 
                jenis_kegiatan='$jenis_kegiatan', 
                tanggal_awal='$tanggal_awal', 
                tanggal_akhir='$tanggal_akhir', 
                foto='$foto_json', 
                link_laporan='$link_laporan' 
            WHERE id=$id";
    $conn->query($sql);

    header("Location: kelola_kegiatan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Kegiatan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #4a90e2;
            margin-top: 30px;
            font-size: 36px;
        }

        form {
            width: 70%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        form input, form select, form textarea, form button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        form input[type="file"] {
            padding: 5px;
        }

        form button {
            background-color: #4a90e2;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #357ab7;
        }

        h3 {
            color: #4a90e2;
            font-size: 24px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        #foto-container {
            margin-bottom: 20px;
        }

        .foto-lama {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .foto-lama div {
            text-align: center;
        }

        .foto-lama img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            font-size: 16px;
        }

        select, input[type="date"], input[type="url"] {
            background-color: #f9f9f9;
        }

        button[type="button"] {
            background-color: #f4f4f4;
            color: #4a90e2;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        button[type="button"]:hover {
            background-color: #e0eaf0;
        }

        /* Hover Effect for Input fields */
        input:focus, select:focus, textarea:focus {
            border-color: #4a90e2;
            outline: none;
        }

        .container {
            margin-top: 30px;
            text-align: center;
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

</head>
<body>
    <h1>Update Kegiatan</h1>

    <form action="update_kegiatan.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <label for="judul">Judul Kegiatan:</label>
        <input type="text" name="judul" value="<?= $kegiatan['judul'] ?>" placeholder="Judul" required><br>

        <label for="deskripsi">Deskripsi Kegiatan:</label>
        <textarea name="deskripsi" placeholder="Deskripsi" required><?= $kegiatan['deskripsi'] ?></textarea><br>

        <label for="lingkup">Lingkup Kegiatan:</label>
        <select name="lingkup" required>
            <option value="">Pilih Lingkup</option>
            <option value="Nasional" <?= $kegiatan['lingkup'] === 'Nasional' ? 'selected' : '' ?>>Nasional</option>
            <option value="Internasional" <?= $kegiatan['lingkup'] === 'Internasional' ? 'selected' : '' ?>>Internasional</option>
            <option value="Lokal" <?= $kegiatan['lingkup'] === 'Lokal' ? 'selected' : '' ?>>Lokal</option>
        </select><br>

        <label for="jenis_kegiatan">Jenis Kegiatan:</label>
        <select name="jenis_kegiatan" required>
            <option value="">Pilih Jenis Kegiatan</option>
            <option value="Seminar" <?= $kegiatan['jenis_kegiatan'] === 'Seminar' ? 'selected' : '' ?>>Seminar</option>
            <option value="Workshop" <?= $kegiatan['jenis_kegiatan'] === 'Workshop' ? 'selected' : '' ?>>Workshop</option>
            <option value="Pelatihan" <?= $kegiatan['jenis_kegiatan'] === 'Pelatihan' ? 'selected' : '' ?>>Pelatihan</option>
            <option value="Akademik" <?= $kegiatan['jenis_kegiatan'] === 'Akademik' ? 'selected' : '' ?>>Akademik</option>
            <option value="Non Akademik" <?= $kegiatan['jenis_kegiatan'] === 'Non Akademik' ? 'selected' : '' ?>>Non Akademik</option>
        </select><br>

        <label for="tanggal_awal">Tanggal Awal:</label>
        <input type="date" name="tanggal_awal" value="<?= $kegiatan['tanggal_awal'] ?>" required><br>

        <label for="tanggal_akhir">Tanggal Akhir:</label>
        <input type="date" name="tanggal_akhir" value="<?= $kegiatan['tanggal_akhir'] ?>" required><br>

        <h3>Foto Lama</h3>
        <div class="foto-lama">
            <?php $foto_lama = json_decode($kegiatan['foto'], true) ?? []; ?>
            <?php foreach ($foto_lama as $foto): ?>
                <div>
                    <img src="<?= $foto ?>" alt="Foto Kegiatan">
                    <br>
                    <label>
                        <input type="checkbox" name="hapus_foto[]" value="<?= $foto ?>"> Hapus
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Tambah Foto Baru</h3>
        <div id="foto-container">
            <label>Foto 1</label><br>
            <input type="file" name="foto_1" accept="image/*"><br>
        </div>
        <button type="button" id="tambah-foto">Tambah Foto</button><br>

        <label for="link_laporan">Link Laporan:</label>
        <input type="url" name="link_laporan" value="<?= $kegiatan['link_laporan'] ?>" placeholder="Link Laporan" required><br>

        <button type="submit">Update</button>
    </form>

    <div class="container">
        <a href="kelola_kegiatan.php" class="back-btn">Kembali ke Daftar Kegiatan</a>
    </div>

    <script>
        let fotoCount = 1; // Menghitung jumlah foto yang sudah ada
        const maxFoto = 10; // Batas maksimum foto

        document.getElementById('tambah-foto').addEventListener('click', function () {
            if (fotoCount < maxFoto) {
                fotoCount++;
                const fotoContainer = document.getElementById('foto-container');
                const newFotoInput = document.createElement('div');
                newFotoInput.innerHTML = ` 
                    <label>Foto ${fotoCount}</label><br>
                    <input type="file" name="foto_${fotoCount}" accept="image/*"><br>
                `;
                fotoContainer.appendChild(newFotoInput);
            } else {
                alert('Maksimum jumlah foto yang diunggah adalah ' + maxFoto);
            }
        });
    </script>
</body>
</html>
