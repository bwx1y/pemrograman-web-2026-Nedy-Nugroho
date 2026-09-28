// Mengambil & menampilkan Daftar Kategori secara asinkron dari data/category.json
async function muatDaftarKategori() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/category.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarKategori = await res.json();

        daftarKategori.forEach(function (kategori, index) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + (kategori.id || (index + 1)) + "</td>" +
                "<td>" + kategori.name + "</td>" +
                "<td>" + kategori.description + "</td>" +
                "<td>" +
                "<button type=\"button\" class=\"btn-edit\">Edit</button> " +
                "<button type=\"button\" class=\"btn-delete btn-hapus\">Delete</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"4\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        if (loading) loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarKategori);
