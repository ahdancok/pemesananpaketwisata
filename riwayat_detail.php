<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['id_user'])) {
  header("Location: login.php");
  exit;
}

$id_pemesanan = intval($_GET['id']);
$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "
  SELECT p.*, pk.nama_paket, pk.destinasi, pk.durasi, pk.foto, pk.harga
  FROM tb_pemesanan p
  JOIN tb_paket pk ON p.id_paket = pk.id_paket
  WHERE p.id_pemesanan = '$id_pemesanan' AND p.id_user = '$id_user'
");
$data = mysqli_fetch_assoc($query);

if (!$data) {
  echo "<script>alert('Data pemesanan tidak ditemukan!'); window.location='riwayat.php';</script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pemesanan | WisataKu</title>
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

<div class="container mt-4">
  <a href="riwayat.php" class="btn btn-secondary mb-3">← Kembali</a>
  <div class="card shadow-sm p-4">
    <div class="row">
      <div class="col-md-5">
        <img src="uploads/<?= htmlspecialchars($data['foto']); ?>" alt="<?= htmlspecialchars($data['nama_paket']); ?>" class="img-fluid rounded">
      </div>
      <div class="col-md-7">
        <h3 class="fw-bold text-primary mb-3"><?= htmlspecialchars($data['nama_paket']); ?></h3>
        <p><strong>Destinasi:</strong> <?= htmlspecialchars($data['destinasi']); ?></p>
        <p><strong>Durasi:</strong> <?= htmlspecialchars($data['durasi']); ?></p>
        <p><strong>Harga per orang:</strong> Rp <?= number_format($data['harga'], 0, ',', '.'); ?></p>
        <hr>
        <p><strong>Tanggal Pesan:</strong> <?= date('d M Y', strtotime($data['tanggal_pesan'])); ?></p>
        <p><strong>Tanggal Berangkat:</strong> <?= date('d M Y', strtotime($data['tanggal_berangkat'])); ?></p>
        <p><strong>Jumlah Orang:</strong> <?= $data['jumlah_orang']; ?></p>
        <p><strong>Total Harga:</strong> Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></p>
      </div>
    </div>
  </div>
</div>

</body>
</html>
