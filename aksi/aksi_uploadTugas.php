<?php
session_start();
include "koneksi.php";

$email = $_SESSION['email'];
// ambil id 
// akses subkelas user

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # code...
    $id_tugas = $_POST['id_tugas'];

    $query3 = mysqli_query($conn, "SELECT tugas.jenis_tugas FROM tugas WHERE tugas.id_tugas = '$id_tugas'");
    $subs = mysqli_fetch_assoc($query3);

    // inisialisasi variabel
    $jenisTugas = $subs['jenis_tugas'];
    $tgl = date('l jS \of F Y');
    $namaFile = $_FILES['file_subTugas']['name'];
    $ukuranFile = $_FILES['file_subTugas']['size'];
    $error = $_FILES['file_subTugas']['error'];
    $tmpName = $_FILES['file_subTugas']['tmp_name'];

    // apakah tidak ada file yang diupload
    if ($error === 4) {
        # code...
        echo "<script>
            alert('pilih file terlebih dahulu')
            document.location.href='../home.php'
        </script>";
        return false;
    }

    // cek apakah yang diupload file pdf atau doc
    $ekstensiFile = ['pdf', 'docx'];
    $ekstensiFileValid = explode('.', $namaFile);
    $ekstensiFileValid1 = strtolower(end($ekstensiFileValid));
    if (!in_array($ekstensiFileValid1, $ekstensiFile)) {
        # code...
        echo "<script>
            alert('format tidak ditemukan')
            document.location.href='../home.php'
        </script>";
        return false;
    }

    // cek jika ukuran terlalu besar
    if ($ukuranFile > 2000000) {
        # code...
        echo "<script>
            alert('file terlalu besar')
            document.location.href='../home.php'
        </script>";
        return false;
    }

    // lolos pengecekan gambar siap diupload
    move_uploaded_file($tmpName, 'file/' . $namaFile);

    // return $namaFile;

    if ($jenisTugas == "tugas") {
        # code...
        // input database
        $queryTugas = mysqli_query($conn, "INSERT INTO submit_tugas
                                                VALUES
                                            (0,'$id_tugas', '$email', '$tgl', '$namaFile')");
        if ($queryTugas == true) {
            # code...
            echo "<script>
                    alert('anda berhasil submit tugas')
                    document.location.href='../home.php'
                </script>";
        }
    }elseif ($jenisTugas == "kuis") {
        # code...
        // input ke database
        $queryTugas = mysqli_query($conn, "INSERT INTO submit_kuis
                                                VALUES
                                            (0,'$id_tugas', '$email', '$tgl', '$namaFile')");
        if ($queryTugas == true) {
            # code...
            echo "<script>
                    alert('anda berhasil submit kuis')
                    document.location.href='../home.php'
                </script>";
        }
    }
}
