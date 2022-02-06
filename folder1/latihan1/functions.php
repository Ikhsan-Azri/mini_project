<?php
function koneksi()
{
  return mysqli_connect('localhost', 'root', '454726*satukoding', 'mini-project');
}

function query($query)
{
  $conn = koneksi();
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}
function tambah($data)
{
  $conn = koneksi();
  $nim = htmlspecialchars($data['nim']);
  $nama = htmlspecialchars($data['nama']);
  $Jurusan = htmlspecialchars($data['Jurusan']);
  $email = htmlspecialchars($data['email']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = "INSERT INTO 
            mahasiswa 
            VALUES  
            (null, '$nim', '$nama','$Jurusan','$email','$gambar');
            ";

  mysqli_query($conn, $query);
  echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}
