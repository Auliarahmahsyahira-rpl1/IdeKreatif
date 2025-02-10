<?php
// Menghubungkan filekonfigurasi database
include 'config.php';

// Memulai sesi php
session_start();

// Mendapatkan ID pengguna dari sesi
$userId = $_SESSION["user_id"];

// Menangani form untuk menambahkan postingan baru
if (isset($_POST['simpan'])) {
    // Mendapatkan data dari form
    $postTitle = $_POST["post_title"]; //Judul postingan
    $content = $_POST["content"]; // Konten postingan
    $categoryId = $_POST["category_id"]; // Id kategori

    // Mengatur direktori penyimpanan file gambar
    $imageDir = "assets/img/uploads/";
    $imageName = $_FILES["image"]["name"];
    $imagePath = $imageDir . basename($imageName); // Path lengkap gambar

    // Memindahkan file gambar yang di unggah ke direktori tujuan
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
        //Jika unggahan berhasil, masukkan
        // data postingan ke dalam database
        $query = "INSERT INTO posts (post_title, content, created_at, category_id, user_id, image_path) VALUES ('$postTitle', '$content', NOW(), $categoryId, $userId, '$imagePath')";

        if ($conn->query($query) == TRUE) {
            // Notifikasi berhasil jika postingan berhasil
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Post successfully added.'
            ];
        } else {
            // Notifikasi eror jika gagal menambahkan postingan
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Error adding post: ' . $conn->erorr
            ];
        }
    } else {
        // notifikasi eror jika unggahan gambar gagal
        $_SESSION['notification'] =[
            'type' => 'danger',
            'message' => 'Failed to upload image.'
        ];
    }

    // Arahkan ke halaman dashboard setelah selesai
    header('Location: dashboard.php');
    exit(); 
}