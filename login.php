<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = ""; // ganti dengan password MySQL Anda
$dbname = "book-chapter"; // nama database

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mendapatkan pengguna berdasarkan email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Jika berhasil login
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                          icon: 'success',
                          title: 'Login Berhasil!',
                          text: 'Selamat datang, " . $user['email'] . "!'
                        }).then((result) => {
                          window.location.href = 'index.html';
                        });
                    });
                  </script>";
        } else {
            // Password salah
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Password salah!'
                        }).then((result) => {
                          window.location.href = 'login.html';
                        });
                    });
                  </script>";
        }
    } else {
        // Email tidak ditemukan
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Email tidak ditemukan!'
                    }).then((result) => {
                      window.location.href = 'login.html';
                    });
                });
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
