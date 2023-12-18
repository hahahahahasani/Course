<?php
session_start();
include "koneksi.php";

// global $id_kelas;
// var_dump($id_kelas);die;
$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // inisialisasi variabel dari form diskusi
    $diskusi = $_POST['diskusi'];
    $id_subkelas = $_POST['id_subkelas'];
  
  // input data ke database
    $query1 = mysqli_query($conn, "INSERT INTO forum_diskusi 
                                  VALUES
                            ('$id_subkelas', '$email', '$diskusi')");
    if ($query1 == true) {
      # code...
      header("location:../home.php");
    }
}
