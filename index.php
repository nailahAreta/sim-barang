<?php
session_start();

// 1. Proteksi Sesi Login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// 2. Hubungkan ke Database MySQL
require_once 'koneksi.php';

// 3. Ambil Data Barang dan Kategori dari Database (JOIN)
$query = "SELECT barang.*, kategori.nama_kategori 
          FROM barang 
          JOIN kategori ON barang.id_kategori = kategori.id_kategori 
          ORDER BY barang.id_barang DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- ================= HEADER ================= -->
    <header>
        <h1>SIM-Barang</h1>
        <p>Sistem Pengelolaan Inventaris Barang Jurusan</p>
    </header>

    <!-- ================= NAVIGASI ================= -->
    <nav>
        <a href="index.php">Beranda</a>
        <a href="#tabelBarang">Data Barang</a>
        <a href="#formBarang">Tambah Barang</a>
        <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Logout</a>
    </nav>

    <!-- ================= KONTEN UTAMA ================= -->
    <main>

        <section>

            <h2>Data Inventaris Barang</h2>

            <input
                type="text"
                id="cariBarang"
                placeholder="Cari kode atau nama barang..."
            >

            <!-- ================= TABEL INVENTARIS DINAMIS ================= -->
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>

                <tbody id="tabelBarang">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['kode_barang']); ?></td>
                                <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                                <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                                <td><?= number_format($row['jumlah'], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($row['kondisi']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Belum ada data barang di database.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- ================= FORM TAMBAH BARANG ================= -->
            <h2 id="formBarang">Tambah Barang</h2>

            <form id="formBarang" action="simpan.php" method="POST">

                <label for="kode">Kode Barang:</label>
                <input
                    type="text"
                    id="kode"
                    name="kode"
                    placeholder="Contoh: BRG-002"
                    required
                >

                <label for="nama">Nama Barang:</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    placeholder="Masukkan nama barang"
                    required
                >

                <label for="kategori">Kategori:</label>
                <select id="kategori" name="kategori" required>
                    <option value="">Pilih kategori</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Furniture">Furniture</option>
                    <option value="ATK">ATK</option>
                </select>

                <label for="jumlah">Jumlah:</label>
                <input
                    type="number"
                    id="jumlah"
                    name="jumlah"
                    placeholder="Masukkan jumlah"
                    required
                >

                <label for="harga">Harga Satuan (Rp):</label>
                <input
                    type="number"
                    id="harga"
                    name="harga"
                    placeholder="Masukkan harga satuan"
                    required
                >

                <label for="kondisi">Kondisi:</label>
                <select id="kondisi" name="kondisi" required>
                    <option value="">Pilih kondisi</option>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>

                <button type="submit">Tambah Barang</button>

            </form>

        </section>

    </main>

    <!-- ================= FOOTER ================= -->
    <footer>
        <p>&copy; 2026 SIM-Barang - Sistem Pengelolaan Inventaris Barang Jurusan</p>
    </footer>

    <script src="main.js"></script>

</body>
</html>