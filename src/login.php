<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip = $_POST['nip'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM pegawai WHERE nip = ?");
    $stmt->bind_param("s", $nip);
    $stmt->execute();
    $result = $stmt->get_result();
    $pegawai = $result->fetch_assoc();

    if ($pegawai && $password === $pegawai['password']) { // gunakan password_verify() jika hashed
        $_SESSION['nip'] = $pegawai['nip'];
        $_SESSION['nama'] = $pegawai['nama'];
        header("Location: ajukanperjalanan.php");
        exit;
    } else {
        $error = "NIP atau Password salah!";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Pemesanan Tiket Dinas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle, #5d6eff, #2c2f9e);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-box {
            background-color: #f4f4ff;
            padding: 30px;
            border-radius: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0px 0px 25px rgba(0,0,0,0.15);
        }
        .login-box h4 {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-login {
            background-color: #3853ff;
            color: white;
            font-weight: 500;
        }
        .btn-login:hover {
            background-color: #2c42d9;
        }
        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 12px;
            font-size: 14px;
        }
        .forgot-link a {
            color: #2c42d9;
            text-decoration: none;
        }
        .forgot-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h4>Login</h4>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger py-2"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP Anda" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
        </div>
        <button type="submit" class="btn btn-login w-100">Masuk</button>
    </form>

   
</div>

</body>
</html>
