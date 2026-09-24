// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector(".sidebar") || document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const categorySelect = document.getElementById("category-filter");
    const statusSelect = document.getElementById("status-filter");
    const roleSelect = document.getElementById("role-filter");
    const table = document.querySelector(".table-responsive table") || document.querySelector("table");
    if (!table) return;

    function applyFilter() {
        const keyword = input ? input.value.toLowerCase() : "";
        const selectedCategory = categorySelect ? categorySelect.value.toLowerCase() : "";
        const selectedStatus = statusSelect ? statusSelect.value.toLowerCase() : "";
        const selectedRole = roleSelect ? roleSelect.value.toLowerCase() : "";
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            const matchKeyword = !keyword || teks.includes(keyword);

            let matchCategory = true;
            if (selectedCategory) {
                const categoryCell = row.children[2] ? row.children[2].textContent.trim().toLowerCase() : "";
                matchCategory = categoryCell === selectedCategory;
            }

            let matchStatus = true;
            if (selectedStatus) {
                const statusCell = row.children[5] ? row.children[5].textContent.trim().toLowerCase() : "";
                matchStatus = statusCell === selectedStatus;
            }

            let matchRole = true;
            if (selectedRole) {
                const roleCell = row.children[2] ? row.children[2].textContent.trim().toLowerCase() : "";
                matchRole = roleCell === selectedRole;
            }

            row.style.display = (matchKeyword && matchCategory && matchStatus && matchRole) ? "" : "none";
        });
    }

    if (input) input.addEventListener("keyup", applyFilter);
    if (categorySelect) categorySelect.addEventListener("change", applyFilter);
    if (statusSelect) statusSelect.addEventListener("change", applyFilter);
    if (roleSelect) roleSelect.addEventListener("change", applyFilter);
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

        const inputs = form.querySelectorAll("input, select, textarea");
        inputs.forEach(function (input) {
            if (input.hasAttribute("required") && input.value.trim() === "") {
                tampilkanError(input, "Field ini wajib diisi.");
                valid = false;
            } else if (input.hasAttribute("required")) {
                hapusError(input);
            }
        });

        if (!valid) {
            e.preventDefault();
        }
    });
}

// Tombol Hapus kini berada di dalam <form class="form-hapus" method="post">
// yang benar-benar mengirim request DELETE ke server. Konfirmasi dilakukan
// pada event "submit" agar bisa dibatalkan (preventDefault) sebelum request terkirim.
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        const row = form.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (!yakin) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    // initTableFilter();
    initValidasiForm();
});
