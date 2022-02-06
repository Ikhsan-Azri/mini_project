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


// mengambil id url
$id = $_GET['id'];

if (hapus($id) > 0) {
  echo "<script>
    alert('Data berhasil dihapus!');
    document.location.href = 'index.php';
    </script>";
} else {
  echo "Data gagal dihapus!";
}