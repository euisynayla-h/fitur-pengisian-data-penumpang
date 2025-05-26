<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nip'])) {
    header("Location: login.php");
    exit;
}

// Simpan data ke database jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = $_SESSION['nip'];
    $tgl_pulang = $_POST['tgl_pulang'];
    $tgl_berangkat = $_POST['tgl_berangkat'];
    $kota_tujuan = $_POST['kota_tujuan'];
    $kota_berangkat = $_POST['kota_berangkat'];
    $jumlah = $_POST['jumlah'];

    $stmt = $conn->prepare("INSERT INTO pengajuan_perjalanan (nip, tanggal_keberangkatan, tanggal_kepulangan, kota_berangkat, kota_tujuan, jumlah_pegawai) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $nip, $tgl_berangkat, $tgl_pulang, $kota_berangkat, $kota_tujuan, $jumlah);
    $stmt->execute();

    // Redirect ke halaman selanjutnya
    header("Location: caripenerbangan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Perjalanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* *{
            outline: 1px solid red !important;
        } */
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
            padding: 20px;
            margin-top: 20px;
        }
        .step-box {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }
        .step-box div {
            text-align: center;
        }
        input[type="date"] {
            position: relative;
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
                <h6 class="mt-2 fw-bold">Universitas<br>Tanjungpura</h6>
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
                <div class="fw-bold text-primary">1<br>Ajukan Perjalanan</div>
                <div>2<br>Cari Penerbangan</div>
                <div>3<br>Data Pegawai & Pilih Kursi</div>
                <div>4<br>Konfirmasi</div>
            </div>

            <!-- Form Ajukan Perjalanan -->
            <!-- Form Ajukan Perjalanan -->
            <div class="content-box mt-4">
                <form method="POST" action="caripenerbangan.php">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nip" class="form-label">NIP Pegawai</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="<?= $_SESSION['nip'] ?>" readonly>
                        </div><div class="col-md-6">
                            <label for="jumlah" class="form-label">Jumlah Pegawai</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Pegawai yang ikut" min="1" max="5" required>

                        </div>
                        <div class="col-md-6">
                            <label for="tgl_berangkat" class="form-label">Tanggal Keberangkatan</label>
                            <input type="date" class="form-control" id="tgl_berangkat" name="tgl_berangkat" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_pulang" class="form-label">Tanggal Kepulangan</label>
                            <input type="date" class="form-control" id="tgl_pulang" name="tgl_pulang" required>
                        </div>
                         <div class="col-md-6">
                            <label for="kota_berangkat" class="form-label">Kota Keberangkatan</label>
                            <input type="text" class="form-control" id="kota_berangkat" name="kota_berangkat" placeholder="Nama Kota Keberangkatan" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kota_tujuan" class="form-label">Kota Tujuan</label>
                            <input type="text" class="form-control" id="kota_tujuan" name="kota_tujuan" placeholder="Nama Kota Tujuan" required>
                        </div>
                       
                        
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">Lanjutkan</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script> 
    const today = new Date().toISOString().split('T')[0];

    const berangkatInput = document.getElementById('tgl_berangkat');
    const pulangInput = document.getElementById('tgl_pulang');

    berangkatInput.min = today;
    pulangInput.min = today;

    
    berangkatInput.addEventListener('change', function () {
        const tglBerangkat = this.value;
        
        pulangInput.min = tglBerangkat > today ? tglBerangkat : today;

        if (pulangInput.value < pulangInput.min) {
            pulangInput.value = '';
        }
    });
</script>
</body>
</html>
