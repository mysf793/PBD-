<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Pembeli') {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM produk";
$stmt = $pdo->query($sql);
$produkList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
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

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-item {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-item h3 {
            font-size: 24px;
            color: #343a40;
            margin-bottom: 10px;
        }

        .product-item p {
            font-size: 16px;
            color: #495057;
            margin: 5px 0;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-top: 10px;
        }

        .product-item .product-details {
            text-align: center;
            margin-top: 15px;
        }

        .product-item .product-details a {
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .product-item .product-details a:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Daftar Produk</h1>

        <div class="product-list">
            <?php foreach ($produkList as $produk): ?>
                <div class="product-item">
                    <h3><?php echo $produk['nama_produk']; ?></h3>
                    <p><?php echo $produk['deskripsi']; ?></p>
                    <p class="price">Harga: Rp <?php echo number_format($produk['harga'], 2, ',', '.'); ?></p>
                    <p>Stok: <?php echo $produk['stok']; ?></p>
                    <div class="product-details">
                        <a href="detail_produk.php?id=<?php echo $produk['id_produk']; ?>">Lihat Detail</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
