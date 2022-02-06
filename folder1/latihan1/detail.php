<?php
require 'functions.php';

// Ambil id dari URL  
$id = $_GET['id'];

// query mahasiswa berdasarkan id
$m = query("SELECT *FROM mahasiswa WHERE  id = $id")[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Mahasiswa</title>
</head>

<body>
  <h3>Detail Mahasiswa</h3>
  <ul>
    <li><img src="img/<?= $m['gambar']; ?>" width="100px"></li>
    <li>NIM :<?= $m['nim']; ?></li>
    <li>Nama :<?= $m['nama']; ?></li>
    <li>Email :<?= $m['email']; ?></li>
    <li>Jurusan :<?= $m['Jurusan']; ?></li>
    <li><a href="">Ubah</a> | <a href="">Hapus</a></li>
    <li><a href="latihan3.php">Kembali ke daftar mahasiswa</a></li>
  </ul>
</body>

</html>