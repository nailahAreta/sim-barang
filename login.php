<?php
session_start();

$pesan_error = "";

// Tangkap input jika tombol login diklik
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Akun statis untuk pengujian
    if ($username === "admin" && $password === "password123") {
        $_SESSION['login'] = true;
        $_SESSION['user'] = $username;
        
        // Arahkan ke halaman utama
        header("Location: index.php");
        exit;
    } else {
        $pesan_error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>SIM-Barang</h1>
        <p>Sistem Pengelolaan Inventaris Barang Jurusan</p>
    </header>

    <main>
        <section style="max-width: 450px; margin: 40px auto;">
            <h2>Halaman Login</h2>

            <?php if ($pesan_error != ""): ?>
                <div class="pesan-error"><?= $pesan_error; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>

                <button type="submit">Login</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIM-Barang - Sistem Pengelolaan Inventaris Barang Jurusan</p>
    </footer>

</body>
</html>