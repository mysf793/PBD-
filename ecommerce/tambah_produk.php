<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Penjual') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $id_kategori = $_POST['id_kategori'];
    $id_penjual = $_SESSION['user_id'];

    
    if (empty($nama_produk) || empty($deskripsi) || empty($harga) || empty($stok) || empty($id_kategori)) {
        $error = "Semua field harus diisi.";
    } else {
        
        $sql = "INSERT INTO produk (nama_produk, deskripsi, harga, stok, id_kategori, id_penjual)
                VALUES (:nama_produk, :deskripsi, :harga, :stok, :id_kategori, :id_penjual)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nama_produk', $nama_produk);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':id_kategori', $id_kategori);
        $stmt->bindParam(':id_penjual', $id_penjual);

        if ($stmt->execute()) {
            $success = "Produk berhasil ditambahkan!";
        } else {
            $error = "Terjadi kesalahan, produk gagal ditambahkan.";
        }
    }
}


$sql_kategori = "SELECT * FROM kategori";
$stmt_kategori = $pdo->query($sql_kategori);
$kategoriList = $stmt_kategori->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
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
        <h1>Tambah Produk Baru</h1>

        <?php if (isset($error)): ?>
            <p class="message error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <p class="message success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" name="nama_produk" id="nama_produk" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" required></textarea>
            </div>

            <div class="form-group">
                <label for="harga">Harga (Rp):</label>
                <input type="number" name="harga" id="harga" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" name="stok" id="stok" min="0" required>
            </div>

            <div class="form-group">
                <label for="id_kategori">Kategori:</label>
                <select name="id_kategori" id="id_kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategoriList as $kategori): ?>
                        <option value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['nama_kategori']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">Tambah Produk</button>
        </form>
    </div>

</body>
</html>
