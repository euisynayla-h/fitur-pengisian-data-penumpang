<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nip'])) {
    header("Location: login.php");
    exit;
}

$nip = $_SESSION['nip'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['kota_berangkat'])) {
        $kota_berangkat = $_POST['kota_berangkat'];
        $kota_tujuan = $_POST['kota_tujuan'];
        $tgl_berangkat = $_POST['tgl_berangkat'];
        $tgl_pulang = $_POST['tgl_pulang'];
        $jumlah_pegawai = $_POST['jumlah'];

        $query = "INSERT INTO perjalanan (nip, kota_berangkat, kota_tujuan, tgl_berangkat, tgl_pulang, jumlah_pegawai)
                  VALUES ('$nip', '$kota_berangkat', '$kota_tujuan', '$tgl_berangkat', '$tgl_pulang', '$jumlah_pegawai')";
        mysqli_query($conn, $query);
        $id_perjalanan = mysqli_insert_id($conn);
        $_SESSION['id_perjalanan'] = $id_perjalanan;
    }

    if (isset($_POST['pilih_penerbangan'])) {
        $maskapai = $_POST['maskapai'];
        $jam_keberangkatan = $_POST['jam_keberangkatan'];
        $harga = $_POST['harga'];
        $id_perjalanan = $_SESSION['id_perjalanan'];

        $update = "UPDATE perjalanan 
                   SET maskapai='$maskapai', waktu_keberangkatan='$jam_keberangkatan', harga='$harga'
                   WHERE id='$id_perjalanan'";
        mysqli_query($conn, $update);
    }
}

$id_perjalanan = $_SESSION['id_perjalanan'] ?? null;
$data = mysqli_query($conn, "SELECT * FROM perjalanan WHERE id='$id_perjalanan'");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Tiket Dinas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { height: 100vh; background-color: #dce5ff; padding: 20px; }
        .sidebar .nav-link.active { background-color: #aac7ff; color: #000; }
        .content-box { background: white; border-radius: 10px; padding: 20px; margin-top: 20px; }
        .step-box { display: flex; justify-content: space-around; margin-top: 10px; }
        .step-box div { text-align: center; }
        .flight-card { border: 1px solid #ddd; border-radius: 10px; padding: 15px; margin-top: 10px; }
        .btn-lanjutkan { position: fixed; bottom: 20px; right: 30px; z-index: 10; }
        .btn-kembali { position: fixed; bottom: 20px; right: 160px; z-index: 10; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
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

        <div class="col-md-10 p-4">
            <h3 class="fw-bold">Pemesanan Tiket Dinas</h3>

            <div class="step-box mt-3">
                <div>1<br>Ajukan Perjalanan</div>
                <div class="fw-bold text-primary">2<br>Cari Penerbangan</div>
                <div>3<br>Data Pegawai & Pilih Kursi</div>
                <div>4<br>Konfirmasi</div>
            </div>

            <div class="content-box mt-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Kota Keberangkatan:</label>
                        <p class="fw-bold"><?= htmlspecialchars($row['kota_berangkat']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label>Kota Tujuan:</label>
                        <p class="fw-bold"><?= htmlspecialchars($row['kota_tujuan']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Keberangkatan:</label>
                        <p class="fw-bold"><?= htmlspecialchars($row['tgl_berangkat']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label>Tanggal Kepulangan:</label>
                        <p class="fw-bold"><?= htmlspecialchars($row['tgl_pulang']) ?></p>
                    </div>
                </div>

                <!-- Pilihan Penerbangan -->
                <form method="POST" class="flight-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <img src="logogi.png" height="60"><br>
                            <small>Garuda Indonesia</small><br>
                            <strong>06:30</strong> <?= $row['kota_berangkat'] ?> → <strong>08:00</strong> <?= $row['kota_tujuan'] ?><br>
                            <small>1j 30m | Langsung | GA-123 | Boeing 737-800</small>
                        </div>
                        <div class="text-end">
                            <h5 class="text-primary">Rp 3.250.000</h5>
                            <br>
                            <p>Per Orang</p>
                            <input type="hidden" name="maskapai" value="Garuda Indonesia">
                            <input type="hidden" name="jam_keberangkatan" value="06:30">
                            <input type="hidden" name="harga" value="3250000">
                            <button class="btn btn-primary mt-2" type="submit" name="pilih_penerbangan">Pilih Penerbangan ini</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tombol lanjut -->
            <?php if (!empty($row['maskapai'])): ?>
                <form action="datapegawai.php" method="POST">
                    <input type="hidden" name="id_perjalanan" value="<?= $id_perjalanan ?>">
                    <button type="submit" class="btn btn-success btn-lanjutkan">Lanjutkan <i class="fas fa-arrow-right ms-1"></i></button>
                </form>
            <?php endif; ?>

            <!-- Tombol kembali -->
            <!-- <a href="ajukanperjalanan.php" class="btn btn-secondary btn-kembali">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a> -->

        </div>
    </div>
</div>
</body>
</html>
