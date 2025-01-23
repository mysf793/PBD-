<?php
session_start();
include('db.php');


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Pembeli') {
    header('Location: login.php');
    exit();
}


if (!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0) {
    echo "Keranjang belanja Anda kosong. Silakan tambahkan produk ke keranjang.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pemesanan</title>
    <style>

    </style>
</head>
<body>

    <div class="container">
        <h1>Konfirmasi Pemesanan</h1>

        <div class="order-summary">
            <h3>Rincian Pesanan</h3>
            <?php
            $total = 0;
            foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
                $sql = "SELECT * FROM produk WHERE id_produk = :id_produk";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id_produk' => $id_produk]);
                $produk = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($produk) {
                    $subtotal = $produk['harga'] * $jumlah;
                    $total += $subtotal;
                    echo "<p>{$produk['nama_produk']} x $jumlah - Rp " . number_format($subtotal, 2, ',', '.') . "</p>";
                }
            }
            ?>
            <p class="total">Total: Rp <?php echo number_format($total, 2, ',', '.'); ?></p>
        </div>

        <div class="order-actions">
            <form method="POST" action="pesan.php">
                <button type="submit">Konfirmasi dan Lanjutkan ke Pembayaran</button>
            </form>
        </div>
    </div>

</body>
</html>
