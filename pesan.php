<?php
session_start();
require 'connect.php';

// Cek login
if (!isset($_SESSION['id_user'])) {
  header("Location: login.php");
  exit;
}

// Pastikan ada id paket di URL
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

$id_paket = intval($_GET['id']);
$id_user = $_SESSION['id_user'];
$tanggal_pesan = date('Y-m-d');

// Ambil data paket
$q = mysqli_query($conn, "SELECT * FROM tb_paket WHERE id_paket = '$id_paket'");
$paket = mysqli_fetch_assoc($q);

// Jika form dikirim
if (isset($_POST['pesan'])) {
  $tanggal_berangkat = $_POST['tanggal_berangkat'];
  $jumlah_orang = intval($_POST['jumlah_orang']);
  $total_harga = $jumlah_orang * $paket['harga'];

  $insert = mysqli_query($conn, "
    INSERT INTO tb_pemesanan (id_user, id_paket, tanggal_pesan, tanggal_berangkat, jumlah_orang, total_harga)
    VALUES ('$id_user', '$id_paket', '$tanggal_pesan', '$tanggal_berangkat', '$jumlah_orang', '$total_harga')
  ");

  if ($insert) {
    echo "<script>alert('Pemesanan berhasil!'); window.location='riwayat.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat memesan.');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesan Paket | WisataKu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🌴 WisataKu</a>
    <div>
      <a href="riwayat.php" class="btn btn-light btn-sm me-2">Riwayat</a>
      <span class="text-white me-3">Halo, <?= htmlspecialchars($_SESSION['nama']); ?>!</span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h3 class="text-primary text-center mb-4">Form Pemesanan Paket Wisata</h3>
  <div class="card shadow-sm p-4">
    <h4><?= htmlspecialchars($paket['nama_paket']); ?></h4>
    <p>Harga per orang: <strong>Rp <?= number_format($paket['harga'], 0, ',', '.'); ?></strong></p>
    <hr>

    <form method="POST">
      <div class="mb-3">
        <label for="tanggal_berangkat" class="form-label">Tanggal Berangkat</label>
        <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
        <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control" min="1" required>
      </div>
      <button type="submit" name="pesan" class="btn btn-success w-100">Pesan Sekarang</button>
    </form>
  </div>
</div>

<footer class="text-center py-3 mt-4 bg-light border-top">
  <small>© <?= date('Y'); ?> WisataKu. Semua Hak Dilindungi.</small>
</footer>

</body>
</html>
