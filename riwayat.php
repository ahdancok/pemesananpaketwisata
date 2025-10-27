<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['id_user'])) {
  header("Location: login.php");
  exit;
}

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "
  SELECT p.*, pk.nama_paket, pk.foto, pk.harga
  FROM tb_pemesanan p
  JOIN tb_paket pk ON p.id_paket = pk.id_paket
  WHERE p.id_user = '$id_user'
  ORDER BY p.tanggal_pesan DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pemesanan | WisataKu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🌴 WisataKu</a>
    <div>
      <span class="text-white me-3">Halo, <?= htmlspecialchars($_SESSION['nama']); ?>!</span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h3 class="text-primary mb-3 text-center">🧳 Riwayat Pemesanan Saya</h3>
  <a href="index.php" class="btn btn-secondary mb-3">← Kembali</a>
  
  <?php if (mysqli_num_rows($query) > 0): ?>
    <div class="row">
      <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="uploads/<?= htmlspecialchars($row['foto']); ?>" class="img-fluid rounded-start" alt="<?= htmlspecialchars($row['nama_paket']); ?>">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($row['nama_paket']); ?></h5>
                  <p><small>Tgl Pesan: <?= date('d M Y', strtotime($row['tanggal_pesan'])); ?></small></p>
                  <p><small>Tgl Berangkat: <?= date('d M Y', strtotime($row['tanggal_berangkat'])); ?></small></p>
                  <p><small>Jumlah Orang: <?= $row['jumlah_orang']; ?></small></p>
                  <p><strong>Total:</strong> Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></p>
                  <a href="riwayat_detail.php?id=<?= $row['id_pemesanan']; ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center mt-4">Belum ada pemesanan yang kamu buat.</div>
  <?php endif; ?>
</div>

</body>
</html>
