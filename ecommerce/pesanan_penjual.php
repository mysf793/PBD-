<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Penjual') {
    header('Location: login.php');
    exit();
}

$id_penjual = $_SESSION['user_id'];
$sql = "SELECT * FROM pesanan
        JOIN detail_pesanan ON pesanan.id_pesanan = detail_pesanan.id_pesanan
        WHERE detail_pesanan.id_produk IN (SELECT id_produk FROM produk WHERE id_penjual = :id_penjual)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_penjual', $id_penjual);
$stmt->execute();
$pesananList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan untuk Penjual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 32px;
            margin-bottom: 30px;
        }

        .order-item {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .order-item p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .order-item strong {
            color: #333;
        }

        .order-item .order-details {
            margin-top: 10px;
            text-align: center;
        }

        .order-item .order-details a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            font-size: 16px;
        }

        .order-item .order-details a:hover {
            text-decoration: underline;
        }

        .empty-message {
            text-align: center;
            font-size: 18px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pesanan untuk Anda</h1>
        
        <?php if (count($pesananList) > 0): ?>
            <?php foreach ($pesananList as $pesanan): ?>
                <div class="order-item">
                    <p><strong>ID Pesanan:</strong> <?php echo $pesanan['id_pesanan']; ?></p>
                    <p><strong>Tanggal Pesanan:</strong> <?php echo $pesanan['tanggal_pesanan']; ?></p>
                    <p><strong>Status Pesanan:</strong> <?php echo $pesanan['status']; ?></p>
                    <div class="order-details">
                        <a href="detail_pesanan_penjual.php?id=<?php echo $pesanan['id_pesanan']; ?>">Lihat Detail</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty-message">Tidak ada pesanan untuk ditampilkan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
