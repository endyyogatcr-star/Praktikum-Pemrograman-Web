<?php
/**
 * Praktikum 4: Implementasi Aplikasi Web Dinamis Menggunakan PHP
 * File: index.php
 * Halaman utama dengan rendering server-side dinamis.
 */

// memanggil file functions.php
require_once __DIR__ . '/includes/functions.php';

$page_title = 'Uji Fungsi Modular - Percobaan 1';
init_mahasiswa_session();
$daftar_mahasiswa = get_all_mahasiswa();
$total_semua = count_total_mahasiswa();

// Ambil keyword pencarian jika ada

// Percobaan 4-4 Langkah 2

$total_semua = count_total_mahasiswa();
$total_tampil = count($daftar_mahasiswa);

// Ambil flash message dari session jika tersedia
$flash = get_flash_message();

$page_title = 'Beranda - Sistem Informasi Data Mahasiswa';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Kotak Flash Message (Feedback Sukses / Error dari Server) -->
<?php if ($flash): ?>
    <div class="alert-box alert-<?= htmlspecialchars($flash['type']) ?>" role="alert">
        <?= htmlspecialchars($flash['message']) ?>
    </div>
<?php endif; ?>

<!-- 1. Section Informasi Aplikasi -->
<section id="informasi" class="content-section">
    <div class="section-header">
        <h2>Tentang Aplikasi</h2>
        <p>Pemrosesan server-side dinamis menggunakan sintaks dasar, array, loop, dan function PHP.</p>
    </div>
    <p>
        Halaman ini merupakan kelanjutan dari <strong>Praktikum 3</strong>. Pada tahap ini, 
        aplikasi tidak lagi menggunakan data statis di browser, melainkan dibangun dan di-render 
        secara dinamis di sisi server oleh <strong>PHP</strong> menggunakan perulangan (<code>foreach</code>), 
        fungsi modular, pemisahan berkas (<code>include</code>), validasi server-side, serta penanganan 
        sesi pengguna (<code>$_SESSION</code>) sebelum nantinya beralih ke basis data MySQL di Praktikum 5.
    </p>

    <div class="info-grid">
        <article class="info-card">
            <h3>Total Mahasiswa</h3>
            <p class="counter-highlight"><?= $total_semua ?></p>
        </article>
        <article class="info-card">
            <h3>Tahun Akademik</h3>
            <p>2025/2026</p>
        </article>
        <article class="info-card">
            <h3>Teknologi Aktif</h3>
            <p>HTML5 + CSS + PHP</p>
        </article>
    </div>
</section>

<!-- 2. Section Daftar Mahasiswa & Form Pencarian Server-Side -->
<section id="daftar-mahasiswa" class="content-section">
    <div class="section-header">
        <h2>Daftar Mahasiswa Aktif</h2>
        <p>Data diambil dan di-render langsung dari struktur array memori server menggunakan PHP.</p>
    </div>

    <!-- Toolbar Pencarian Server-Side via GET Request -->
    <div class="table-toolbar">
        <form action="index.php#daftar-mahasiswa" method="post" class="search-form">
            <?php
                $keyword = isset($_POST['search']) ? trim($_POST['search']) : '';
                $daftar_mahasiswa = get_all_mahasiswa($keyword);
            ?>
            <input 
                type="search" 
                name="search" 
                class="search-input" 
                placeholder="Cari berdasarkan npm, Nama, atau Prodi..."
                value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            <?php if (!empty($keyword)): ?>
                <a href="index.php#daftar-mahasiswa" class="btn btn-secondary btn-sm">Reset</a>
            <?php endif; ?>
        </form>

        <div class="status-summary">
            <?php if (!empty($keyword)): ?>
                Ditemukan <?= $total_tampil ?> dari total <?= $total_semua ?> mahasiswa
            <?php else: ?>
                Menampilkan <?= $total_semua ?> mahasiswa
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabel Data Mahasiswa yang Di-generate oleh PHP -->
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>npm</th>
                    <th>Nama Lengkap</th>
                    <th>Program Studi</th>
                    <th>Angkatan</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftar_mahasiswa)): ?>
                    <!-- Percobaan 4-2 Langkah 4 -->
                    <tr>
                        <td colspan="8" class="empty-row">
                            <?= 
                            !empty($keyword) ? 'Tidak ditemukan data mahasiswa dengan kata kunci "'.$keyword.'".' : 'Belum ada data mahasiswa yang tersimpan'
                            ?>
                        </td>
                    </tr>
                <?php else: ?>

                    <!-- Percobaan 4-2 Langkah 3 -->
                    <?php foreach ($daftar_mahasiswa as $index => $mhs): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <img src="img/avatar-default.svg" alt="Foto <?= htmlspecialchars($mhs['nama']) ?>" class="avatar-img" width="36" height="36">
                            </td>
                            <td><strong><?= htmlspecialchars($mhs['npm']) ?></strong></td>
                            <td><?= htmlspecialchars($mhs['nama']) ?></td>
                            <td><span class="badge"><?= htmlspecialchars($mhs['program_studi']) ?></span></td>
                            <td><?= htmlspecialchars($mhs['angkatan']) ?></td>
                            <td><a href="mailto:<?= htmlspecialchars($mhs['email']) ?>" class="link-email"><?= htmlspecialchars($mhs['email']) ?></a></td>
                            <td>
                                <!-- Percobaan 4-2 Langkah 5 -->
                                <a href="proses_hapus.php?npm=<?= urlencode($mhs['npm']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus mahasiswa: <?= htmlspecialchars(addslashes($mhs['nama'])) ?> (npm: <?= htmlspecialchars($mhs['npm']) ?>)?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- 3. Section Form Tambah Mahasiswa diproses oleh proses_tambah.php -->
<section id="form-tambah" class="content-section">
    <div class="section-header">
        <h2>Tambah Mahasiswa Baru</h2>
        <p>Formulir dikirim ke server melalui HTTP POST untuk divalidasi dan disimpan di server.</p>
    </div>

    <form action="proses_tambah.php" method="post" class="app-form">
        <fieldset>
            <legend>Data Identitas Mahasiswa</legend>

            <div class="form-grid">
                <div class="form-group">
                    <label for="npm" class="form-label">Nomor Induk Mahasiswa (npm):</label>
                    <input 
                        type="text" 
                        id="npm" 
                        name="npm" 
                        class="form-input" 
                        placeholder="Contoh: 230101001" 
                        required 
                        pattern="[0-9]{8,12}">
                    <span class="form-help">* Wajib 8-12 digit angka.</span>
                </div>

                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap:</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        class="form-input" 
                        placeholder="Contoh: Ahmad Fauzi" 
                        required 
                        minlength="3">
                    <span class="form-help">* Minpmal 3 karakter.</span>
                </div>

                <div class="form-group">
                    <label for="program_studi" class="form-label">Program Studi:</label>
                    <select id="program_studi" name="program_studi" class="form-select" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                        <option value="Teknologi Informasi">Teknologi Informasi</option>
                        <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                    </select>
                    <span class="form-help">* Pilih salah satu program studi.</span>
                </div>

                <div class="form-group">
                    <label for="angkatan" class="form-label">Tahun Angkatan:</label>
                    <input 
                        type="number" 
                        id="angkatan" 
                        name="angkatan" 
                        class="form-input" 
                        placeholder="Contoh: 2024" 
                        required 
                        min="2018" 
                        max="2026">
                    <span class="form-help">* Tahun antara 2018 - 2026.</span>
                </div>

                <div class="form-group full-width">
                    <label for="email" class="form-label">Alamat Email:</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="Contoh: ahmad.fauzi@example.com" 
                        required>
                    <span class="form-help">* Masukkan alamat email valid.</span>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Data Mahasiswa</button>
                <button type="reset" class="btn btn-secondary">Reset Formulir</button>
            </div>
        </fieldset>
    </form>
</section>

<!-- memanggil file footer.php -->

