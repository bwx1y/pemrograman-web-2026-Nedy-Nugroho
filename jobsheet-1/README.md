# Goods Office

Sistem informasi pendataan barang inventaris berbasis web statis menggunakan HTML.

## Struktur Proyek

```
jobsheet-1/
├── index.html        # Halaman utama (Dashboard)
├── item/
│   ├── index.html    # Daftar barang
│   └── add.html      # Form tambah barang
└── user/
    ├── index.html    # Daftar anggota
    └── add.html      # Form tambah anggota
```

## Halaman

| Halaman | Deskripsi |
|---------|-----------|
| Dashboard | Menampilkan ringkasan jumlah barang, pengguna, dan kategori |
| List of Items | Tabel daftar barang beserta kode, nama, kategori, dan jumlah |
| Daftar Anggota | Tabel daftar anggota beserta username, nama lengkap, dan password |

## Fitur

- **Dashboard** — Menampilkan statistik inventaris (barang, pengguna, kategori)
- **Manajemen Barang** — Melihat daftar barang, menambah barang baru
- **Manajemen Anggota** — Melihat daftar anggota, menambah anggota baru
- **Navigasi Sidebar** — Sidebar untuk navigasi antar halaman

## Kategori Barang

- Komponen Elektronik
- Perangkat IT
- Alat Tulis Kantor
- Perabotan

## Teknologi

- HTML5
