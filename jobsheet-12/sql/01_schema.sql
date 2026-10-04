-- Jobsheet 8: Skema Database dengan Relasi (PostgreSQL)
-- Database Name: pemerogaman_web_db

-- 1. Tabel category (Master Data Kategori)
CREATE TABLE IF NOT EXISTS category (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT
);

-- 2. Tabel "user" (Master Data Pengguna)
CREATE TABLE IF NOT EXISTS "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    birth_date VARCHAR(50),
    age INTEGER,
    phone VARCHAR(50),
    password VARCHAR(255) NOT NULL
);

-- 3. Tabel kategori (Master Data Kategori Bahasa Indonesia)
CREATE TABLE IF NOT EXISTS kategori (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL UNIQUE
);

-- 4. Tabel item (Barang Inventaris dengan Relasi Foreign Key)
CREATE TABLE IF NOT EXISTS item (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    category_id INTEGER REFERENCES category(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    category VARCHAR(100) NOT NULL REFERENCES category(name) ON UPDATE CASCADE ON DELETE RESTRICT,
    count INTEGER NOT NULL DEFAULT 0,
    price VARCHAR(100) NOT NULL,
    status VARCHAR(50) NOT NULL
);

-- Seeding Data Category
INSERT INTO category (name, description) VALUES
('Electronic Components', 'Electronic components and modules'),
('IT Devices', 'Laptops, PCs, and technology devices'),
('Office Supplies', 'Paper, pens, and office equipment'),
('Furniture', 'Desks, chairs, and office furniture')
ON CONFLICT (name) DO NOTHING;

-- Seeding Data Kategori
INSERT INTO kategori (nama) VALUES
('Electronic Components'),
('IT Devices'),
('Office Supplies'),
('Furniture')
ON CONFLICT (nama) DO NOTHING;

-- Seeding Data User
INSERT INTO "user" (username, name, role, birth_date, age, phone, password) VALUES
('john_doe', 'John Doe', 'Admin', '15-03-1990', 36, '081234567890', '********'),
('jane_smith', 'Jane Smith', 'Staff', '22-07-1988', 38, '082345678901', '********'),
('budi_santoso', 'Budi Santoso', 'Member', '10-11-1995', 30, '083456789012', '********'),
('siti_rahayu', 'Siti Rahayu', 'Member', '05-01-1992', 34, '084567890123', '********'),
('ahmad_fauzi', 'Ahmad Fauzi', 'Staff', '28-09-1993', 32, '085678901234', '********')
ON CONFLICT (username) DO NOTHING;

-- Seeding Data Item (dengan relasi category_id )
INSERT INTO item (code, name, category_id, category, count, price, status) VALUES
('ELK-001', 'Digital Voltmeter', 1, 'Electronic Components',  20, 'Rp 250.000', 'Good'),
('ELK-002', 'Segment Display Module', 1, 'Electronic Components',  50, 'Rp 35.000', 'Good'),
('IT-015', 'Laptop ASUS Vivobook', 2, 'IT Devices',  12, 'Rp 8.500.000', 'Good'),
('ATK-022', 'HVS A4 80gr Paper', 3, 'Office Supplies',  150, 'Rp 55.000', 'Good'),
('PRB-008', 'Ergonomic Office Chair', 4, 'Furniture',  25, 'Rp 1.200.000', 'Damaged')
ON CONFLICT (code) DO NOTHING;
