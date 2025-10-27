<?php
session_start();
require 'connect.php';

// Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['id_user'])) {
  header("Location: login.php");
  exit;
}

// Ambil semua paket wisata
$paket = mysqli_query($conn, "SELECT * FROM tb_paket ORDER BY id_paket DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Paket Wisata | WisataKu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card img {
      height: 200px;
      object-fit: cover;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
    .card {
      border-radius: 10px;
      transition: transform 0.2s;
    }
    .card:hover {
      transform: scale(1.03);
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
  <h3 class="mb-4 text-center fw-bold text-primary">🧭 Pilihan Paket Wisata Populer</h3>

  <div class="row">
    <?php if (mysqli_num_rows($paket) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($paket)) { ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm h-100">
            <img src="uploads/<?= htmlspecialchars($row['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_paket']); ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-primary"><?= htmlspecialchars($row['nama_paket']); ?></h5>
              <p class="card-text flex-grow-1"><?= nl2br(substr($row['deskripsi'], 0, 100)); ?>...</p>
              <p class="fw-bold text-success mb-2">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
              <a href="paket_detail.php?id=<?= $row['id_paket']; ?>" class="btn btn-primary btn-sm w-100 mt-auto">Lihat Detail</a>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php else: ?>
      <div class="col-12 text-center text-muted">
        <p>Belum ada paket wisata yang tersedia.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<footer class="text-center py-3 mt-4 bg-light border-top">
  <small>© <?= date('Y'); ?> WisataKu. Semua Hak Dilindungi.</small>
</footer>

</body>
</html>
