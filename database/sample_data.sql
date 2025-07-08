-- Insert sample food data based on Indonesian foods
INSERT INTO makanan (nama, kategori, kalori, protein, lemak, karbohidrat, serat, kalsium, zat_besi, vitamin_a, vitamin_c) VALUES
-- Makanan Pokok
('Nasi Putih', 'pokok', 130, 2.7, 0.3, 28, 0.4, 10, 0.8, 0, 0),
('Nasi Merah', 'pokok', 111, 2.3, 0.9, 23, 1.8, 16, 1.5, 0, 0),
('Roti Tawar', 'pokok', 265, 9, 3.2, 49, 2.7, 95, 3.6, 0, 0),
('Kentang Rebus', 'pokok', 77, 2, 0.1, 17, 2.2, 12, 0.8, 2, 20),
('Singkong Rebus', 'pokok', 160, 1.4, 0.3, 38, 1.8, 16, 0.3, 13, 21),

-- Lauk Hewani
('Ayam Goreng', 'lauk_hewani', 250, 25, 15, 0, 0, 14, 1.3, 16, 0),
('Ikan Bandeng', 'lauk_hewani', 129, 20, 4.8, 0, 0, 20, 2, 150, 0),
('Telur Ayam', 'lauk_hewani', 155, 13, 11, 1.1, 0, 56, 1.8, 140, 0),
('Daging Sapi', 'lauk_hewani', 207, 26, 11, 0, 0, 11, 2.9, 0, 0),
('Ikan Lele', 'lauk_hewani', 229, 18, 13, 8.6, 0, 15, 1.6, 60, 0),

-- Lauk Nabati
('Tahu Goreng', 'lauk_nabati', 270, 17, 20, 10, 2, 350, 2.7, 0, 0),
('Tempe Goreng', 'lauk_nabati', 190, 19, 11, 9, 9, 155, 4, 0, 0),
('Kacang Tanah', 'lauk_nabati', 567, 26, 49, 16, 8.5, 92, 4.6, 0, 0),
('Kacang Hijau', 'lauk_nabati', 345, 22, 1.2, 63, 16, 125, 6.7, 6, 4.8),

-- Sayuran
('Bayam', 'sayuran', 23, 2.9, 0.4, 3.6, 2.2, 99, 2.7, 469, 28),
('Kangkung', 'sayuran', 19, 1.8, 0.2, 3.9, 2.5, 67, 2.3, 315, 55),
('Wortel', 'sayuran', 41, 0.9, 0.2, 10, 2.8, 33, 0.3, 835, 5.9),
('Brokoli', 'sayuran', 34, 2.8, 0.4, 7, 2.6, 47, 0.7, 31, 89),
('Kol', 'sayuran', 25, 1.3, 0.1, 6, 2.5, 40, 0.5, 5, 37),
('Tomat', 'sayuran', 18, 0.9, 0.2, 3.9, 1.2, 10, 0.3, 42, 14),

-- Buah-buahan
('Pisang', 'buah', 89, 1.1, 0.3, 23, 2.6, 5, 0.3, 3, 8.7),
('Jeruk', 'buah', 47, 0.9, 0.1, 12, 2.4, 40, 0.1, 11, 53),
('Apel', 'buah', 52, 0.3, 0.2, 14, 2.4, 6, 0.1, 3, 4.6),
('Pepaya', 'buah', 43, 0.5, 0.3, 11, 1.7, 20, 0.3, 47, 61),
('Mangga', 'buah', 60, 0.8, 0.4, 15, 1.6, 11, 0.2, 54, 37),
('Semangka', 'buah', 30, 0.6, 0.2, 8, 0.4, 7, 0.2, 28, 8.1);

-- Insert AKG reference data based on Indonesian Ministry of Health guidelines
INSERT INTO akg_referensi (kelompok_umur, jenis_kelamin, berat_badan, tinggi_badan, energi, protein, lemak, karbohidrat, serat, kalsium, zat_besi, vitamin_a, vitamin_c) VALUES
-- Dewasa 19-29 tahun
('19-29 tahun', 'L', 62, 168, 2650, 65, 73, 430, 37, 1000, 9, 600, 90),
('19-29 tahun', 'P', 54, 159, 2250, 60, 62, 360, 32, 1000, 18, 500, 75),

-- Dewasa 30-49 tahun
('30-49 tahun', 'L', 62, 168, 2650, 65, 73, 430, 36, 1000, 9, 600, 90),
('30-49 tahun', 'P', 54, 159, 2150, 60, 60, 340, 30, 1000, 18, 500, 75),

-- Dewasa 50-64 tahun
('50-64 tahun', 'L', 62, 168, 2150, 65, 60, 340, 30, 1000, 9, 600, 90),
('50-64 tahun', 'P', 54, 159, 1900, 60, 53, 300, 27, 1200, 8, 500, 75),

-- Ibu Hamil (tambahan)
('Hamil Trimester 1', 'P', 54, 159, 2250, 60, 62, 360, 32, 1200, 27, 800, 85),
('Hamil Trimester 2', 'P', 54, 159, 2550, 70, 71, 410, 36, 1200, 27, 800, 85),
('Hamil Trimester 3', 'P', 54, 159, 2550, 70, 71, 410, 36, 1200, 27, 800, 85),

-- Ibu Menyusui
('Menyusui 0-6 bulan', 'P', 54, 159, 2750, 75, 76, 440, 38, 1200, 22, 850, 120),
('Menyusui 7-24 bulan', 'P', 54, 159, 2500, 68, 69, 400, 35, 1200, 22, 850, 120);

-- Tabel untuk postingan komunitas
CREATE TABLE IF NOT EXISTS community_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    content TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    likes INT DEFAULT 0,
    comments INT DEFAULT 0
);

-- Tabel untuk challenge komunitas
CREATE TABLE IF NOT EXISTS community_challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    participants INT DEFAULT 0,
    days_left INT DEFAULT 0,
    reward VARCHAR(100)
);

-- Contoh data challenge
INSERT INTO community_challenges (title, description, participants, days_left, reward) VALUES
('30 Hari Makan Sayur', 'Konsumsi minimal 5 porsi sayuran setiap hari', 234, 12, 'Badge Veggie Master'),
('Hidrasi Challenge', 'Minum 8 gelas air putih setiap hari', 156, 5, 'Badge Hydration Hero'),
('Protein Power Month', 'Capai target protein harian selama 30 hari', 89, 18, 'Badge Protein Pro');
