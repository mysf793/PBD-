<?php
session_start();
include('db.php');

/
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Penjual') {
    header('Location: login.php');
    exit();
}


if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    
    $sql = "DELETE FROM produk WHERE id_produk = :id_produk";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_produk', $id_produk);

   
    if ($stmt->execute()) {
       
        header('Location: produk_penjual.php?message=Produk berhasil dihapus');
        exit();
    } else {
        echo "Terjadi kesalahan, produk gagal dihapus.";
    }
} else {
    echo "ID produk tidak ditemukan.";
}
?>