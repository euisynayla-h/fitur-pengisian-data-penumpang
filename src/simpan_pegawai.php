<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nip'])) {
    die("Akses ditolak. Silakan login.");
}

$id_perjalanan = $_SESSION['id_perjalanan'] ?? null;
if (!$id_perjalanan) {
    die("ID perjalanan tidak ditemukan.");
}

// Ambil jumlah pegawai dari perjalanan
$result = mysqli_query($conn, "SELECT jumlah_pegawai FROM perjalanan WHERE id = '$id_perjalanan'");
if (!$result || mysqli_num_rows($result) == 0) {
    die("Data perjalanan tidak ditemukan.");
}
$row = mysqli_fetch_assoc($result);
$jumlah_pegawai = $row['jumlah_pegawai'];

// Ambil kursi yang sudah terisi
$kursi_terisi = [];
$q_kursi = mysqli_query($conn, "SELECT no_kursi FROM kursi_terisi WHERE id_perjalanan = '$id_perjalanan'");
while ($r = mysqli_fetch_assoc($q_kursi)) {
    $kursi_terisi[] = $r['no_kursi'];
}

for ($i = 1; $i <= $jumlah_pegawai; $i++) {
    $nip = $_POST["nip$i"] ?? null;
    $kursi = $_POST["kursi$i"] ?? null;

    if (!$nip || !$kursi) {
        echo "Data pegawai ke-$i tidak lengkap.";
        exit;
    }

    // Cek apakah kursi sudah terisi
    if (in_array($kursi, $kursi_terisi)) {
        echo "Kursi $kursi sudah terisi. Silakan pilih kursi lain.";
        exit;
    }

    // Simpan data pegawai
    $query1 = "INSERT INTO pegawai (nip, id_perjalanan, no_kursi) VALUES ('$nip', '$id_perjalanan', '$kursi')";
    $result1 = mysqli_query($conn, $query1);

    // Simpan kursi terisi
    $query2 = "INSERT INTO kursi_terisi (id_perjalanan, no_kursi) VALUES ('$id_perjalanan', '$kursi')";
    $result2 = mysqli_query($conn, $query2);

    if (!$result1 || !$result2) {
        echo "Gagal menyimpan data pegawai ke-$i: " . mysqli_error($conn);
        exit;
    }

    // Tambahkan kursi ke daftar terisi agar tidak dipakai lagi di loop berikutnya
    $kursi_terisi[] = $kursi;
}

echo "<script>alert('Data pegawai berhasil disimpan!'); window.location='konfirmasi.php';</script>";
?>
