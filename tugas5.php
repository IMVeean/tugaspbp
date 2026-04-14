<?php
#menjalankan kode php di web server
#koneksi database

$host = 'localhost';
$db   = 'pbp2026';
$user = 'root';
$pass = 'password_baru';

try {
    // 1. Koneksi Database
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // 2. Logika Update
    $pesan = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $usernamebaru = $_POST['username'];

        $sql = "UPDATE user SET username = :username, updated_at = :time WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $usernamebaru,
            ':id'       => $id,
            ':time'     => time()
        ]);
        
        if ($stmt->rowCount() > 0) {
            $pesan = "<div class='alert success'>Sukses! Data ID $id berhasil diperbarui.</div>";
        } else {
            $pesan = "<div class='alert warning'>Data tidak berubah atau ID tidak ditemukan.</div>";
        }
    }
} catch (PDOException $e) {
    // Menangkap error koneksi maupun query
    $pesan = "<div class='alert error'>Terjadi Kesalahan: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 5 - Update User</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            margin-bottom: 30px;
        }
        h2, h3 { color: #333; text-align: center; }
        
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        
        input[type="number"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Agar padding tidak merusak lebar */
        }
        
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        button:hover { background-color: #0056b3; }

        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f9f9f9; }

        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .warning { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Update User</h2>
        
        <?php echo $pesan; ?>

        <form method="POST" action="">
            <label>ID User:</label>
            <input type="number" name="id" placeholder="Contoh: 1" required>

            <label>Username Baru:</label>
            <input type="text" name="username" placeholder="Masukkan nama baru..." required>

            <button type="submit">Update Data Sekarang</button>
        </form>
    </div>

    <h3>Daftar User di Database</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = $pdo->query("SELECT id, username, email FROM user");
            if ($query->rowCount() > 0) {
                while ($row = $query->fetch()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3' style='text-align:center;'>Tidak ada data.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
</body>
</html>