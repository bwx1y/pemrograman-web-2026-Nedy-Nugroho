# Security Checklist — Jobsheet 11

Laporan audit keamanan web terhadap aplikasi inventaris Goods Office.

| # | Kerentanan | Ditemukan di | Sebelum | Sesudah (perbaikan) |
|---|---|---|---|---|
| 1 | **SQL Injection** | `auth/proses_login.php`, `item/*.php`, `category/*.php`, `user/*.php` | Berpotensi bypass login / manipulasi data jika query memakai konkatenasi string langsung. | Sudah aman sejak jobsheet sebelumnya. Seluruh query menggunakan PDO prepared statements (`prepare` + `:param` + `execute`). Uji coba payload `' OR '1'='1` pada login gagal bypass. |
| 2 | **Cross-Site Scripting (XSS)** | `includes/header.php`, `*/index.php`, `*/edit.php` | Output data dari database/`$_GET` dicetak langsung via `echo`, rentan injeksi script HTML/JS. | Seluruh output teks dibungkus fungsi `e()` (`htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`). Uji coba input `<script>alert(1)</script>` dirender sebagai entitas teks murni, bukan script aktif. |
| 3 | **Cross-Site Request Forgery (CSRF)** | Form POST & pemroses di `auth/`, `category/`, `item/`, `user/` | Request POST dapat dipicu situs luar atas nama sesi pengguna login tanpa mekanisme pembuktian asal request. | Ditambahkan token acak kriptografis (`random_bytes(32)`) via `csrf_field()` pada form POST dan diverifikasi via `csrf_verify()` memakai `hash_equals()`. Uji `curl -X POST` tanpa token menghasilkan HTTP 403 Forbidden. |
| 4 | **Validasi & Sanitasi Input** | Handler pemrosesan form dan input hidden ID di form edit/hapus | Nilai ID rentan manipulasi tipe jika dicetak langsung tanpa konversi tipe data. | Validasi ketat (cek wajib isi, regex angka pada jumlah/harga) dan type casting `(int)` eksplisit pada output hidden input `id`. |
| 5 | **Session Fixation** | `auth/proses_login.php` | ID sesi tidak diperbarui setelah login, memungkinkan penyerang membajak sesi yang sudah disiapkan sebelumnya. | Memanggil `session_regenerate_id(true)` tepat setelah `password_verify()` berhasil sebelum mengisi data user ke `$_SESSION`. |

## Catatan Implementasi

- **Urutan Guard:** File `includes/auth.php` selalu dipanggil **sebelum** `includes/csrf.php` dan `csrf_verify()` pada seluruh skrip proses. Pengguna tanpa autentikasi langsung diredirect ke login sebelum validasi token CSRF diproses.
