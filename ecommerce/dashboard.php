<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .welcome-message {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .role-links {
            margin-top: 20px;
        }

        .role-links a {
            display: block;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 10px;
            text-align: center;
        }

        .role-links a:hover {
            background-color: #0056b3;
        }

        .logout-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-size: 16px;
        }

        .logout-link a {
            text-decoration: none;
            color: #007bff;
        }

        .logout-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-message">
            <?php
            echo "Selamat datang, " . htmlspecialchars($_SESSION['role']) . "!";
            ?>
        </div>

        <div class="role-links">
            <?php
            if ($_SESSION['role'] == 'Pembeli') {
                echo "<a href='produk_pembeli.php'>Lihat Produk</a>";
                echo "<a href='pesanan.php'>Lihat Pesanan</a>";
            } elseif ($_SESSION['role'] == 'Penjual') {
                echo "<a href='produk_penjual.php'>Kelola Produk</a>";
                echo "<a href='pesanan_penjual.php'>Lihat Pesanan</a>";
            }
            ?>
        </div>

        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
