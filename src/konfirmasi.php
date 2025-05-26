<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nip'])) {
    header("Location: login.php");
    exit;
}

$nip = $_SESSION['nip'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pertama kali datang dari ajukanperjalanan.php
    if (isset($_POST['kota_berangkat'])) {
        $kota_berangkat = $_POST['kota_berangkat'];
        $kota_tujuan = $_POST['kota_tujuan'];
        $tgl_berangkat = $_POST['tgl_berangkat'];
        $tgl_pulang = $_POST['tgl_pulang'];
        $jumlah_pegawai = $_POST['jumlah'];

        // Simpan ke tabel perjalanan
        $query = "INSERT INTO perjalanan (nip, kota_berangkat, kota_tujuan, tgl_berangkat, tgl_pulang, jumlah_pegawai)
                  VALUES ('$nip', '$kota_berangkat', '$kota_tujuan', '$tgl_berangkat', '$tgl_pulang', '$jumlah_pegawai')";
        mysqli_query($conn, $query);
        $id_perjalanan = mysqli_insert_id($conn);
        $_SESSION['id_perjalanan'] = $id_perjalanan;
    }

    // Jika user memilih penerbangan
    if (isset($_POST['pilih_penerbangan'])) {
        $maskapai = $_POST['maskapai'];
        $jam_keberangkatan = $_POST['jam_keberangkatan'];
        $harga = $_POST['harga'];
        $id_perjalanan = $_SESSION['id_perjalanan'];

        $update = "UPDATE perjalanan 
                   SET maskapai='$maskapai', waktu_keberangkatan='$jam_keberangkatan', harga='$harga'
                   WHERE id='$id_perjalanan'";
        mysqli_query($conn, $update);
        $sudah_pilih = true;
    }
}

$id_perjalanan = $_SESSION['id_perjalanan'] ?? null;

// Ambil data perjalanan (untuk ditampilkan kembali)
$data = mysqli_query($conn, "SELECT * FROM perjalanan WHERE id='$id_perjalanan'");
$row = mysqli_fetch_assoc($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Tiket Dinas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #dce5ff;
            padding: 20px;
        }
        .sidebar .nav-link.active {
            background-color: #aac7ff;
            color: #000;
        }
        .content-box {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-top: 20px;
            border: 1px solid #dcdcdc;
        }
        .step-box {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }
        .step-box div {
            text-align: center;
        }
        .step-box .active-step {
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .check-icon {
            font-size: 60px;
            color: #4caf50;
        }
        .status-box {
            background-color: #eef1ff;
            border-radius: 10px;
            padding: 20px;
        }
        .btn-dashboard {
            background-color: #aac7ff;
            color: #000;
            border: none;
        }
        .btn-dashboard:hover {
            background-color: #85b1ff;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <div class="text-center mb-4">
                <img src="logountan.png" width="150">
                <h6 class="fw-bold">Universitas<br>Tanjungpura</h6>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-home me-2"></i>Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link active"><i class="fas fa-plane me-2"></i>Ajukan Perjalanan Dinas</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-clock-rotate-left me-2"></i>Riwayat Perjalanan</a></li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-user me-2"></i>Profil Saya</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>

            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold">Pemesanan Tiket Dinas</h3>
            </div>

            <!-- Langkah-langkah -->
            <div class="step-box mt-3">
                <div>1<br>Ajukan Perjalanan</div>
                <div>2<br>Cari Penerbangan</div>
                <div>3<br>Data Pegawai & Pilih Kursi</div>
                <div><span class="fw-bold text-primary">4<br>Konfirmasi</span></div>
            </div>

            <!-- Box Konfirmasi -->
            <div class="content-box mt-4 text-center">
                <div class="mb-4">
                    <i class="fas fa-check-circle check-icon"></i>
                    <h4 class="mt-3 fw-bold">Permohonan Tiket Dikirim!</h4>
                    <p class="mb-4">Permohonan tiket Anda telah berhasil dikirimkan ke Pimpinan Universitas untuk persetujuan.</p>
                </div>

                <div class="status-box text-start mx-auto" style="max-width: 500px;">
                    <p><strong>Status</strong> : <span class="badge bg-warning text-dark">Menunggu Persetujuan</span></p>
                    <p><strong>Nomor Permohonan</strong> : TKT-20250520-001</p>
                    <?php
// Ubah tanggal keberangkatan menjadi 1 hari sebelumnya
$tgl_berangkat = $row['tgl_berangkat'];
$batas_konfirmasi = date('Y-m-d', strtotime($tgl_berangkat . ' -1 day'));
?>
<p><strong>Batas Konfirmasi</strong> : <?= htmlspecialchars($batas_konfirmasi) ?></p>

                </div>

                <p class="mt-4">Anda akan menerima notifikasi via email dan aplikasi ketika permohonan telah disetujui atau jika ada perubahan</p>

                <a href="ajukanperjalanan.php" class="btn btn-dashboard mt-3"><i class="fas fa-arrow-left me-2"></i>Kembali ke Ajukan Perjalanan Dinas</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
