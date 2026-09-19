// Mengambil & menampilkan Daftar Item secara asinkron dari data/item.json
async function muatDaftarItem() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/item.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarItem = await res.json();

        daftarItem.forEach(function (item) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + item.code + "</td>" +
                "<td>" + item.name + "</td>" +
                "<td>" + item.category + "</td>" +
                "<td>" + item.count + "</td>" +
                "<td>" + item.price + "</td>" +
                "<td>" + item.status + "</td>" +
                "<td>" +
                "<button type=\"button\" class=\"btn-edit\">Edit</button> " +
                "<button type=\"button\" class=\"btn-delete btn-hapus\">Delete</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"7\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        if (loading) loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarItem);
