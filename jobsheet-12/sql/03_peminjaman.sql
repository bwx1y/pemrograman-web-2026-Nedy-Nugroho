-- Jobsheet 12: Tabel peminjaman barang inventaris (menghubungkan item dan "user")
-- Database Name: pemerogaman_web_db
-- Jalankan: psql -d pemerogaman_web_db -f sql/03_peminjaman.sql

CREATE TABLE IF NOT EXISTS peminjaman (
    id SERIAL PRIMARY KEY,
    item_id INTEGER NOT NULL REFERENCES item(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    user_id INTEGER NOT NULL REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_kembali DATE,
    status VARCHAR(20) NOT NULL DEFAULT 'dipinjam'
);
