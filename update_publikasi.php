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

// Fetch publication data to edit
$publikasi_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM publikasi WHERE id = ?");
$stmt->bind_param('i', $publikasi_id);
$stmt->execute();
$result = $stmt->get_result();
$publikasi_item = $result->fetch_assoc();

// Handle Update Operation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $nama_jurnal = $_POST['nama_jurnal'];
    $level_jurnal = $_POST['level_jurnal'];
    $tanggal_terbit = $_POST['tanggal_terbit'];
    $volume_jurnal = $_POST['volume_jurnal'];
    $edisi_jurnal = $_POST['edisi_jurnal'];
    $halaman = $_POST['halaman'];
    $link_jurnal = $_POST['link_jurnal'];

    $stmt_update = $conn->prepare("UPDATE publikasi SET judul=?, nama_jurnal=?, level_jurnal=?, tanggal_terbit=?, volume_jurnal=?, edisi_jurnal=?, halaman=?, link_jurnal=? WHERE id=?");
    $stmt_update->bind_param("ssssssssi", $judul, $nama_jurnal, $level_jurnal, $tanggal_terbit, $volume_jurnal, $edisi_jurnal, $halaman, $link_jurnal, $publikasi_id);
    $stmt_update->execute();
    header('Location: kelola_publikasi.php');
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Publikasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: #4CAF50;
        }

        .form-label {
            font-weight: bold;
            color: #555;
        }

        .form-control {
            border-radius: 8px;
            box-shadow: none;
            border: 1px solid #ccc;
        }

        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        .form-select {
            border-radius: 8px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-check {
            margin-top: 10px;
        }

        .select-container {
            margin-top: 20px;
        }

        .select-container select {
            width: 100%;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-row .col-6 {
            flex: 1;
        }

        .col-6 {
            margin-bottom: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .form-row .col-6 {
                flex: 1 0 100%;
            }
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

    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Publikasi</h1>
        <!-- Back Button -->
        <a href="kelola_publikasi.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a><br>
        <form method="POST">
            <div class="form-group">
                <label for="judul" class="form-label">Judul:</label>
                <input type="text" name="judul" value="<?php echo $publikasi_item['judul']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nama_jurnal" class="form-label">Nama Jurnal:</label>
                <input type="text" name="nama_jurnal" value="<?php echo $publikasi_item['nama_jurnal']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="level_jurnal" class="form-label">Level Jurnal:</label>
                <select name="level_jurnal" class="form-select" required>
                    <option value="NASIONAL" <?php echo ($publikasi_item['level_jurnal'] == 'NASIONAL') ? 'selected' : ''; ?>>NASIONAL</option>
                    <option value="SINTA 1" <?php echo ($publikasi_item['level_jurnal'] == 'SINTA 1') ? 'selected' : ''; ?>>SINTA 1</option>
                    <option value="SINTA 2" <?php echo ($publikasi_item['level_jurnal'] == 'SINTA 2') ? 'selected' : ''; ?>>SINTA 2</option>
                    <option value="SINTA 3" <?php echo ($publikasi_item['level_jurnal'] == 'SINTA 3') ? 'selected' : ''; ?>>SINTA 3</option>
                    <option value="SINTA 4" <?php echo ($publikasi_item['level_jurnal'] == 'SINTA 4') ? 'selected' : ''; ?>>SINTA 4</option>
                    <option value="SINTA 5" <?php echo ($publikasi_item['level_jurnal'] == 'SINTA 5') ? 'selected' : ''; ?>>SINTA 5</option>
                    <option value="SINTA 6" <?php echo ($publikasi_item['level_jurnal'] == 'SINTA 6') ? 'selected' : ''; ?>>SINTA 6</option>
                    <option value="SCOPUS"  <?php echo ($publikasi_item['level_jurnal'] == 'SCOPUS') ? 'selected' : ''; ?>>SCOPUS</option>
                    <option value="International" <?php echo ($publikasi_item['level_jurnal'] == 'International') ? 'selected' : ''; ?>>International</option>
                    <option value="Q1" <?php echo ($publikasi_item['level_jurnal'] == 'Q1') ? 'selected' : ''; ?>>Q1</option>
                    <option value="Q2" <?php echo ($publikasi_item['level_jurnal'] == 'Q2') ? 'selected' : ''; ?>>Q2</option>
                    <option value="Q3" <?php echo ($publikasi_item['level_jurnal'] == 'Q3') ? 'selected' : ''; ?>>Q3</option>
                    <option value="Q4" <?php echo ($publikasi_item['level_jurnal'] == 'Q4') ? 'selected' : ''; ?>>Q4</option>
                </select>
            </div>

            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="tanggal_terbit" class="form-label">Tanggal Terbit:</label>
                        <input type="date" name="tanggal_terbit" value="<?php echo $publikasi_item['tanggal_terbit']; ?>" class="form-control" required>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="volume_jurnal" class="form-label">Volume:</label>
                        <input type="text" name="volume_jurnal" value="<?php echo $publikasi_item['volume_jurnal']; ?>" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="edisi_jurnal" class="form-label">Edisi:</label>
                        <input type="text" name="edisi_jurnal" value="<?php echo $publikasi_item['edisi_jurnal']; ?>" class="form-control" required>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="halaman" class="form-label">Halaman:</label>
                        <input type="text" name="halaman" value="<?php echo $publikasi_item['halaman']; ?>" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="link_jurnal" class="form-label">Link Jurnal:</label>
                <input type="url" name="link_jurnal" value="<?php echo $publikasi_item['link_jurnal']; ?>" class="form-control" required>
            </div>

            <button type="submit" name="update" class="btn btn-success">Update</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
