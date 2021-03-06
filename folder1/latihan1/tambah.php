<?php
require 'functions.php';

// Cek apakah tombol data sudah di tekan?
if (isset($_POST['tambah'])) {

  if (tambah($_POST) > 0) {
    echo "<script>
    alert('Data berhasil ditambahkan!');
    document.location.href = 'index.php';
    </script>";
  } else {
    echo "Data gagal ditambahkan!";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data Mahasiswa</title>
</head>

<body>
  <h3>Tambah Data Mahasiswa</h3>

  <form action="" method="POST" enctype="multipart/form-data">

    <ul>
      <li>
        <label>
          NIM :
          <input type="text" name="nim" autofocus required>
        </label>
      </li>
      <li>
        <label>
          Nama :
          <input type="text" name="nama" required>
        </label>
      </li>
      <li>
        <label>
          Jurusan :
          <input type="text" name="Jurusan" required>
        </label>
      </li>
      <li>
        <label>
          Email :
          <input type="text" name="email" required>
        </label>
      </li>
      <li>
        <label>
          Gambar :
          <input type="file" name="gambar" class="gambar" onchange="previewImage()">
        </label>
        <img src="img/user.png" width="100px" style="display: block;" class="img-preview">
      </li>
      <li>
        <button type="submit" name="tambah">Tambah Data</button>
      </li>
    </ul>

  </form>
  <script src="js/script.js"></script>
</body>

</html>