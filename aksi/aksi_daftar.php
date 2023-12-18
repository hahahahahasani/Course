<?php 
include "koneksi.php";

// aksi daftar
function daftar($data) {
    global $conn;
    
    $nama = stripslashes($data['nama']);
    $email = $data['email'];
    $pass = $data['pass'];
    $pass2 = $data['ulangpass'];
    $level = $data['level'];
    $alamat = $data['alamat'];

    // cek nama sudah ada atau belum 
    $hasil = mysqli_query($conn, "SELECT nama FROM user WHERE nama = '$nama'");
    if (mysqli_fetch_assoc($hasil)) {
        # code...
        echo "<script>
                alert('Nama sudah terdaftar!')
            </script>";
        return false;
    }

    // cek konfirmasi password 
    if ( $pass != $pass2) {
        # code...
        echo "<script>
                alert('Password tidak sesuai!');
            </script>";
        return false;
    }
    
    // enkripsi password
    $password = password_hash($pass, PASSWORD_DEFAULT);
    
    // tambah data user baru
    $query = "INSERT INTO user
                VALUES
            ('$nama','$email','$password','$level','$alamat')";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}


?>