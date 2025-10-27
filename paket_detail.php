<?php
session_start();
require 'connect.php';

// Jika belum login
if (!isset($_SESSION['id_user'])) {
  header("Location: login.php");
  exit;
}

// Pastikan ada id paket di URL
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

$id = intval($_GET['id']);
$paket = mysqli_query($conn, "SELECT * FROM tb_paket WHERE id_paket = $id");
$data = mysqli_fetch_assoc($paket);

// Jika paket tidak ditemukan
if (!$data) {
  echo "<script>alert('Paket tidak ditemukan!'); window.location='index.php';</script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Paket Wisata | <?= htmlspecialchars($data['nama_paket']); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .detail-img {
      width: 100%;
      height: 350px;
      object-fit: cover;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
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

<!-- Konten -->
<div class="container mt-4">
  <a href="index.php" class="btn btn-secondary mb-3">← Kembali</a>

  <div class="card shadow-sm p-4">
    <div class="row">
      <div class="col-md-6">
        <img src="uploads/<?= htmlspecialchars($data['foto']); ?>" alt="<?= htmlspecialchars($data['nama_paket']); ?>" class="detail-img">
      </div>
      <div class="col-md-6">
        <h3 class="fw-bold text-primary"><?= htmlspecialchars($data['nama_paket']); ?></h3>
        <p><strong>Destinasi:</strong> <?= htmlspecialchars($data['destinasi']); ?></p>
        <p><strong>Durasi:</strong> <?= htmlspecialchars($data['durasi']); ?></p>
        <p><strong>Harga:</strong> <span class="text-success fw-bold">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></span> /orang</p>
        <p><strong>Fasilitas:</strong><br><?= nl2br(htmlspecialchars($data['fasilitas'])); ?></p>
        <hr>
        <h5>Deskripsi:</h5>
        <p><?= nl2br(htmlspecialchars($data['deskripsi'])); ?></p>

        <a href="pesan.php?id=<?= $data['id_paket']; ?>" class="btn btn-success mt-3 w-100">Pesan Sekarang</a>
      </div>
    </div>
  </div>
</div>

<footer class="text-center py-3 mt-4 bg-light border-top">
  <small>© <?= date('Y'); ?> WisataKu. Semua Hak Dilindungi.</small>
</footer>

</body>
</html>
