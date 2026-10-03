-- Jobsheet 10: Migrasi tabel "user" untuk autentikasi
-- Jalankan: psql -d pemerogaman_web_db -f sql/02_users.sql
--
-- Tabel "user" sudah ada di 01_schema.sql.
-- Script ini menambahkan DEFAULT pada kolom role agar akun baru
-- otomatis berperan 'Staff' tanpa harus disebut di INSERT,
-- lalu meng-update seed password yang masih plaintext ('********')
-- menjadi hash bcrypt yang dihasilkan oleh password_hash('password123', PASSWORD_DEFAULT).
--
-- CATATAN: Untuk akun baru, password harus di-hash di PHP
-- menggunakan password_hash() saat registrasi — bukan di SQL.

-- 1. Tambah DEFAULT 'Staff' pada kolom role
ALTER TABLE "user"
    ALTER COLUMN role SET DEFAULT 'Staff';

-- 2. Aktifkan pgcrypto agar bisa hash password di SQL (seed saja)
CREATE EXTENSION IF NOT EXISTS pgcrypto;

-- 3. Update seed user yang masih pakai password plaintext '********'
--    menjadi hash bcrypt (password asli: 'password123')
UPDATE "user"
SET password = crypt('password123', gen_salt('bf'))
WHERE password = '********';
