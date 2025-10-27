<?php
session_start();
require 'connect.php';

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE email='$email'");
  $row = mysqli_fetch_assoc($result);

  if ($row && password_verify($password, $row['password'])) {
    $_SESSION['id_user'] = $row['id_user'];
    $_SESSION['nama'] = $row['nama'];
    $_SESSION['role'] = $row['role'];

    if ($row['role'] == 'admin') {
      header("Location: admin/dashboard.php");
    } else {
      header("Location: index.php");
    }
    exit;
  } else {
    $error = "Email atau password salah!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Wisata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
          <h4 class="text-center mb-3">Login Akun</h4>
          <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
          <form method="POST">
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            <p class="text-center mt-3">Belum punya akun? <a href="register.php">Daftar</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>