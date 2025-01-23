<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Pembeli') {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit();
}

$id_produk = $_GET['id'];
$sql = "SELECT * FROM produk WHERE id_produk = :id_produk";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_produk', $id_produk);
$stmt->execute();
$produk = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .product-image {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .product-image img {
            width: 100%;
            border-radius: 8px;
        }

        .product-details {
            text-align: center;
            margin-bottom: 30px;
        }

        .product-details h1 {
            font-size: 32px;
            color: #333;
            margin: 10px 0;
        }

        .product-details p {
            font-size: 18px;
            color: #555;
            margin: 5px 0;
        }

        .product-details .price {
            font-size: 22px;
            color: #007bff;
            margin: 10px 0;
        }

        .product-details .stock {
            font-size: 18px;
            color: #28a745;
        }

        .add-to-cart-form {
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .add-to-cart-form label {
            font-size: 16px;
            color: #333;
        }

        .add-to-cart-form input {
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
            width: 100px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .add-to-cart-form button {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            margin-top: 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-to-cart-form button:hover {
            background-color: #218838;
        }

        .error-message {
            color: red;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="product-image">
            <img src="data:image/jpeg;base64,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" alt="Gambar Produk">
        </div>
        <div class="product-details">
            <h1><?php echo $produk['nama_produk']; ?></h1>
            <p><?php echo $produk['deskripsi']; ?></p>
            <p class="price">Harga: Rp <?php echo number_format($produk['harga'], 2, ',', '.'); ?></p>
            <p class="stock">Stok: <?php echo $produk['stok']; ?></p>
        </div>

        <div class="add-to-cart-form">
            <form method="post" action="keranjang.php">
                <label for="jumlah">Jumlah:</label>
                <input type="number" name="jumlah" id="jumlah" min="1" max="<?php echo $produk['stok']; ?>" required>
                <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
                <button type="submit">Tambahkan ke Keranjang</button>
            </form>
        </div>
    </div>
</body>
</html>
