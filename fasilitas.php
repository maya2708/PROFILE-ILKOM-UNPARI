<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas</title>
    <!-- Link untuk ikon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Gaya untuk tampilan halaman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9; /* Warna latar belakang abu-abu terang */
            color: #333; /* Warna teks */
        }

        h1 {
            text-align: center; /* Judul di tengah halaman */
            margin-top: 20px;
            color: #007bff; /* Warna biru */
        }

        .container {
            max-width: 1200px; /* Lebar maksimum kontainer */
            margin: 20px auto;
            padding: 20px;
        }

        .fasilitas {
            display: flex; /* Mengatur layout menggunakan flexbox */
            align-items: center; /* Konten di tengah vertikal */
            margin-bottom: 50px;
            opacity: 0; /* Awal elemen tidak terlihat */
            transform: translateY(50px); /* Awal elemen bergeser ke bawah */
            transition: all 0.6s ease-in-out; /* Animasi smooth */
        }

        .fasilitas:nth-child(even) {
            flex-direction: row-reverse; /* Baris genap gambar di kanan */
        }

        .fasilitas img {
            max-width: 100%;
            width: 50%; /* Gambar mengambil setengah lebar */
            border-radius: 10px; /* Sudut gambar melengkung */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan gambar */
        }

        .fasilitas .description {
            width: 50%; /* Deskripsi mengambil setengah lebar */
            padding: 20px;
        }

        .fasilitas h2 {
            color: #007bff; /* Warna teks judul deskripsi */
            margin-bottom: 10px;
        }

        .fasilitas p {
            line-height: 1.6; /* Jarak antar baris */
        }

        .fasilitas.show {
            opacity: 1; /* Elemen terlihat */
            transform: translateY(0); /* Posisi elemen kembali normal */
        }
    </style>
</head>
<body>
    <h1>Fasilitas Kami</h1>
    <div class="container">
        <!-- Kontainer untuk daftar fasilitas -->
        <div class="fasilitas">
            <img src="assets/img/perpus.png" alt="Fasilitas 1">
            <div class="description">
                <h2>Fasilitas 1: Perpustakaan Modern</h2>
                <p>Perpustakaan dengan koleksi buku yang lengkap dan suasana nyaman untuk belajar. Dilengkapi dengan area baca yang modern.</p>
            </div>
        </div>

        <div class="fasilitas">
            <img src="assets/img/labjar.jpg" alt="Fasilitas 2">
            <div class="description">
                <h2>Fasilitas 2: Laboratorium Komputer</h2>
                <p>Laboratorium komputer dengan perangkat terbaru yang dapat digunakan untuk pengembangan keterampilan teknologi.</p>
            </div>
        </div>

        <div class="fasilitas">
            <img src="assets/img/images.jpg" alt="Fasilitas 3">
            <div class="description">
                <h2>Fasilitas 3: Aula Semimbar</h2>
                <p>Aula luas untuk mengadakan seminar, workshop, dan berbagai acara besar lainnya.</p>
            </div>
        </div>

        <div class="fasilitas">
            <img src="assets/img/unpari.jpg" alt="Fasilitas 4">
            <div class="description">
                <h2>Kampus: Universitas PGRI Silampari</h2>
                <p>Universitas PGRI Silampari, yang sebelumnya dikenal sebagai STKIP-PGRI Lubuklinggau, 
                    didirikan pada tahun 1987 dan berlokasi di Lubuklinggau, Sumatera Selatan. Kampus ini 
                    menawarkan berbagai program studi di bidang pendidikan dan memiliki fasilitas yang memadai
                     untuk mendukung proses belajar mengajar.</p>
            </div>
        </div>
    </div>

    <script>
        // Ambil semua elemen dengan kelas 'fasilitas'
        const fasilitasItems = document.querySelectorAll('.fasilitas');

        function checkScroll() {
            const triggerBottom = window.innerHeight * 0.8; // Titik di mana elemen mulai terlihat

            fasilitasItems.forEach(fasilitas => {
                const fasilitasTop = fasilitas.getBoundingClientRect().top; // Jarak elemen dari atas viewport

                if (fasilitasTop < triggerBottom) {
                    fasilitas.classList.add('show'); // Tambahkan kelas 'show' jika elemen sudah terlihat
                } else {
                    fasilitas.classList.remove('show'); // Hapus kelas 'show' jika elemen tidak terlihat
                }
            });
        }

        // Jalankan fungsi setiap kali pengguna scroll
        window.addEventListener('scroll', checkScroll);

        // Periksa posisi elemen saat halaman pertama kali dimuat
        checkScroll();
    </script>
</body>
</html>
