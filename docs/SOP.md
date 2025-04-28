SOP Push & Commit ke Repository GitHub
Project: Modul Pengisian Data Penumpang – Aplikasi Tiketku
PIC: DevOps

1. Persiapan
-	Pastikan Git sudah terinstal di komputer (apabila belum download Git: https://git-scm.com/downloads, kemudian cek dengan git –version di terminal).
-	Pastikan sudah memiliki akun GitHub.
-	Pastikan sudah terundang ke repository project:
Repository URL: https://github.com/euisynayla-h/fitur-pengisian-data-penumpang

2. Mengclone Repository dari GitHub
-	Buka Terminal atau Command Prompt.
-	Clone repo ke komputer lokal:
git clone https://github.com/euisynayla-h/fitur-pengisian-data-penumpang.git
-	Masuk ke folder project:
cd fitur-pengisian-data-penumpang

3. Membuat Branch Baru
Sebelum mulai bekerja, buat branch baru untuk setiap fitur yang sedang dikerjakan.
Ini penting agar perubahan tidak langsung masuk ke branch main (utama).
-	Pastikan sudah ada pada folder project (repo yang sudah di clone).
-	Buat branch baru sesuai nama fitur atau modul:
git checkout -b nama-branch
-	Contoh:
git checkout -b feature/input-data-penumpang

4. Melakukan Perubahan
Setelah membuat branch baru, mulai lakukan perubahan pada file sesuai tugas yang dikerjakan.
-	Misalnya, tambahkan file SPK pada /docs/SPK.md, atau juga buat diagram di /diagram.
-	Simpan semua perubahan.

5. Menambahkan dan Commit Perubahan
-	Cek status perubahan file (untuk menunjukkan file mana yang telah diubah):
git status
-	Tambah semua perubahan ke staging (mendandakan file siap di commit):
git add .
-	Commit dengan pesan yang jelas:
git commit -m "feat: menambahkan form input data penumpang"

6. Push Perubahan ke Repository GitHub
-	Push branch ke remote repository:
git push origin nama-branch
-	Contoh:
git push origin docs/surat-perjanjian-kerjasama

7. Membuat Pull Request (PR)
-	Buka repository di GitHub.
-	GitHub akan menampilkan opsi untuk membuat Pull Request.
-	Klik "Compare & Pull Request".
-	Isi deskripsi PR sesuai fitur yang dibuat.
-	Klik "Create Pull Request".

8. Review dan Merge
-	Setelah PR disetujui tim, lakukan merge ke branch utama (main atau develop).
-	Hapus branch jika sudah tidak digunakan.
git branch -d nama-branch

Catatan:
-	Gunakan format pesan commit:
feat: untuk fitur baru
fix: untuk perbaikan bug
docs: untuk perubahan dokumentasi
