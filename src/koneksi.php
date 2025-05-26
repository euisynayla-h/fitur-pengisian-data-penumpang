<?php
$conn = mysqli_connect("localhost", "root", "", "tiketdinas");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
