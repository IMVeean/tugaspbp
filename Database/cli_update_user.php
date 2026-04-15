<?php
$host = 'localhost';
$db   = 'pbp2026';
$user = 'root';
$pass = '';

// ==========================
// KONEKSI DATABASE
// ==========================
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Koneksi DB gagal: " . $e->getMessage());
}

// ==========================
// FUNGSI UPDATE USER
// ==========================
function update_user($username, $newEmail, $newPassword) {
    global $pdo;

    try {
        $sql = "
        UPDATE user
        SET email = :email,
            password_hash = :password_hash,
            updated_at = :updated_at
        WHERE username = :username
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':email' => $newEmail,
            ':password_hash' => password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 13]),
            ':updated_at' => time(),
            ':username' => $username
        ]);

        if ($stmt->rowCount() > 0) {
            echo "User berhasil diupdate.\n";
            echo "Username : $username\n";
            echo "Email baru : $newEmail\n";
        } else {
            echo "User tidak ditemukan atau tidak ada perubahan.\n";
        }

    } catch (Exception $e) {
        die("Update gagal: " . $e->getMessage());
    }
}

// ==========================
// MAIN CLI
// ==========================
if ($argc < 4) {
    echo "Cara pakai:\n";
    echo "php cli_update_user.php username email password\n";
    exit;
}

$username = $argv[1];
$email = $argv[2];
$password = $argv[3];

update_user($username, $email, $password);