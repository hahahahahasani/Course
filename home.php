<?php
// session_start();
include_once "client_kelas.php";
// var_dump($kelas);
// die();

// include "aksi/aksi_daftarcourse.php";
// $email = $_SESSION['email'];
// // kondisi belum login
// if (isset($_SESSION['email']) < 1) {
//     # code...
//     header("location:login.php");
// }

// if (isset($_POST['daftarkelas'])) {
//     # code...
//     // cek apakah data berhasil ditambah atau tidak
//     if (daftarcourse($_POST) > 0) {
//         # code...
//         echo "<script>
//         alert('Anda berhasil daftar kelas!');
//         </script>";
//     } else {
//         # code...
//         echo "<script>
//         alert('Anda gagal daftar kelas!');
//         </script>";
//     }
// }

// // menutup error null 
// ini_set('display_errors', 0);

// // buat query untuk mengambil nama dan role
// $hasilrole = mysqli_query($conn, "SELECT nama,level FROM user WHERE email = '$email'");
// // ambil baris data dari $hasilrole
// $rows = mysqli_fetch_assoc($hasilrole);

// // inisialisasi tiap variabel 
// $nama = $rows['nama'];
// $level = $rows['level'];

// // buat query untuk mengambil kelas yang sudah diambil user
// $usercourse = courseuser("SELECT * FROM pendaftaran_course,subkelas
//                             WHERE pendaftaran_course.id_subkelas=subkelas.id_subkelas
//                             AND pendaftaran_course.email = '$email'");

// // buat query untuk mengambil kelas yang sudah diambil pengajar
// $pengajarcourse = coursepengajar("SELECT * FROM subkelas WHERE email = '$email'");

// // inisialisasi subkelas 
// // $id_subkelas = $_POST['subkelas'];

?>
<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="image/icon.png">

    <title>SkillHub Apps</title>
</head>

<body>

    <!-- navbar -->
    <div class="navbar-fixed">
        <nav class="blue darken-3">
            <div class="container">
                <div class="nav-wrapper">
                    <a href="#!" class="brand-logo">SkillHub</a>
                    <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="home.php">Home</a></li>
                        <li><a href="logout.php" onclick="return confirm('Yakin ingin keluar kelas?');">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- sidenav -->
    <ul class="sidenav" id="mobile-nav">
        <li><a href="home.php">Home</a></li>
        <li><a href="logout.php" onclick="return confirm('Yakin ingin keluar kelas?');">Logout</a></li>
    </ul>

    <!-- hero -->
    <div class="container">
        <div class="row">
            <!-- tambah kelas -->
            <br><br>
            <div class="col m7 s12">
                <h3 class="light">Selamat Datang <?= $nama ?></h3>
                <p>Anda telah login sebagai <?= $level ?>. Silahkan memilih kelas yang ingin anda pelajari di bawah</p>
                <form action="proses_kelas.php" method="post">
                    <div class="input-field">
                        <h6 class="light">Kelas Course</h6>
                        <input type="hidden" name="aksi" value="daftarkelas">
                        <?php $kelas = $abc->tampil_kelas(); ?>
                        <select name="kelas" id="kelas" required>
                            <?php foreach ($kelas as $k) :  ?>
                                <option value="<?= $k->id_kelas ?>"><?= $k->nama_kelas; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <button type="submit" name="daftarkelas" class="btn blue darken-3">Daftar Kelas</button>
                </form>

            </div>

            <!-- daftar kelas -->
            <br><br>
            <div class="col m5 s12">
                <div class="card-panel">
                    <h5 class="light center">Daftar Kelas Anda</h5>
                    <?php $tampil = $abc->kelas_siswa(); ?>
                    <?php foreach ($usercourse as $ucourse) : ?>
                        <div class="row">
                            <div class="col s8">
                                <div class="card-action">
                                    <p class="center"><?= $ucourse['nama_subkelas'] ?></p>
                                </div>
                            </div>
                            <div class="col s4">
                                <p></p>
                                <form action="hapus.php" method="post">
                                    <a href="course.php?id=<?= $ucourse['id_subkelas'] ?>" class="btn-floating btn-small waves-effect waves-light blue darken-3">
                                        <i class="material-icons">remove_red_eye</i></a>
                                    <input type="hidden" name="id_user" id="delete-id" value="<?= $ucourse['id_subkelas'] ?>">
                                    <button type="submit" class="btn-floating btn-small waves-effect waves-light red" onclick="return confirm('Yakin ingin keluar kelas?');">
                                        <i class="material-icons">delete</i></a>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>



    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        // sidenav
        const sideNav = document.querySelectorAll('.sidenav');
        M.Sidenav.init(sideNav);
        // select 
        document.addEventListener('DOMContentLoaded', function() {
            var sel = document.querySelectorAll('select');
            M.FormSelect.init(sel);
        });
        // // ajax combobox
        // $('#kelas').change(function() {
        //     var kelas = $(this).val();
        //     $.ajax({
        //         type: 'POST',
        //         url: 'aksi/ajaxkelas.php',
        //         data: 'id_kelas=' + kelas,
        //         success: function(response) {
        //             $('#subkelas').html(response);
        //         }
        //     });
        // });
        // floating button
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.action-btn');
            var instances = M.FloatingActionButton.init(elems, {
                direction: 'top'
            });
        });
    </script>
</body>

</html>