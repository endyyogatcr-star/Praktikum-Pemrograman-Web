// 1. Inisialisasi State Data Mahasiswa (Single Source of Truth)
let dataMahasiswa = [
    {
        npm: "230101001",
        nama: "Ahmad Fauzi",
        program_studi: "Teknik Informatika",
        angkatan: 2023,
        email: "ahmad.fauzi@example.com"
    },
    {
        npm: "230101002",
        nama: "Siti Nurhaliza",
        program_studi: "Sistem Informasi",
        angkatan: 2023,
        email: "siti.nurhaliza@example.com"
    },
    {
        npm: "240101015",
        nama: "Budi Santoso",
        program_studi: "Teknologi Informasi",
        angkatan: 2024,
        email: "budi.santoso@example.com"
    }
];

// 2. Elemen Dom Utama.
const alertBox = document.getElementById("alert-box");
const tabelBody = document.getElementById("tabel-body-mahasiswa");
const totalInfo = document.getElementById("total-mahasiswa-info");
const totalBadge = document.getElementById("total-mahasiswa-badge");
const inputSearch = document.getElementById("search-mahasiswa");
const formTambah = document.getElementById("form-tambah-mahasiswa");
const inputNpm = document.getElementById("npm");
const inputNama = document.getElementById("nama");
const selectProdi = document.getElementById("program_studi");
const inputAngkatan = document.getElementById("angkatan");
const inputEmail = document.getElementById("email");



// 3. Fungsi Menampilkan Notifikasi Alert Interaktif (Percobaan 3-1).
function showAlert(message, type = "success") {
    if (!alertBox) return;
    alertBox.textContent = message;
    alertBox.className = `alert-box alert-${type} show`;

    setTimeout(() => {
        alertBox.className = "alert-box";
        alertBox.textContent = "";
    }, 4000);
}

// 4. Fungsi Pembaruan Counter Statistik Real-Time.
function updateCounter(displayedCount, totalCount = dataMahasiswa.length) {
    if (totalBadge) totalBadge.textContent = totalCount;
    if (totalInfo) totalInfo.textContent = `Menampilkan ${displayedCount} dari ${totalCount} mahasiswa.`;
}


// 5. Fungsi Render Tabel ke DOM Secara Dinamis (Percobaan 3-2).

function renderTable(data = dataMahasiswa) {
    if (!tabelBody) return;
    tabelBody.innerHTML = "";

    if (data.length === 0) {
       tabelBody.innerHTML = `
       <tr>
            <td colspan="6" class="text-center">Tidak ada data mahasiswa yang ditemukan.
            </td>
        </tr>`;
        updateCounter(0);
        return;
    }

    
    data.forEach((mhs, index) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${index + 1}</td>
            <td><img src="img/avatar-default.png" alt="foto" ${mhs.nama}" class="avater-img" width:"36"; height:"36"></td>
            <td><strong>${mhs.npm}</strong></td>
            <td>${mhs.nama}</td>
            <td><span class="badge badge-primary">${mhs.program_studi}</span></td>
            <td>${mhs.angkatan}</td>
            <td><a href="mailto:${mhs.email}" class="link-email">${mhs.email}</a></td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="hapusMahasiswa('${mhs.npm}')">Hapus</button>
            </td>
        `;
        tabelBody.appendChild(tr);
    });

    updateCounter(data.length);
}

// 6. Validasi Form Sisi Klien Menggunakan Regular Expression (Percobaan 3-3).
function validateForm(npm, nama, prodi, angkatan, email) {
    if (!/^\d{8,12}$/.test(npm)) {
        return {
            isValid: false,
            message: "NPM wajib terdiri dari 8-12 digit angka."
        };
    }

    if (dataMahasiswa.some(mhs => mhs.npm === npm)) {
        return {
            isValid: false,
            message: "NPM sudah terdaftar."
        };
    }

    if (nama.length < 3) {
        return {
            isValid: false,
            message: "Nama lengkap minimal 3 karakter."
        };
    }

    if (!prodi) {
        return {
            isValid: false,
            message: "Pilih program studi."
        };
    }

    if (
        !/^\d{4}$/.test(angkatan) ||
        Number(angkatan) < 2018 ||
        Number(angkatan) > 2026
    ) {
        return {
            isValid: false,
            message: "Tahun angkatan harus antara 2018-2026."
        };
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        return {
            isValid: false,
            message: "Masukkan alamat email yang valid."
        };
    }

    return { isValid: true };
}

// 7. Event Handling Tambah Data Tanpa Reload (Percobaan 3-4).

if (formTambah) {
    formTambah.addEventListener("submit", function (event) {

        const npm = inputNpm.value.trim();
        const nama = inputNama.value.trim();
        const prodi = selectProdi.value;
        const angkatan = inputAngkatan.value.trim();
        const email = inputEmail.value.trim();

        const validation = validateForm(npm, nama, prodi, angkatan, email);

        if (!validation.isValid) {
            showAlert(validation.message, "danger");
            return;
        }

        const newMahasiswa = {
            npm,
            nama,
            program_studi: prodi,
            angkatan: Number(angkatan),
            email
        };

        dataMahasiswa.push(newMahasiswa);
        renderTable(dataMahasiswa);
        formTambah.reset();
        showAlert(`Data mahasiswa ${nama} (${npm}) berhasil ditambahkan.`, "success");
    });
}


// 8. Event Handling Hapus Data Mahasiswa (Percobaan 3-5).

function hapusMahasiswa(npm) {
    const mahasiswa = dataMahasiswa.find(item => item.npm === npm);
    if (!mahasiswa) return;

    const konfirmasi = confirm(`Apakah Anda yakin ingin menghapus data mahasiswa ${mahasiswa.nama} (${mahasiswa.npm})?`);
    if (konfirmasi) {
        dataMahasiswa = dataMahasiswa.filter(item => item.npm !== npm);
        renderTable(dataMahasiswa);
        showAlert(`Data mahasiswa ${mahasiswa.nama} (${mahasiswa.npm}) berhasil dihapus.`, "info");
    }
}


// 9. Fitur Pencarian Langsung Real-Time / Live Search (Percobaan 3-5)

if (inputSearch) {
    inputSearch.addEventListener("input", function () {
        const keyword = inputSearch.value.trim().toLowerCase();
        if (keyword === "") {
            renderTable(dataMahasiswa);
            return;
        } else {
            const hasilPencarian = dataMahasiswa.filter(mhs =>
                mhs.npm.toLowerCase().includes(keyword) ||
                mhs.nama.toLowerCase().includes(keyword)
            );
            renderTable(hasilPencarian);
        }
    });
}


// Inisialisasi saat DOM selesai dimuat

document.addEventListener("DOMContentLoaded", function () {
    renderTable();
    showAlert("Selamat datang di Sistem Informasi Data Mahasiswa (SIMA)!","info");
});
