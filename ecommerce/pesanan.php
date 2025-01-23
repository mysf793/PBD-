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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #343a40;
            font-size: 36px;
            margin-bottom: 30px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #e9ecef;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .order-item p {
            font-size: 16px;
            color: #495057;
            margin: 5px 0;
        }

        .order-item .order-details {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .order-item .order-details a {
            text-decoration: none;
            color: #007bff;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 5px;
            border: 1px solid #007bff;
            margin-left: 15px;
            transition: all 0.3s ease;
        }

        .order-item .order-details a:hover {
            background-color: #007bff;
            color: white;
        }

        .empty-message {
            text-align: center;
            font-size: 18px;
            color: #868e96;
        }

        .order-item .left-info {
            flex: 1;
            margin-right: 20px;
        }

        .order-item .right-info {
            flex: 0 0 auto;
            text-align: right;
        }

        .order-item .right-info p {
            margin-bottom: 5px;
            font-size: 16px;
            font-weight: bold;
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pesanan untuk Anda</h1>

        <?php if (count($pesananList) > 0): ?>
            <?php foreach ($pesananList as $pesanan): ?>
                <div class="order-item">
                    <div class="left-info">
                        <p><strong>ID Pesanan:</strong> <?php echo $pesanan['id_pesanan']; ?></p>
                        <p><strong>Tanggal Pesanan:</strong> <?php echo $pesanan['tanggal_pesanan']; ?></p>
                        <p><strong>Status Pesanan:</strong> <?php echo $pesanan['status']; ?></p>
                    </div>
                    <div class="right-info">
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
