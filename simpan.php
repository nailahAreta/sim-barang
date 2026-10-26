<?php
session_start();

// 1. Cek Proteksi Login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// 2. Panggil Koneksi Database
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $kode        = htmlspecialchars($_POST["kode"] ?? '');
    $nama        = htmlspecialchars($_POST["nama"] ?? '');
    $nama_kategori = htmlspecialchars($_POST["kategori"] ?? '');
    $jumlah      = (int)($_POST["jumlah"] ?? 0);
    $harga       = (float)($_POST["harga"] ?? 0);
    $kondisi     = htmlspecialchars($_POST["kondisi"] ?? '');

    // 3. Cari id_kategori dari database berdasarkan nama kategori yang dipilih
    $query_kat = "SELECT id_kategori FROM kategori WHERE nama_kategori = '$nama_kategori'";
    $res_kat   = mysqli_query($koneksi, $query_kat);
    $data_kat  = mysqli_fetch_assoc($res_kat);
    $id_kategori = $data_kat['id_kategori'] ?? 1;

    // 4. SIMPAN DATA KE DATABASE MYSQL (Perintah INSERT)
    $query_insert = "INSERT INTO barang (kode_barang, nama_barang, id_kategori, jumlah, harga_satuan, kondisi) 
                     VALUES ('$kode', '$nama', '$id_kategori', '$jumlah', '$harga', '$kondisi')";
    
    mysqli_query($koneksi, $query_insert);

    // 5. Perhitungan Total Nilai Aset
    function hitungNilaiAset($jumlah, $harga) {
        return $jumlah * $harga;
    }

    $total = hitungNilaiAset($jumlah, $harga);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Input Barang - SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>SIM-Barang</h1>
        <p>Sistem Pengelolaan Inventaris Barang Jurusan</p>
    </header>

    <nav>
        <a href="index.php">Beranda</a>
        <a href="index.php#tabelBarang">Data Barang</a>
        <a href="index.php#formBarang">Tambah Barang</a>
        <a href="logout.php">Logout</a>
    </nav>

    <main>
        <section>
            <h2>Ringkasan & Status Penyimpanan</h2>

            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>

            <p style="color: #166534; background-color: #dcfce7; padding: 10px; border-radius: 5px; font-weight: bold;">
                ✓ Data berhasil disimpan ke database MySQL!
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kode Barang</td>
                        <td><?= $kode ?></td>
                    </tr>
                    <tr>
                        <td>Nama Barang</td>
                        <td><?= $nama ?></td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td><?= $nama_kategori ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td><?= number_format($jumlah, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>Kondisi</td>
                        <td><?= $kondisi ?></td>
                    </tr>
                    <tr>
                        <td>Harga Satuan</td>
                        <td>Rp <?= number_format($harga, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Total Estimasi Nilai Aset</strong></td>
                        <td><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            </table>

            <a href="index.php" class="btn-kembali">&laquo; Kembali ke Form</a>

            <?php else: ?>

            <p>Belum ada data barang yang dikirim.</p>
            <a href="index.php" class="btn-kembali">&laquo; Kembali ke Form</a>

            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 SIM-Barang - Sistem Pengelolaan Inventaris Barang Jurusan</p>
    </footer>

</body>
</html>