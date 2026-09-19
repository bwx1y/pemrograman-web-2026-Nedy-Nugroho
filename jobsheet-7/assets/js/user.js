// Mengambil & menampilkan Daftar User/Member secara asinkron dari data/user.json
async function muatDaftarUser() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch("../data/user.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftarUser = await res.json();

        daftarUser.forEach(function (user) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + user.username + "</td>" +
                "<td>" + user.name + "</td>" +
                "<td>" + user.role + "</td>" +
                "<td>" + user.birth_date + "</td>" +
                "<td>" + user.age + "</td>" +
                "<td>" + user.phone + "</td>" +
                "<td>" + user.password + "</td>" +
                "<td>" +
                "<button type=\"button\" class=\"btn-edit\">Edit</button> " +
                "<button type=\"button\" class=\"btn-delete btn-hapus\">Delete</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML =
            "<tr><td colspan=\"8\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        if (loading) loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftarUser);
