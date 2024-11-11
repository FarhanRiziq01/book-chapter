<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = ""; // ganti dengan password MySQL Anda jika ada
$dbname = "book-chapter"; // nama database

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // Validasi password
    if ($password !== $password2) {
        echo "<script>
                showMessage('Password tidak cocok!', false);
              </script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data ke database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        // Menampilkan modal sukses dan redirect ke login
        echo "<script>
                showMessage('Registrasi berhasil! Anda akan diarahkan ke halaman login.', true);
              </script>";
    } else {
        // Menampilkan pesan error jika gagal
        echo "<script>
                showMessage('Error: " . $stmt->error . "', false);
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
