<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Pembeli') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $id_produk = filter_input(INPUT_POST, 'id_produk', FILTER_SANITIZE_NUMBER_INT);
    $jumlah = filter_input(INPUT_POST, 'jumlah', FILTER_SANITIZE_NUMBER_INT);

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk] += $jumlah;
    } else {
        $_SESSION['keranjang'][$id_produk] = $jumlah;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
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

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .cart-item h3 {
            font-size: 20px;
            margin: 0;
            color: #333;
        }

        .cart-item p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }

        .cart-item .subtotal {
            font-weight: bold;
            color: #28a745;
        }

        .total {
            font-size: 24px;
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }

        .cart-actions {
            margin-top: 30px;
            text-align: center;
        }

        .cart-actions button {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 4px;
            cursor: pointer;
        }

        .cart-actions button:hover {
            background-color: #0056b3;
        }

        .empty-cart {
            text-align: center;
            font-size: 18px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0) {
            $ids_produk = implode(',', array_map('intval', array_keys($_SESSION['keranjang'])));
            $sql = "SELECT * FROM produk WHERE id_produk IN ($ids_produk)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $produkList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $total = 0;
            foreach ($produkList as $produk) {
                $jumlah = $_SESSION['keranjang'][$produk['id_produk']];
                $subtotal = $produk['harga'] * $jumlah;
                $total += $subtotal;
                echo "<div class='cart-item'>
                    <div>
                        <h3>{$produk['nama_produk']}</h3>
                        <p>Jumlah: $jumlah</p>
                        <p class='subtotal'>Subtotal: Rp " . number_format($subtotal, 2, ',', '.') . "</p>
                    </div>
                </div>";
            }
            echo "<div class='total'>
                    <p>Total: Rp " . number_format($total, 2, ',', '.') . "</p>
                  </div>";
            echo "<div class='cart-actions'>
                    <form method='post' action='pesan.php'>
                        <button type='submit'>Lanjutkan ke Pemesanan</button>
                    </form>
                  </div>";
        } else {
            echo "<div class='empty-cart'>Keranjang kosong.</div>";
        }
        ?>
    </div>
</body>
</html>