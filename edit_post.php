<?php
// Memasukkan file konfigurasi database
include 'config.php';

// memasukkan header halaman
include '.includes/header.php';

// mengambil id postingan yang akan diedit dari parameter url
// ../edit_post.php?post_id=
$postIdToEdit = $_GET['post_id']; // pastikan parameter 'post_id' ada di url

// query untuk mengambil data postingan berdasrkan id
$query = "SELECT * FROM posts WHERE id_post = $postIdToEdit";
$result = $conn->query($query);

// memeriksa apakah data postingan ditemukan
if ($result->num_rows > 0) {
    $post = $result->fetch_assoc(); // mengambil data postingan ke dalam array
} else {
    // menampilkan pesan jika postingan tidak ditemukan
    echo "Post not found.";
    exit(); // menghentikan eksekusi jika tidak ada postingan
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Judul halaman -->
     <div class="row">
        <!-- form untuk mengedit halaman -->
         <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- formulir menggunakan metode post untuk mengirim data -->
                     <form method="POST" action="proses_post.php" enctype="multipart/form-data">
                        <!-- Input tersembunyi untuk menyimpan id postingan -->
                         <input type="hidden" name="post_id" value="<?php echo $postIdToEdit; ?>">

                         <!-- input untuk judul postingan -->
                          <div class="mb-3">
                            <label for="post_title" class="form-label">Judul Postingan</label>
                            <input type="text" class="form-control" id="post_title" name="post_title" value="<?php echo $post['post_title']; ?>" required>
                          </div>

                          <!-- input untuk unggah gambar -->
                           <div class="mb-3">
                            <label for="formFile" class="form-label">Unggah Gambar</label>
                            <input class="form-control" type="file" id="formfile" name="image_path" accept="image/*">
                            <?php if (!empty($post['image_path'])): ?>
                            <!-- menampilkan gambar yang diunggah -->
                             <div class="mt-2">
                                <img src="<?= $post['image_path']; ?>" alt="Current image" class="img-thumbnail" style="max-width: 200px;">
                             </div>
                             <?php endif; ?>
                           </div>
                           <!-- dropdown untuk kategori -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value="" selected disabled>Select one</option>
                                    <?php
                                    // mengambil data kategori  dari databse
                                    $queryCategories = "SELECT * FROM categories";
                                    $resultCategories = $conn->query($queryCategories);
                                    // menambahlan opsi dropdown
                                    if ($resultCategories->num_rows > 0) {
                                        while ($row = $resultCategories->fetch_assoc()) {
                                            // menandai kategori yang sudah dipilih
                                            $selected = ($row["category_id"] == $post['category_id']) ? "selected" : "";
                                            echo "<option value='" . $row['category_id'] . "' $selected>" . $row ['category_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- textarea untuk konten postingan -->
                             <div class="mb-3">
                                <label for="content" class="form-label">Konten</label>
                                <textarea class="form-control" id="content" name="content" required><?php echo $post['content']; ?></textarea>
                             </div>
                             <!-- tombol untuk memperbarui postingan -->
                              <button type="submit" name="update" class="btn btn-primary">Update</button>
                     </form>
                </div>
            </div>
         </div>
     </div>
</div>

<?php
// memasukkan footer halaman
include '.includes/footer.php';
?>