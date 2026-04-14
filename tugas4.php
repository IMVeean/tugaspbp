//update database 
<?php
$host = 'localhost';
$db   = 'pbp2026';
$user = 'root';
$pass = 'password_baru';

//konfigurasi database
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Koneksi DB gagal: " . $e->getMessage());
}
// Ambil input dari terminal
$id    = readline("Masukkan ID yang mau di-update: ");
$email = readline("Masukkan Email baru: ");

// Update Query
$sql = "UPDATE user SET email = :email, updated_at = :time WHERE id = :id";
$stmt = $pdo->prepare($sql);

// Eksekusi langsung
$stmt->execute([
    ':email' => $email,
    ':id'    => $id,
    ':time'  => time()
]);
echo "Selesai! Cek database kamu sekarang.\n";
?>