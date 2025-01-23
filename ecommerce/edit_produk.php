<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Penjual') {
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


$sql_kategori = "SELECT * FROM kategori";
$stmt_kategori = $pdo->query($sql_kategori);
$kategoriList = $stmt_kategori->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $id_kategori = $_POST['id_kategori'];

 
    if (empty($nama_produk) || empty($deskripsi) || empty($harga) || empty($stok) || empty($id_kategori)) {
        $error = "Semua field harus diisi.";
    } else {
       
        $sql_update = "UPDATE produk SET nama_produk = :nama_produk, deskripsi = :deskripsi, harga = :harga, stok = :stok, id_kategori = :id_kategori WHERE id_produk = :id_produk";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':nama_produk', $nama_produk);
        $stmt_update->bindParam(':deskripsi', $deskripsi);
        $stmt_update->bindParam(':harga', $harga);
        $stmt_update->bindParam(':stok', $stok);
        $stmt_update->bindParam(':id_kategori', $id_kategori);
        $stmt_update->bindParam(':id_produk', $id_produk);

        if ($stmt_update->execute()) {
            $success = "Produk berhasil diperbarui!";
        } else {
            $error = "Terjadi kesalahan, produk gagal diperbarui.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 30px;
            margin-bottom: 30px;
        }

        label {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            font-size: 16px;
            margin: 10px 0;
        }

        .message.error {
            color: red;
        }

        .message.success {
            color: green;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            font-size: 14px;
        }

        .form-group textarea {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Edit Produk</h1>

        <?php if (isset($error)): ?>
            <p class="message error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <p class="message success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" name="nama_produk" id="nama_produk" value="<?php echo $produk['nama_produk']; ?>" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" required><?php echo $produk['deskripsi']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="harga">Harga (Rp):</label>
                <input type="number" name="harga" id="harga" value="<?php echo $produk['harga']; ?>" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" name="stok" id="stok" value="<?php echo $produk['stok']; ?>" min="0" required>
            </div>

            <div class="form-group">
                <label for="id_kategori">Kategori:</label>
                <select name="id_kategori" id="id_kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategoriList as $kategori): ?>
                        <option value="<?php echo $kategori['id_kategori']; ?>" <?php echo ($produk['id_kategori'] == $kategori['id_kategori']) ? 'selected' : ''; ?>>
                            <?php echo $kategori['nama_kategori']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">Perbarui Produk</button>
        </form>
    </div>

</body>
</html>
