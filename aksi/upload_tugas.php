<?php 
session_start();
include "koneksi.php";

$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $namatugas = $_POST['nm_tugas'];
    $jenistugas = $_POST['jenis_tugas'];
    $desktugas = $_POST['desk_tugas'];
  
    $q1 = mysqli_query($conn, "SELECT subkelas.id_subkelas FROM subkelas WHERE email = '$email'");
    $getsub = mysqli_fetch_assoc($q1);
    $subk = $getsub['id_subkelas'];
  
    $query1 = mysqli_query($conn, "INSERT INTO tugas 
                                  VALUES
                            (0, '$subk', '$namatugas', '$desktugas', '$jenistugas')");
    if ($query1 == true) {
      # code...
      echo "<script>
          alert('Anda berhasil upload tugas!');
          document.location.href='../course.php';
          </script>";
    }
}
?>