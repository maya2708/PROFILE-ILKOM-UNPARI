<?php
session_start();
session_unset();
session_destroy();

// Alihkan pengguna kembali ke halaman index.html
header("Location: index.html");
exit;
?>
