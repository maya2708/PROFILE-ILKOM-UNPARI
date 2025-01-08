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

// Handle Create Operation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $judul = $_POST['judul'];
    $penulis = implode(", ", $_POST['penulis']);  // Collecting multiple authors
    $nama_jurnal = $_POST['nama_jurnal'];
    $level_jurnal = $_POST['level_jurnal'];
    $tanggal_terbit = $_POST['tanggal_terbit'];
    $volume_jurnal = $_POST['volume_jurnal'];
    $edisi_jurnal = $_POST['edisi_jurnal'];
    $halaman = $_POST['halaman'];
    $link_jurnal = $_POST['link_jurnal'];

    $stmt = $conn->prepare("INSERT INTO publikasi (judul, penulis, nama_jurnal, level_jurnal, tanggal_terbit, volume_jurnal, edisi_jurnal, halaman, link_jurnal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $judul, $penulis, $nama_jurnal, $level_jurnal, $tanggal_terbit, $volume_jurnal, $edisi_jurnal, $halaman, $link_jurnal);
    $stmt->execute();
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
    <title>Kelola Publikasi</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
    /* General Styles */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 20px;
    }

    h1, h2 {
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
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

    /* Form Styles */
    .form-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 40px;
        border: 1px solid #ddd;
    }

    .form-container label {
        font-weight: 500;
        color: #555;
        margin-bottom: 5px;
    }

    .form-container input, .form-container select, .form-container button {
        width: 100%;
        padding: 12px;
        margin: 10px 0 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    .form-container input:focus, .form-container select:focus, .form-container button:focus {
        outline: none;
        border-color: #007bff;
    }

    .penulis-container {
        margin-top: 15px;
    }

    .penulis-input {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .penulis-input input {
        width: 85%;
        margin-right: 10px;
        padding: 10px;
    }

    .penulis-input button {
        padding: 8px 16px;
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .penulis-input button:hover {
        background-color: #218838;
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 40px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 15px;
        text-align: left;
        font-size: 16px;
        border-bottom: 1px solid #ddd;
    }
    th i {
        margin-right: 10px; /* Adding space between icon and text */
    }

    th {
        background-color: #f4f4f4;
        font-weight: 700;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    .actions a {
        color: #007bff;
        text-decoration: none;
        margin-right: 10px;
        font-size: 16px;
    }

    .actions a:hover {
        text-decoration: underline;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .btn-back {
            font-size: 14px;
            padding: 10px 18px;
        }

        .form-container {
            padding: 20px;
        }

        table {
            font-size: 14px;
        }

        th, td {
            padding: 10px;
        }
    }
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4); /* Black background with opacity */
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 400px;
        border-radius: 8px;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 15px;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    button {
        padding: 10px 20px;
        border-radius: 5px;
        margin: 5px;
        font-size: 16px;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>

</head>
<body>

    <div class="container">
        <h1><i class="fas fa-newspaper"></i> Kelola Publikasi</h1><br>
        
        <!-- Back Button -->
        <a href="dashboard.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <!-- Form to Add Publication -->
        <div class="form-container">
            <h2>Tambah Publikasi</h2>
            <form method="POST">
                <label for="judul">Judul:</label>
                <input type="text" name="judul" required>

                <div class="penulis-container">
                    <label for="penulis">Penulis:</label>
                    <div id="penulis-fields">
                        <div class="penulis-input">
                            <input type="text" name="penulis[]" placeholder="Penulis 1" required>
                            <button type="button" onclick="addPenulis()">+</button>
                        </div>
                    </div>
                </div>

                <label for="nama_jurnal">Nama Jurnal:</label>
                <input type="text" name="nama_jurnal" required>

                <label for="level_jurnal">Level Jurnal:</label>
                <select name="level_jurnal" required>
                    <option value="Terakreditasi Nasional">Terakreditasi Nasional</option>
                    <option value="Sinta 1">Sinta 1</option>
                    <option value="Sinta 2">Sinta 2</option>
                    <option value="Sinta 3">Sinta 3</option>
                    <option value="Sinta 4">Sinta 4</option>
                    <option value="Sinta 5">Sinta 5</option>
                    <option value="Sinta 6">Sinta 6</option>
                    <option value="Terakreditasi Internasional">Terakreditasi Internasional</option>
                    <option value="Q1">Q1</option>
                    <option value="Q2">Q2</option>
                    <option value="Q3">Q3</option>
                    <option value="Q4">Q4</option>
                    <option value="Scopus">Scopus</option>
                </select>

                <label for="tanggal_terbit">Tanggal Terbit:</label>
                <input type="date" name="tanggal_terbit" required>

                <label for="volume_jurnal">Volume:</label>
                <input type="text" name="volume_jurnal" required>

                <label for="edisi_jurnal">Edisi:</label>
                <input type="text" name="edisi_jurnal" required>

                <label for="halaman">Halaman:</label>
                <input type="text" name="halaman" required>

                <label for="link_jurnal">Link Jurnal:</label>
                <input type="url" name="link_jurnal" required>

                <button type="submit" name="create">Simpan</button>
            </form>
        </div>

        <!-- Table of Publications -->
        <table>
            <thead>
                <tr>
                    <th><i class="fas fa-book"></i>Judul</th>
                    <th><i class="fas fa-user"></i>Penulis</th>
                    <th><i class="fas fa-journal-whills"></i>Nama Jurnal</th>
                    <th><i class="fas fa-arrow-up"></i>Level Jurnal</th>
                    <th><i class="fas fa-calendar-alt"></i>Tanggal Terbit</th>
                    <th><i class="fas fa-sort-numeric-up"></i>Volume</th>
                    <th><i class="fas fa-bookmark"></i>Edisi</th>
                    <th><i class="fas fa-file-alt"></i>Halaman</th>
                    <th><i class="fas fa-link"></i>Link</th>
                    <th><i class="fas fa-cogs"></i>Aksi</th>
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
                        <td><a href="<?php echo $item['link_jurnal']; ?>" target="_blank">Lihat</a></td>
                        <td class="actions">
                            <!-- Edit Icon -->
                            <a href="update_publikasi.php?id=<?php echo $item['id']; ?>">
                                <i class="fas fa-edit" style="color: #007bff;"></i>
                            </a> |
                            
                            <!-- Delete Icon with Modal Trigger -->
                            <a href="#" onclick="showDeleteModal(<?php echo $item['id']; ?>)">
                                <i class="fas fa-trash-alt" style="color: #dc3545;"></i>
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h2>Apakah Anda yakin ingin menghapus data ini?</h2>
            <button id="confirmDeleteBtn" class="btn btn-danger">Ya</button>
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
        </div>
    </div>


    <script>
        function addPenulis() {
            var penulisFields = document.getElementById('penulis-fields');
            var index = penulisFields.getElementsByClassName('penulis-input').length + 1;
            var newPenulisInput = document.createElement('div');
            newPenulisInput.classList.add('penulis-input');
            newPenulisInput.innerHTML = '<input type="text" name="penulis[]" placeholder="Penulis ' + index + '" required><button type="button" onclick="removePenulis(this)">-</button>';
            penulisFields.appendChild(newPenulisInput);
        }

        function removePenulis(button) {
            var penulisInput = button.parentElement;
            penulisInput.remove();
        }

        let deleteItemId = null;

        // Show modal and set the item ID to delete
        function showDeleteModal(itemId) {
            deleteItemId = itemId;
            document.getElementById('deleteModal').style.display = "block";
        }

        // Close the modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = "none";
            deleteItemId = null; // Reset item ID after closing modal
        }

        // Handle the delete action when 'Ya' is clicked
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteItemId !== null) {
                // Redirect to delete URL with the item ID (or use AJAX for better UX)
                window.location.href = "delete_publikasi.php?id=" + deleteItemId;
            }
        });
    </script>
</body>
</html>
