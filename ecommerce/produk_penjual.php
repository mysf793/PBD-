<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Penjual') {
    header('Location: login.php');
    exit();
}

$id_penjual = $_SESSION['user_id'];
$sql = "SELECT * FROM produk WHERE id_penjual = :id_penjual";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_penjual', $id_penjual);
$stmt->execute();
$produkList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk Anda</title>
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

        .product-item .product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .product-item .product-actions a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .product-item .product-actions a.edit {
            background-color: #28a745;
            color: white;
        }

        .product-item .product-actions a.edit:hover {
            background-color: #218838;
        }

        .product-item .product-actions a.delete {
            background-color: #dc3545;
            color: white;
        }

        .product-item .product-actions a.delete:hover {
            background-color: #c82333;
        }

        .add-product {
            display: block;
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 30px;
            width: fit-content;
            margin: 30px auto;
            transition: background-color 0.3s ease;
        }

        .add-product:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Kelola Produk Anda</h1>

        <div class="product-list">
            <?php foreach ($produkList as $produk): ?>
                <div class="product-item">
                    <h3><?php echo $produk['nama_produk']; ?></h3>
                    <p>Harga: Rp <?php echo number_format($produk['harga'], 2, ',', '.'); ?></p>
                    <p>Stok: <?php echo $produk['stok']; ?></p>
                    <div class="product-actions">
                        <a href="edit_produk.php?id=<?php echo $produk['id_produk']; ?>" class="edit">Edit</a>
                        <a href="hapus_produk.php?id=<?php echo $produk['id_produk']; ?>" class="delete" onclick="return confirm('Anda yakin ingin menghapus produk ini?')">Hapus</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="tambah_produk.php" class="add-product">Tambah Produk Baru</a>
    </div>

</body>
</html>
