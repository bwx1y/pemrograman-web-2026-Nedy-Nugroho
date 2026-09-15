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


// ===== Entry point =====
document.addEventListener("DOMContentLoaded", function () {
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
