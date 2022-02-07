<?php
function koneksi()
{
  return mysqli_connect('localhost', 'root', '454726*satukoding', 'mini-project');
}

function upload()
{
  $nama_file = $_FILES['gambar']['name'];
  $tipe_file = $_FILES['gambar']['type'];
  $ukuran_file = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmp_file = $_FILES['gambar']['tmp_name'];

  // ketika tidak ada gambar yang dipilih
  if ($error == 4) {
    // echo "<script>
    //       alert('Pilih gambar terlebih dahulu!!!');
    //       </script>";
    return 'user.png';
  }

  // cek ekstensi file
  $daftar_gambar = ['jpg', 'jpeg', 'png'];
  $ekstensi_file = explode('.', $nama_file);
  $ekstensi_file = strtolower(end($ekstensi_file));

  if (!in_array($ekstensi_file, $daftar_gambar)) {
    echo "<script>
    alert('Yang Anda pilih bukan gambar!!!');
    </script>";
    return false;
  }

  // cek type file
  if ($tipe_file != 'image/jpeg' && $tipe_file != 'image/png') {
    echo "<script>
        alert('Yang Anda pilih bukan gambar!!!');
        </script>";
    return false;
  }

  // cek ukuran file
  // maksmal 5Mb = 5000000 
  if ($ukuran_file > 2000000) {
    echo "<script>
        alert('Ukuran file terlalu besar');
        </script>";
    return false;
  }

  // lolos pengecekan
  // siap upload file
  // generate nama file baru
  $nama_file_baru = uniqid();
  $nama_file_baru .= '.';
  $nama_file_baru .= $ekstensi_file;
  move_uploaded_file($tmp_file, 'img/' . $nama_file_baru);

  return $nama_file_baru;
}

function query($query)
{
  $conn = koneksi();
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }

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
  // $gambar = htmlspecialchars($data['gambar']);

  // upload gambar
  $gambar = upload();

  if (!$gambar) {
    return false;
  }

  $query = "INSERT INTO 
            mahasiswa 
            VALUES  
            (null, '$nim', '$nama','$Jurusan','$email','$gambar');
            ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function hapus($id)
{
  $conn = koneksi();

  // menghapus gambar difolder
  $mhs = query("SELECT * FROM mahasiswa WHERE id = $id");
  if ($mhs['gambar'] != 'user.png') {
    unlink('img/' . $mhs['gambar']);
  }
  mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function ubah($data)
{
  $conn = koneksi();
  $id = $data['id'];
  $nim = htmlspecialchars($data['nim']);
  $nama = htmlspecialchars($data['nama']);
  $Jurusan = htmlspecialchars($data['Jurusan']);
  $email = htmlspecialchars($data['email']);
  $gambar_lama = htmlspecialchars($data['gambar_lama']);

  $gambar = upload();
  if (!$gambar) {
    return false;
  }

  if ($gambar == 'user.png') {
    $gambar = $gambar_lama;
  }

  $query = "UPDATE 
            mahasiswa
            SET 
            nim = '$nim',
            nama = '$nama',
            email = '$email',
            Jurusan = '$Jurusan',
            gambar = '$gambar'
            WHERE 
            id = $id
            ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function login($data)
{
  $conn = koneksi();

  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars($data['password']);

  if ($user = query("SELECT * FROM user WHERE username = '$username'")) {
    // Cek password
    if (password_verify($password, $user['password'])) {
      // Set SESSION
      $_SESSION['login'] = true;

      header("Location: index.php");
      exit;
    }
  }
  return [
    'error' => true,
    'pesan' => 'Username / Password salah!!'
  ];
}

function registrasi($data)
{
  $conn = koneksi();

  $username = htmlspecialchars(strtolower($data['username']));
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // Jika Username atau Password kosong
  if (empty($username) || empty($password1)  || empty($password2)) {
    echo "<script>
      alert('Username/Password tidak boleh kosong!!');
      document.location.href = 'registrasi.php';
    </script>";

    return false;
  }

  // jika Username sudah ada
  if (query("SELECT * FROM user WHERE username = '$username'")) {
    echo "<script>
      alert('Username sudah terdaftar!!');
      document.location.href = 'registrasi.php';
    </script>";
    return false;
  }

  if ($password1 !== $password2) {
    echo "<script>
    alert('Konfirmasi password tidak sesuai!!');
    document.location.href = 'registrasi.php';
  </script>";
    return false;
  }

  if (strlen($password1) < 8) {
    echo "<script>
    alert('Password tidak boleh lebih kecil dari 8 digit!!');
    document.location.href = 'registrasi.php';
  </script>";
    return false;
  }

  // jika username dan password sudah sesuai 
  // enkripsi password
  $password_baru = password_hash($password1, PASSWORD_DEFAULT);

  // insert ke tabel user

  $query = "INSERT INTO user 
            VALUES 
            (null, '$username', '$password_baru')
            ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function cari($keyword)
{
  $conn = koneksi();

  $query = "SELECT * FROM mahasiswa
            WHERE 
            nama LIKE '%$keyword%' OR
            nim LIKE '%$keyword%'
          ";
  $result = mysqli_query($conn, $query);
}
