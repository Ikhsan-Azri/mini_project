<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

// jika tidak ada id url
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

// ambil id dari url
$id = $_GET['id'];

// qeury mahasiswa berdasarkan id
$m = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

// Cek apakah tombol data sudah di tekan?
if (isset($_POST['ubah'])) {

  if (ubah($_POST) > 0) {
    echo "<script>
    alert('Data berhasil diubah!');
    document.location.href = 'index.php';
    </script>";
  } else {
    echo "Data gagal diubah!";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Data Mahasiswa</title>
</head>

<body>
  <h3>Ubah Data Mahasiswa</h3>

  <form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $m['id']; ?>">

    <ul>
      <li>
        <label>
          NIM :
          <input type="text" name="nim" autofocus required value="<?= $m['nim']; ?>">
        </label>
      </li>
      <li>
        <label>
          Nama :
          <input type="text" name="nama" required value="<?= $m['nama']; ?>">
        </label>
      </li>
      <li>
        <label>
          Jurusan :
          <input type="text" name="Jurusan" required value="<?= $m['Jurusan']; ?>">
        </label>
      </li>
      <li>
        <label>
          Email :
          <input type="text" name="email" required value="<?= $m['email']; ?>">
        </label>
      </li>
      <li>
        <input type="hidden" name="gambar_lama" required value="<?= $m['gambar']; ?>">
        <label>
          Gambar :
          <input type="file" name="gambar" class="gambar" onchange="previewImage()">
        </label>
        <img src="img/<?= $m['gambar']; ?>" width="100px" style="display: block;" class="img-preview">
      </li>
      <li>
        <button type="submit" name="ubah">Ubah Data</button>
      </li>
    </ul>

  </form>
  <script src="js/script.js"></script>
</body>

</html>