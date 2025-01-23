<?php
include('db.php');

if (isset($_POST['register'])) {

    $nama_user = $_POST['nama_user'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  
    $role = $_POST['role'];

  
    $sql = "INSERT INTO users (nama_user, email, alamat, telepon, password, role) 
            VALUES (:nama_user, :email, :alamat, :telepon, :password, :role)";
    

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nama_user', $nama_user);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':telepon', $telepon);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        
        echo "Registrasi berhasil! <br>";
        echo "Anda akan diarahkan ke halaman login dalam 3 detik.";
        header("refresh:3; url=login.php");  
        exit();
    } else {
        echo "Gagal registrasi! Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
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
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
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

        p {
            text-align: center;
            font-size: 16px;
            color: #555;
        }

        p a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Registrasi Akun</h1>
        
        <form method="post">
            <div class="form-group">
                <label for="nama_user">Nama Lengkap</label>
                <input type="text" name="nama_user" id="nama_user" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" required></textarea>
            </div>

            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="text" name="telepon" id="telepon">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="Pembeli">Pembeli</option>
                    <option value="Penjual">Penjual</option>
                </select>
            </div>

            <button type="submit" name="register">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>

</body>
</html>
