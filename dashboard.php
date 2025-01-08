<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Pengaturan karakter dan tampilan -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Publikasi</title>
    
    <!-- Menggunakan Bootstrap untuk gaya responsif -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menggunakan Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* CSS untuk sidebar navigasi */
        .sidebar {
            height: 100vh; /* Tinggi penuh layar */
            width: 240px; /* Lebar sidebar */
            position: fixed; /* Tetap di posisi layar */
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #007bff, #0056b3); /* Gradien biru */
            color: white; /* Teks putih */
            padding: 20px;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.15); /* Bayangan */
            border-radius: 15px 0 0 15px; /* Sudut melengkung */
        }

        .sidebar h2 {
            font-size: 1.8rem;
            margin-bottom: 30px;
            text-align: center; /* Teks di tengah */
            font-weight: bold;
            color: #ffcc00; /* Warna kuning untuk judul */
        }

        /* Gaya untuk tautan dalam sidebar */
        .sidebar a {
            color: white; /* Teks putih */
            text-decoration: none; /* Hilangkan garis bawah */
            display: flex;
            align-items: center; /* Ikon sejajar dengan teks */
            gap: 10px; /* Jarak antara ikon dan teks */
            margin: 15px 0; /* Jarak antar item */
            padding: 12px 15px; /* Padding tautan */
            border-radius: 10px; /* Sudut melengkung */
            font-size: 16px;
            background: rgba(255, 255, 255, 0.1); /* Latar belakang transparan */
            transition: background 0.3s ease, transform 0.2s; /* Animasi transisi */
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.3); /* Latar belakang lebih terang */
            transform: scale(1.05); /* Efek zoom pada hover */
            box-shadow: 0 8px 15px rgba(0, 91, 187, 0.3); /* Bayangan biru */
        }

        /* Konten utama */
        .content {
            margin-left: 260px; /* Jarak dari sidebar */
            padding: 20px;
            background-color: #eef6fc; /* Latar belakang biru muda */
            min-height: 100vh; /* Tinggi minimal layar penuh */
        }

        .content h2 {
            color: #0056b3; /* Warna biru tua */
            font-size: 2.4rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
        }

        /* Tombol kustom */
        .btn-custom {
            background-color: #ff5722; /* Warna oranye */
            color: white;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #e64a19; /* Warna oranye lebih gelap */
            transform: scale(1.05); /* Zoom pada hover */
        }

        /* Tabel */
        .table th {
            background: #007bff; /* Latar belakang biru */
            color: white;
            font-weight: bold;
            padding: 15px;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #d6eaff; /* Baris ganjil biru muda */
        }

        .table tbody tr:hover {
            background-color: #b3daff; /* Baris lebih gelap saat hover */
            cursor: pointer; /* Ganti kursor menjadi tangan */
        }

        /* Bar pencarian */
        .search-bar {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .search-bar input {
            border-radius: 20px;
            padding: 10px 15px;
            border: 2px solid #007bff; /* Garis biru */
            flex-grow: 1;
        }

        .search-bar button {
            background-color: #0056b3; /* Tombol biru */
            color: white;
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .search-bar button:hover {
            background-color: #003d80; /* Tombol biru lebih gelap */
        }
    </style>
</head>
<body>

<!-- Sidebar navigasi -->
<div class="sidebar">
    <h2>Navigasi</h2>
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a> <!-- Link ke dashboard -->
    <a href="kelola_kerjasama.php"><i class="fas fa-handshake"></i> Kelola Kerjasama</a> <!-- Link ke Kelola Kerjasama -->
    <a href="kelola_publikasi.php"><i class="fas fa-book"></i> Kelola Publikasi</a> <!-- Link ke Kelola Publikasi -->
    <a href="kelola_prestasi.php"><i class="fas fa-trophy"></i> Kelola Prestasi</a> <!-- Link ke Kelola Prestasi -->
    <a href="kelola_kegiatan.php"><i class="fas fa-calendar"></i> Kelola Kegiatan</a> <!-- Link ke Kelola Kegiatan -->
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a> <!-- Link logout -->
</div>

<!-- Konten utama -->
<div class="content">
    <h2>Dashboard KELOMPOK 1</h2> <!-- Judul halaman -->
</div>

</body>
</html>
