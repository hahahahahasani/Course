<?php
require "koneksi.php";
// include_once "ajaxkelas.php";
ini_set('display_errors', 0);


function daftarcourse($daftar)
{
    global $conn;

    $tanggal = date('l jS \of F Y');
    $email = $_SESSION['email'];
    $subkelas = $daftar['subkelas'];

    // buat query untuk mengambil nama dan role
    $hasilrole = mysqli_query($conn, "SELECT level FROM user WHERE email = '$email'");
    // ambil baris data dari $hasilrole
    $rows = mysqli_fetch_assoc($hasilrole);
    // inisialisasi role
    $level = $rows['level'];


    if ($level == "pengajar") {
        # code...
        $query0 = mysqli_query($conn, "SELECT id_subkelas FROM subkelas WHERE email = '$email'");
        $cekemail = mysqli_fetch_assoc($query0);

        if ($cekemail['id_subkelas'] > 0) {
            # code...
            return false;
        }
        # code...
        // tambah data ke tabel subkelas
        $query1 = "UPDATE subkelas
                    SET email = '$email'
                    WHERE id_subkelas = '$subkelas'";
        mysqli_query($conn, $query1);
    } elseif ($level == "siswa") {
        # code...
        // tambah data ke tabel pendaftaran
        $query2 = "INSERT INTO pendaftaran_course 
                    VALUES
                (0, '$tanggal', '$email', '$subkelas')";
        mysqli_query($conn, $query2);
    }

    // mengembalikan baris yang menambah
    return mysqli_affected_rows($conn);
}

function courseuser($queryambil)
{
    global $conn;

    // ambil baris data dari $queryambil dan letakkan di $hasilpendaftaran
    $hasilpendaftaran = mysqli_query($conn, $queryambil);
    // buat array kosong untuk tempat menaruh data pendaftaran
    $baris = [];
    while ($barispendaftar = mysqli_fetch_assoc($hasilpendaftaran)) {
        # code...
        $baris[] = $barispendaftar;
    }
    return $baris;
}

function coursepengajar($queryambil)
{
    global $conn;

    // ambil baris data dari $queryambil dan letakkan di $hasilpendaftaran
    $hasilpendaftaran = mysqli_query($conn, $queryambil);
    // buat array kosong untuk tempat menaruh data pendaftaran
    $baris = [];
    while ($barispendaftar = mysqli_fetch_assoc($hasilpendaftaran)) {
        # code...
        $baris[] = $barispendaftar;
    }
    return $baris;
}
