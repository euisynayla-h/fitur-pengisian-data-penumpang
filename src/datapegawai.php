    <?php
    session_start();
    include 'koneksi.php';

    if (!isset($_SESSION['nip'])) {
        $_SESSION['error'] = 'Silakan login terlebih dahulu.';
        header("Location: login.php");
        exit;
    }

    $nip = $_SESSION['nip'];
    $id_perjalanan = $_SESSION['id_perjalanan'] ?? null;

    if (!$id_perjalanan) {
        die("Perjalanan tidak ditemukan.");
    }

    // Ambil data perjalanan
    $data = mysqli_query($conn, "SELECT * FROM perjalanan WHERE id='$id_perjalanan'");
    $row = mysqli_fetch_assoc($data);

    // Simulasi kursi yang sudah terisi (misalnya dari database, di sini hardcode)
    $kursi_terisi = ['2A', '2B', '2D'];

    // Ambil jumlah pegawai dari perjalanan
    $jumlah_pegawai = $row['jumlah_pegawai'];
    ?>

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Data Pegawai & Pilih Kursi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <style>
            body { background-color: #f8f9fa; }
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
            .seat-box {
                display: flex;
                gap: 10px;
                margin-bottom: 10px;
            }
            .seat {
                width: 50px;
                text-align: center;
                padding: 5px;
                border-radius: 4px;
            }
            .seat.terisi {
                background-color: #f44336;
                color: white;
            }
            .seat.tersedia {
                background-color: #f1f1f1;
            }
            .seat.dipilih {
                background-color: #4caf50;
                color: white;
            }
            .legend span {
                display: inline-block;
                width: 15px;
                height: 15px;
                margin-right: 5px;
            }
            /* *{
            outline: 1px solid red !important;
            } */
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
                <h3 class="fw-bold">Pemesanan Tiket Dinas</h3>

                <div class="content-box mt-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Maskapai:</label>
                            <p class="fw-bold"><?= htmlspecialchars($row['maskapai']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label>Waktu Keberangkatan:</label>
                            <p class="fw-bold"><?= htmlspecialchars($row['waktu_keberangkatan']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label>Tanggal Keberangkatan:</label>
                            <p class="fw-bold"><?= htmlspecialchars($row['tgl_berangkat']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label>Waktu Kedatangan:</label>
                            <p class="fw-bold">08:00:00</p>
                        </div>
                    </div>

                    <form action="konfirmasi.php" method="POST" id="form-pemesanan">
                        <h5>Daftar Pegawai yang Ikut:</h5>
                        <?php for ($i = 1; $i <= $jumlah_pegawai; $i++): ?>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label for="nip<?= $i ?>" class="form-label">Pegawai <?= $i ?> - NIP</label>
                                    <input type="text" class="form-control" name="nip<?= $i ?>" id="nip<?= $i ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="kursi<?= $i ?>" class="form-label">No Kursi</label>
                                    <select class="form-select kursi-select" name="kursi<?= $i ?>" id="kursi<?= $i ?>" required>
                                        <option disabled selected value="">Pilih Kursi</option>
                                        <?php
                                        $all_kursi = ['1A', '1B', '1C', '1D', '2A', '2B', '2C', '2D'];
                                        foreach ($all_kursi as $k) {
                                            $disabled = in_array($k, $kursi_terisi) ? 'disabled' : '';
                                            echo "<option value='$k' $disabled>$k</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php endfor; ?>

                        <h5 class="mt-4">Denah Kursi:</h5>
                        <p><i class="fas fa-door-open me-2"></i>Pintu Masuk</p>
                        <div class="seat-box">
                            <?php foreach (['1A', '1B', '1C', '1D'] as $kursi): ?>
                                <div class="seat <?= in_array($kursi, $kursi_terisi) ? 'terisi' : 'tersedia' ?>" id="seat-<?= $kursi ?>"><?= $kursi ?></div>
                            <?php endforeach; ?>
                        </div>
                        <div class="seat-box">
                            <?php foreach (['2A', '2B', '2C', '2D'] as $kursi): ?>
                                <div class="seat <?= in_array($kursi, $kursi_terisi) ? 'terisi' : 'tersedia' ?>" id="seat-<?= $kursi ?>"><?= $kursi ?></div>
                            <?php endforeach; ?>
                        </div>

                        <div class="legend mt-3">
                            <span style="background-color:#f44336;"></span> Terisi
                            <span style="background-color:#f1f1f1; margin-left:15px;"></span> Tersedia
                            <span style="background-color:#4caf50; margin-left:15px;"></span> Dipilih
                        </div>

                        <div class="text-end mt-4">
    <!-- <a href="caripenerbangan.php" class="btn btn-secondary me-2">Kembali</a> -->
    <button type="button" class="btn btn-primary" onclick="tampilkanKonfirmasi()">Lanjut Konfirmasi</button>
</div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Konfirmasi Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menyimpan data berikut?</p>
            <div id="previewData"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-success" onclick="submitForm()">Ya</button>
        </div>
        </div>
    </div>
    </div>

    <script>
        const kursiSelects = document.querySelectorAll('.kursi-select');
        const kursiTerisi = <?= json_encode($kursi_terisi) ?>;

        function updateDenahKursi() {
            document.querySelectorAll('.seat').forEach(seat => {
                if (!kursiTerisi.includes(seat.textContent)) {
                    seat.classList.remove('dipilih');
                }
            });

            kursiSelects.forEach(select => {
                const val = select.value;
                if (val && !kursiTerisi.includes(val)) {
                    const el = document.getElementById('seat-' + val);
                    if (el) el.classList.add('dipilih');
                }
            });
        }

        function updateKursiOptions() {
            let selectedValues = Array.from(kursiSelects).map(s => s.value).filter(v => v);

            kursiSelects.forEach(select => {
                const currentValue = select.value;

                Array.from(select.options).forEach(option => {
                    if (option.value === "" || kursiTerisi.includes(option.value)) {
                        return; // abaikan kosong & yang sudah terisi dari server
                    }

                    // Nonaktifkan jika dipilih oleh pegawai lain
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }

        kursiSelects.forEach(select => {
            select.addEventListener('change', () => {
                updateDenahKursi();
                updateKursiOptions();
            });
        });

        // Inisialisasi saat halaman load
        updateDenahKursi();
        updateKursiOptions();

        function validateKursi() {
            for (let select of kursiSelects) {
                if (!select.value) {
                    alert("Semua pegawai harus memilih kursi.");
                    return false;
                }
            }
            return true;
        }

        function tampilkanKonfirmasi() {
            if (!validateKursi()) return;

            const jumlah = <?= $jumlah_pegawai ?>;
            let preview = '<ul class="list-group">';
            for (let i = 1; i <= jumlah; i++) {
                const nip = document.getElementById('nip' + i).value;
                const kursi = document.getElementById('kursi' + i).value;
                preview += `<li class="list-group-item">Pegawai ${i}: <strong>NIP:</strong> ${nip} | <strong>Kursi:</strong> ${kursi}</li>`;
            }
            preview += '</ul>';
            document.getElementById('previewData').innerHTML = preview;

            const modal = new bootstrap.Modal(document.getElementById('konfirmasiModal'));
            modal.show();
        }

        function submitForm() {
            document.getElementById('form-pemesanan').submit();
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
