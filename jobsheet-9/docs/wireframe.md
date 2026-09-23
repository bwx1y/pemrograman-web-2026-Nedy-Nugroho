# Wireframe & User Flow — SIMPUS-Mini

Sub-CPMK: Merancang UI/UX aplikasi (proyek).

Halaman yang sudah ada (Beranda, Daftar/Tambah Barang, Daftar/Tambah Anggota — Jobsheet 1-3) belum mencakup fitur Login, Dashboard Petugas, dan Peminjaman/Pengembalian. Dokumen ini merancang wireframe untuk halaman-halaman tersebut sebelum diimplementasikan mulai Jobsheet 5 dan seterusnya.

## Aktor
- **Tamu**: hanya bisa melihat katalog barang (Beranda, Daftar Barang) tanpa login.
- **Petugas**: login untuk mengakses seluruh fitur CRUD dan transaksi peminjaman.

## User Flow — Login Petugas
```
[Buka /login] -> [Isi Username + Password] -> [Klik Masuk]
    -> Jika valid -> [Dashboard Petugas]
    -> Jika tidak valid -> [Tampilkan pesan error di halaman yang sama]
```

## User Flow — Peminjaman Barang
```
[Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"]
    -> [Pilih Anggota] -> [Pilih Barang (Count > 0)]
    -> [Simpan] -> [Count barang berkurang 1] -> [Kembali ke Dashboard]
```

## User Flow — Pengembalian Barang
```
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/barang)]
    -> [Tandai "Dikembalikan"] -> [Count barang bertambah 1]
    -> [Kembali ke Dashboard]
```

## User Flow — Petugas Mencari Anggota dengan Tunggakan Jatuh Tempo
```
[Dashboard] -> [Menu "Peminjaman Aktif"] -> [Filter: status = Terlambat]
    -> [Daftar transaksi yang melewati jatuh tempo ditampilkan]
    -> Petugas dapat menghubungi anggota terkait atau menindaklanjuti sesuai kebijakan perpustakaan
```

## Wireframe: Halaman Login

```
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|        [ Login Petugas ]            |
|                                      |
|   Username : [______________]       |
|   Password : [______________]       |
|                                      |
|          [   Masuk   ]              |
|                                      |
|   Belum punya akun? Daftar di sini  |
+--------------------------------------+
```

## Wireframe: Dashboard Petugas

```
+-----------------------------------------------------+
| SIMPUS-Mini      Beranda | Barang | Anggota | Peminjaman | (Nama Petugas) Logout |
|-------------------------------------------------------|
|  [Total Barang]   [Total Anggota]   [Sedang Dipinjam]    |
|                                                         |
|  Aksi Cepat:                                           |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]            |
|                                                         |
|  Transaksi Terbaru                                     |
|  --------------------------------------------------    |
|  Username | Code | Tgl Pinjam | Status                 |
+-----------------------------------------------------+
```

## Wireframe: Daftar Barang

```
+--------------------------------------------------------------+
| Daftar Barang                                          [+ Tambah Barang] |
|--------------------------------------------------------------|
| Code | Name | Category | Count | Action                      |
|--------------------------------------------------------------|
| B001 | Proyektor | Elektronik | 5 | [Edit] [Hapus]           |
| B002 | Laptop | Elektronik | 3 | [Edit] [Hapus]             |
| B003 | Papan Tulis | ATK | 10 | [Edit] [Hapus]              |
+--------------------------------------------------------------+
```

## Wireframe: Daftar Anggota

```
+--------------------------------------------------------------+
| Daftar Anggota                                        [+ Tambah Anggota] |
|--------------------------------------------------------------|
| Username | Full Name | Password | Action                     |
|--------------------------------------------------------------|
| john_doe | John Doe | ******** | [Edit] [Hapus]             |
| jane_smith | Jane Smith | ******** | [Edit] [Hapus]         |
| budi_santoso | Budi Santoso | ******** | [Edit] [Hapus]     |
+--------------------------------------------------------------+
```

## Wireframe: Form Peminjaman

```
+--------------------------------------+
|  Form Peminjaman Barang              |
|--------------------------------------|
|  Anggota : [ dropdown pilih anggota ]|
|  Barang  : [ dropdown, hanya Count>0 ]|
|  Tanggal Pinjam : [ auto: hari ini ] |
|                                      |
|          [  Simpan Peminjaman  ]    |
+--------------------------------------+
```

## Wireframe: Form Pengembalian

```
+--------------------------------------+
|  Pengembalian Barang                 |
|--------------------------------------|
|  Cari transaksi aktif:               |
|  [ nama anggota / nama barang ______ ]|
|                                      |
|  Username | Code | Tgl Pinjam | [Kembalikan] |
+--------------------------------------+
```

## Wireframe: Riwayat Peminjaman per Anggota

```
+--------------------------------------+
|  Riwayat Peminjaman — Siti Aminah    |
|--------------------------------------|
|  Code | Name        | Pinjam | Kembali | Status   |
|  B001 | Proyektor   | 01/07  | 10/07   | Selesai  |
|  B002 | Laptop      | 15/07  | -       | Dipinjam |
+--------------------------------------+
```

## Edge Case Tambahan
1. **Barang Count habis**: tidak boleh dipilih di form peminjaman; sistem menampilkan pesan "Stok tidak tersedia".
2. **Peminjaman ganda ke anggota yang sama untuk barang yang sama**: jika transaksi aktif (belum dikembalikan) untuk pasangan anggota-barang tersebut sudah ada, sistem menolak dan menampilkan pesan "Barang ini sedang dipinjam oleh anggota tersebut".
3. **Anggota dengan tunggakan melewati jatuh tempo**: pada saat peminjaman baru, sistem memvalidasi apakah anggota memiliki transaksi terlambat; jika ya, peminjaman baru ditolak dan ditampilkan peringatan.
4. **Tanggal pengembalian sebelum tanggal peminjaman**: validasi di sisi server untuk memastikan tanggal kembali >= tanggal pinjam.
5. **Barang yang sedang dipinjam tidak boleh dihapus dari data barang**: integritas referensi harus dijaga.

## Konsistensi dengan Desain yang Sudah Berjalan
- Warna aksen, tipografi navbar, dan gaya tabel/kartu mengikuti `assets/css/style.css` yang sudah dibangun sejak Jobsheet 2-3.
- Navbar akan ditambah menu **Peminjaman** dan indikator status login (nama petugas / tombol Logout) mulai implementasi di Jobsheet 10.
