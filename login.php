<?php
session_start();

// Koneksi ke database
$host = "localhost";
$user = "root"; // Sesuaikan dengan user database
$password = ""; // Sesuaikan dengan password database
$database = "db_ilkom"; // Nama database

$koneksi = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Jika proses login
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query untuk cek username
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Ambil data user
            $row = $result->fetch_assoc();
            $db_password = $row['password'];

            // Verifikasi password tanpa hashing
            if ($password === $db_password) {
                $_SESSION['username'] = $username;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
        $stmt->close();
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('uploads/mhs.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .form-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .avatar {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #007BFF;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #007BFF;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group-text {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 8px 0 0 8px;
        }

        input.form-control {
            font-size: 16px;
            border-radius: 0 8px 8px 0;
            border: 1px solid #ddd;
        }

        button.btn {
            background: linear-gradient(90deg, #007BFF, #0056b3);
            border: none;
            padding: 12px;
            font-size: 18px;
            color: #fff;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        button.btn:hover {
            background: linear-gradient(90deg, #0056b3, #003d7a);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .alert {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <!-- Form Login -->
        <form action="login.php" method="POST">
            <fieldset>
                <img id="avatar" class="avatar" src="assets/img/avatar.png" alt="User Avatar">
                <h1>Login</h1>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input class="form-control" type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <?php if (isset($error) && $error): ?>
                    <div class="alert alert-danger mt-2"><?php echo $error; ?></div>
                <?php endif; ?>
                <button class="btn btn-primary d-block w-100" type="submit" name="login">LOGIN</button>
            </fieldset>
        </form>
    </div>

    <!-- Tambahkan jQuery dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
