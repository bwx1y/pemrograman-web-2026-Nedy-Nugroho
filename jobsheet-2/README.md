# Goods Office — Sistem Pendataan Barang Inventaris

Dashboard pendataan barang inventaris kantor berbasis HTML dan CSS.

## Struktur Direktori

```
jobsheet-2/
├── assets/
│   └── css/
│       └── style.css          # Seluruh style layout & komponen
├── item/
│   ├── index.html             # Halaman daftar barang
│   └── add.html               # Halaman tambah barang
├── user/
│   ├── index.html             # Halaman daftar anggota
│   └── add.html               # Halaman tambah anggota
└── index.html                 # Dashboard utama
```

## Halaman

| Halaman | Deskripsi |
|---------|-----------|
| `index.html` | Dashboard dengan 3 kartu ringkasan: Jumlah Barang, Jumlah Pengguna, Jumlah Kategori |
| `item/index.html` | Tabel daftar barang (kode, nama, kategori, jumlah) dengan tombol Edit & Hapus |
| `item/add.html` | Form tambah barang (kode, nama, kategori dropdown, jumlah) |
| `user/index.html` | Tabel daftar anggota (username, nama lengkap, password) dengan tombol Edit & Hapus |
| `user/add.html` | Form tambah anggota (username, nama lengkap, password) |

## Fitur

- Dashboard ringkasan inventaris
- CRUD Barang (tambah, daftar, edit, hapus — UI only)
- CRUD Anggota (tambah, daftar, edit, hapus — UI only)
- Sidebar navigasi antar halaman
- 4 kategori barang: Komponen Elektronik, Perangkat IT, Alat Tulis Kantor, Perabotan

## Teknologi

| Layer | Teknologi |
|-------|-----------|
| Markup | HTML5 |
| Styling | CSS3 (Flexbox + Grid) |
| Backend | — |
| Database | — |
| JavaScript | — |
