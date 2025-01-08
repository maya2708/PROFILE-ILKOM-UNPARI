<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'db_ilkom'; // Ganti dengan nama database Anda
$username = 'root';   // Ganti dengan username database Anda
$password = '';   // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}

// Fungsi untuk menyimpan data kerjasama
function simpanKerjasama($pdo, $nama, $level, $jenis, $pihak1, $pihak2, $tgl, $durasi, $link) {
    $sql = "INSERT INTO kerjasama (nama, level, jenis, pihak1, pihak2, tgl, durasi, link) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama, $level, $jenis, $pihak1, $pihak2, $tgl, $durasi, $link]);
}

// Proses Simpan Data Kerjasama
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $level = $_POST['level'];
    $jenis = $_POST['jenis'];
    $pihak1 = $_POST['pihak1'];
    $pihak2 = $_POST['pihak2'];
    $tgl = $_POST['tgl'];
    $durasi = $_POST['durasi'];
    $link = $_POST['link'];

    simpanKerjasama($pdo, $nama, $level, $jenis, $pihak1, $pihak2, $tgl, $durasi, $link);
}

// Fungsi untuk mengambil data kerjasama
function getKerjasama($pdo) {
    $sql = "SELECT * FROM kerjasama";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ambil data kerjasama
$kerjasamaList = getKerjasama($pdo);
?>

<!-- Link CDN FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Tabel Daftar Kerjasama -->
<h2 class="text-center text-primary mt-5">Daftar Kerjasama</h2>
<table class="table table-striped table-hover mt-2">
    <thead class="thead-dark">
        <tr>
            <th><i class="fas fa-handshake"></i> Nama Kerjasama</th>
            <th><i class="fas fa-trophy"></i> Level Kerjasama</th>
            <th><i class="fas fa-sitemap"></i> Jenis Kerjasama</th>
            <th><i class="fas fa-building"></i> Pihak 1</th>
            <th><i class="fas fa-building"></i> Pihak 2</th>
            <th><i class="fas fa-calendar-alt"></i> Tanggal MoU</th>
            <th><i class="fas fa-clock"></i> Durasi Kerjasama</th>
            <th><i class="fas fa-link"></i> Link Bukti MoU</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($kerjasamaList as $kerjasama): ?>
            <tr>
                <td><?php echo $kerjasama['nama']; ?></td>
                <td><?php echo $kerjasama['level']; ?></td>
                <td><?php echo $kerjasama['jenis']; ?></td>
                <td><?php echo $kerjasama['pihak1']; ?></td>
                <td><?php echo $kerjasama['pihak2']; ?></td>
                <td><?php echo $kerjasama['tgl']; ?></td>
                <td><?php echo $kerjasama['durasi']; ?></td>
                <td>
                    <a href="<?php echo $kerjasama['link']; ?>" target="_blank">
                        <i class="fas fa-external-link-alt text-success"></i> Link Bukti MoU
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Custom CSS -->
<style>
    /* Table Styling */
    table {
        background: linear-gradient(to right, #007bff, #00aaff);
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
    }
    th {
        background-color: #004f99;
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
    }
    td {
        background-color: #ffffff;
        color: #333;
        font-size: 14px;
    }
    tbody tr:hover {
        background-color: #e6f7ff;
        transition: background-color 0.3s ease;
    }

    /* Icon Style */
    .fas {
        margin-right: 8px;
        font-size: 1.1rem;
        color: #004f99;
    }

    /* Link Style */
    td a {
        color: #007bff;
        font-weight: bold;
        text-decoration: none;
    }
    td a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    /* Responsive Table Design */
    @media (max-width: 768px) {
        table {
            font-size: 12px;
        }
        th, td {
            padding: 8px;
        }
    }
</style>
