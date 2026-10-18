# Praktikum 3: Implementasi Interaktivitas Web Menggunakan JavaScript dan DOM

## 1. Dokumen Modul Resmi & Panduan
- **Dokumen Word Resmi**: [`Judul 3 draft.docx`](../Judul%203%20draft.docx)
- **Modul Markdown Lengkap**: [`Judul 3 draft.md`](../Judul%203%20draft.md)
- **Modul Kerja Praktikan**: [`03-praktikum-javascript-dom-praktikan/MODUL_PRAKTIKUM_JUDUL_3.md`](../03-praktikum-javascript-dom-praktikan/MODUL_PRAKTIKUM_JUDUL_3.md)
- **Lembar Kerja Praktikan (5 Percobaan)**: [`03-praktikum-javascript-dom-praktikan/README.md`](../03-praktikum-javascript-dom-praktikan/README.md)

---

## 2. Informasi Praktikum
- **Pertemuan**: 3 dari 6
- **Topik**: Interaktivitas Klien, Event Listener, Manipulasi DOM Tree, Validasi Form RegEx, dan State Management Sisi Klien
- **Durasi**: 90 Menit (15m Pretest & Pengantar, 50m Hands-on Coding, 25m Review & Posttest)
- **Target Project**: Sistem Informasi Data Mahasiswa (Tahap 3 - Client-Side Interactivity)
- **Dasar Kode**: Melanjutkan struktur HTML semantik dan Native CSS dari `02-praktikum-css-responsive/`
- **File Referensi Master**: [`index.html`](./index.html), [`style.css`](./style.css), dan [`app.js`](./app.js)

---

## 3. Tujuan Pembelajaran
Mahasiswa diharapkan mampu:
1. Mendeklarasikan variabel (`let`, `const`), tipe data, dan struktur data array of objects pada JavaScript modern (ES6+).
2. Memahami hierarki DOM Tree dan melakukan seleksi elemen DOM (`getElementById`, `querySelector`, `querySelectorAll`).
3. Memasang Event Listener (`submit`, `input`, `click`, `DOMContentLoaded`).
4. Mencegah perilaku bawaan browser (*default behavior*) saat pengiriman formulir dengan `event.preventDefault()`.
5. Melakukan validasi data di sisi klien secara tangguh menggunakan Regular Expression (validasi NIM numerik 8-12 digit, keunikan NIM, panjang karakter nama, dan format email).
6. Membuat, memodifikasi, dan menghapus elemen DOM secara dinamis (`createElement`, `appendChild`, `innerHTML`, `classList`).
7. Membangun fitur pencarian langsung (*live search filter*) dan sinkronisasi badge counter secara *real-time*.

---

## 4. Requirement Sistem & Interaktivitas
1. **Validasi Formulir (JavaScript)**:
   - NIM harus berupa angka 8-12 digit dan unik (tidak boleh duplikat dengan data yang sudah tersimpan).
   - Nama lengkap minimal 3 karakter.
   - Program studi wajib dipilih dari menu dropdown.
   - Tahun angkatan berada dalam rentang 2018 - 2026.
   - Email harus memenuhi format alamat email yang valid (`name@domain.ext`).
   - Menampilkan alert box interaktif berwarna merah (`.alert-danger`) jika data tidak valid.
2. **Tambah Data Tanpa Reload**:
   - Data mahasiswa baru langsung disisipkan ke state array dan tabel DOM tanpa menyegarkan (*refresh*) peramban.
   - Menampilkan notifikasi hijau sukses (`.alert-success`) selama 4 detik.
   - Mengosongkan form kembali (*form reset*) setelah penambahan data berhasil.
3. **Hapus Data Terintegrasi**:
   - Setiap baris memiliki tombol "Hapus".
   - Menampilkan dialog konfirmasi bawaan peramban (`confirm()`) sebelum mengeksekusi penghapusan.
   - Menghapus data dari state array dan memperbarui tabel secara otomatis.
4. **Pencarian Real-Time (Live Search)**:
   - Kotak pencarian menyaring baris data secara langsung saat pengguna mengetik (*input event*) berdasarkan NIM, Nama, atau Program Studi.
5. **Dynamic Counter & Status Summary**:
   - Total mahasiswa pada kartu status atas dan toolbar tabel berubah otomatis secara *real-time* setiap kali ada data ditambah, dihapus, atau difilter.

---

## 5. Batasan Teknologi & Kontinuitas
Pada pertemuan 3 ini, mahasiswa **DILARANG** menggunakan:
- Library atau Framework JavaScript (jQuery, React, Vue, Angular, Alpine, dll.)
- Framework CSS (tetap konsisten menggunakan **Native CSS** `style.css` sesuai kelanjutan kurikulum)
- Bahasa backend (PHP) maupun basis data (MySQL)

> **Prinsip Utama**: Seluruh interaktivitas harus dibangun menggunakan **Vanilla JavaScript** dan **W3C DOM API**.

---

## 6. Cara Menjalankan & Menguji
1. Buka file `03-praktikum-javascript-dom/index.html` langsung di browser (atau gunakan live server lokal).
2. Uji alur fitur berikut:
   - **Uji Validasi Form**: Tekan tombol "Simpan Data Mahasiswa" saat form masih kosong atau isikan NIM yang salah. Perhatikan kemunculan alert box merah.
   - **Uji Tambah Data**: Masukkan data baru yang valid, klik Simpan, pastikan baris baru langsung muncul di baris tabel tanpa reload halaman dan notifikasi hijau muncul.
   - **Uji Counter**: Perhatikan angka total mahasiswa di kartu status dan toolbar bertambah otomatis.
   - **Uji Search**: Ketik nama atau NIM pada kolom pencarian dan pastikan baris tabel langsung tersaring secara instan.
   - **Uji Hapus**: Klik tombol "Hapus" pada salah satu baris mahasiswa, setujui dialog konfirmasi, dan pastikan baris terhapus serta counter berkurang.

---

## 7. Kelanjutan ke Praktikum 4
Pada **Praktikum 4**, antarmuka interaktif sisi klien ini akan dihubungkan ke lingkungan server menggunakan bahasa pemrograman **PHP** untuk memproses data formulir di sisi server (*Server-Side Processing*), memvalidasi data di server, dan membagi antarmuka menjadi komponen modular (`header.php`, `nav.php`, `footer.php`).
