<?php 
// Menyertakan header halaman
include '.includes/header.php';
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Judul Halaman -->
     <div class="row">
        <!-- frorm untuk menambahkan postingan baru -->
         <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" action="proses_post.php" enctype="multipart/form-data">
                        <!-- input untuk judul postingan -->
                         <div class="mb-3">
                            <label for="post_tittle" class="form-label">Judul Postingan</label>
                            <input type="text" class="form-control" name="post_tittle" required>
                         </div>
                         <!-- Input unutk mengunggah gambar -->
                          <div class="mb-3">
                            <label for="formFile" class="form-label">Unggah Gambar</label>
                            <input class="formFile" type="file" name="image" accept="image/*" />
                          </div>
                          <!-- Dropdown untuk memilih kategori -->
                           <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-select" name="category_id" required>
                                <!-- Mengambil data kategori dari database untuk mengisi opsi dropdown -->
                                 <option value="" selected disabled>Pilih salah satu</option>
                                 <?php
                                 $query = "SELECT * FROM categories"; // Query untuk mengambil data kategori
                                 $result = $conn->query($query); // Menjalankan query
                                 if ($resuult->num_rows > 0) { // Jika terdapat data kategori
                                    while ($row = $result->fetch_assoc()) { // Iterasi setiap kategori
                                        echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                           </div>
                           <!-- Textarea untuk konten postingan -->
                            <div class="mb-3">
                                <label for="content" class="form-label">Konten</label>
                                <textarea class="form-control" id="content" name="content"required></textarea>
                            </div>
                            <!-- Tombol submit -->
                             <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
         </div>
     </div>
</div>
<?php
// Menyertkana footer halaman
include '.includes/footer.php';