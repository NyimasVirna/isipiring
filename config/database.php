<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'projec15_nutrition_db');
define('DB_USER', 'projec15_root');
define('DB_PASS', '@kaesquare123');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create tables if they don't exist
function createTables($pdo) {
    $tables = [
        // Users table
        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            tanggal_lahir DATE,
            jenis_kelamin ENUM('L', 'P') NOT NULL,
            tinggi_badan INT,
            berat_badan DECIMAL(5,2),
            tingkat_aktivitas ENUM('ringan', 'sedang', 'berat') DEFAULT 'sedang',
            kondisi_khusus JSON,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )",

        // Food database table
        "CREATE TABLE IF NOT EXISTS makanan (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(100) NOT NULL,
            kategori ENUM('pokok', 'lauk_hewani', 'lauk_nabati', 'sayuran', 'buah') NOT NULL,
            kalori DECIMAL(6,2) NOT NULL,
            protein DECIMAL(6,2) NOT NULL,
            lemak DECIMAL(6,2) NOT NULL,
            karbohidrat DECIMAL(6,2) NOT NULL,
            serat DECIMAL(6,2) NOT NULL,
            kalsium DECIMAL(6,2) DEFAULT 0,
            zat_besi DECIMAL(6,2) DEFAULT 0,
            vitamin_a DECIMAL(6,2) DEFAULT 0,
            vitamin_c DECIMAL(6,2) DEFAULT 0,
            satuan VARCHAR(20) DEFAULT 'gram',
            berat_per_porsi INT DEFAULT 100,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",

        // Food log table
        "CREATE TABLE IF NOT EXISTS log_makanan (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            makanan_id INT NOT NULL,
            waktu_makan ENUM('sarapan', 'makan_siang', 'makan_malam', 'camilan') NOT NULL,
            porsi DECIMAL(6,2) NOT NULL,
            tanggal DATE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (makanan_id) REFERENCES makanan(id) ON DELETE CASCADE
        )",

        // AKG reference table
        "CREATE TABLE IF NOT EXISTS akg_referensi (
            id INT AUTO_INCREMENT PRIMARY KEY,
            kelompok_umur VARCHAR(50) NOT NULL,
            jenis_kelamin ENUM('L', 'P') NOT NULL,
            berat_badan DECIMAL(5,2),
            tinggi_badan INT,
            energi INT NOT NULL,
            protein DECIMAL(6,2) NOT NULL,
            lemak DECIMAL(6,2) NOT NULL,
            karbohidrat DECIMAL(6,2) NOT NULL,
            serat DECIMAL(6,2) NOT NULL,
            kalsium DECIMAL(6,2) NOT NULL,
            zat_besi DECIMAL(6,2) NOT NULL,
            vitamin_a DECIMAL(6,2) NOT NULL,
            vitamin_c DECIMAL(6,2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    ];

    foreach ($tables as $sql) {
        $pdo->exec($sql);
    }
}

// Initialize tables
createTables($pdo);
?>
