// ===== Hamburger menu (Bootstrap offcanvas sudah handle via data-bs attributes) =====
// index.html pakai offcanvas bawaan Bootstrap, tidak perlu JS custom untuk toggle.

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const nama = row ? row.querySelector("td")?.textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
            if (yakin && row) {
                row.remove();
            }
        });
    });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // Field nama/kode (item) atau username (user)
        const nama = form.querySelector("[name='nama'], [name='username']");
        if (nama && nama.value.trim() === "") {
            tampilkanError(nama, "Field ini wajib diisi.");
            valid = false;
        } else if (nama) {
            hapusError(nama);
        }

        // Field kode barang (hanya ada di form item)
        const kode = form.querySelector("[name='kode']");
        if (kode && kode.value.trim() === "") {
            tampilkanError(kode, "Field ini wajib diisi.");
            valid = false;
        } else if (kode) {
            hapusError(kode);
        }

        // Field kategori (hanya ada di form item)
        const kategori = form.querySelector("[name='kategori']");
        if (kategori && kategori.value === "") {
            tampilkanError(kategori, "Pilih salah satu kategori.");
            valid = false;
        } else if (kategori) {
            hapusError(kategori);
        }

        // Field jumlah barang (hanya ada di form item)
        const jumlah = form.querySelector("[name='jumlah']");
        if (jumlah) {
            const nilai = parseInt(jumlah.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(jumlah, "Jumlah harus angka >= 0.");
                valid = false;
            } else {
                hapusError(jumlah);
            }
        }

        // Field fullname (hanya ada di form user)
        const fullname = form.querySelector("[name='fullname']");
        if (fullname && fullname.value.trim() === "") {
            tampilkanError(fullname, "Field ini wajib diisi.");
            valid = false;
        } else if (fullname) {
            hapusError(fullname);
        }

        // Field password (hanya ada di form user)
        const password = form.querySelector("[name='password']");
        if (password && password.value.trim() === "") {
            tampilkanError(password, "Field ini wajib diisi.");
            valid = false;
        } else if (password) {
            hapusError(password);
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}

// ===== Entry point =====
document.addEventListener("DOMContentLoaded", function () {
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
