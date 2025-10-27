<?php
session_start();
require 'connect.php';

if (isset($_POST['register'])) {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $no_hp = $_POST['no_hp'];

  $check = mysqli_query($conn, "SELECT * FROM tb_user WHERE email='$email'");
  if (mysqli_num_rows($check) > 0) {
    $error = "Email sudah digunakan!";
  } else {
    $query = "INSERT INTO tb_user (nama, email, password, no_hp, role) VALUES ('$nama', '$email', '$password', '$no_hp', 'user')";
    if (mysqli_query($conn, $query)) {
      header("Location: login.php");
      exit;
    } else {
      $error = "Pendaftaran gagal!";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - Wisata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
          <h4 class="text-center mb-3">Daftar Akun Baru</h4>
          <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
          <form method="POST">
            <div class="mb-3">
              <label>Nama Lengkap</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>No. HP</label>
              <input type="text" name="no_hp" class="form-control">
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-success w-100">Daftar</button>
            <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>