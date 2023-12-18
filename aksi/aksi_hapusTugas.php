<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_tugas = $_POST['id_tugas'];

    $sql = mysqli_query($conn, "DELETE FROM tugas WHERE id_tugas = '$id_tugas'");

    if ($sql == true) {
        # code...
        echo "<script>
            alert('berhasil hapus tugas')
            document.location.href='../home.php'
        </script>";
        exit();
    } else {
        # code...
        echo "<script> 
                alert('Gagal hapus tugas')
            </script>";
    }
}
