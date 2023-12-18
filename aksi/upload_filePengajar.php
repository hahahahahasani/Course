<?php
session_start();
include "koneksi.php";

$email = $_SESSION['email'];

// ambil id 
// akses subkelas user
$query3 = mysqli_query($conn,"SELECT id_subkelas FROM subkelas WHERE email = '$email'");
$subs = mysqli_fetch_assoc($query3);
// inisialisasi variabel
$subkelasId = $subs['id_subkelas'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # code...
    $namaMateri = $_POST['nm_materi'];
    $urlMateri = $_POST['url_materi'];
    $deskMateri = $_POST['desk_materi'];

    // input ke database
    $queryMateri = mysqli_query($conn, "INSERT INTO materi
                                        VALUES
                                        (0, '$subkelasId', '$namaMateri', '$urlMateri','$deskMateri' ,'$email')");
    if ($queryMateri == true) {
        # code...
        echo "<script>
            alert('anda berhasil upload materi')
            document.location.href='../home.php'
        </script>";
    }
}
