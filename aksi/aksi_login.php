<?php
session_start();
include "koneksi.php";

function masuk($data){
    global $conn;
    
    // ambil data inputan
    $email = $data['email'];
    $pass = $data['pass'];
    
    // cek email apakah sama dengan database
    $hasil = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    
    if (mysqli_num_rows($hasil) === 1) {
        # code...
        // cek password
        $baris = mysqli_fetch_assoc($hasil);
        // jika password benar maka akan beralih halaman
        if ( password_verify($pass, $baris['pass']) ) {
            # code...
            $_SESSION['email'] = $baris['email'];
            $_SESSION['level'] = $baris['level'];
            // kondisi jika data sesuai maka arahkan pada halaman sesuai level
            if ($baris['level'] == "pengajar") {
                # code...
                header("location:home.php");
            }elseif ($baris['level'] == "siswa") {
                # code...
                header("location:home.php");
            }
            
        }
    }
    
}


?>