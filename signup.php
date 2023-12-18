<?php
// session_start();
// require "aksi/aksi_daftar.php";

// // kondisi apakah daftar sudah ditekan 
// if (isset($_POST["daftar"])) {
//     # code...
//     // kondisi user berhasil daftar
//     if (daftar($_POST) > 0) {
//         # code...
//         echo "<script>
//             alert('Anda berhasil daftar!');
//             document.location.href='login.php';
//             </script>";
//     } else {
//         # code...
//         // menampilkan error
//         echo mysqli_error($conn);
//     }
// }

// // kondisi jika sudah login
// if (isset($_SESSION['email']) == 1) {
//     # code...
//     header("location:home.php");
// }

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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="signup.php">SignUp</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- sidenav -->
    <ul class="sidenav" id="mobile-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">SignUp</a></li>
    </ul>
    <!-- regis page -->
    <section id="signup" class="signup">
        <div class="container">
            <h3 class="center blue-grey-text darken-4">Selamat Datang!</h3><br>
            <div class="card-panel">
                <div class="row">
                    <div class="col m5">
                        <img src="image/signup.jpg" alt="" class="responsive-img">
                    </div>
                    <div class="col m7 s12">
                        <form action="proses_user.php" method="post">
                            <input type="hidden" name="aksi" value="register">
                            <h5 class="blue-grey-text darken-4">Daftar disini</h5>
                            <div class="input-field">
                                <input type="text" name="nama" id="nama" required class="validate">
                                <label for="nama">Nama</label>
                            </div>
                            <div class="input-field">
                                <input type="email" name="email" id="email" class="validate">
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field">
                                <input type="password" name="password" id="pass" required>
                                <label for="pass">Password</label>
                            </div>
                            <div class="input-field">
                                <select name="role">
                                    <option value="" disabled selected></option>
                                    <option value="pengajar">Pengajar</option>
                                    <option value="siswa">Siswa</option>
                                </select>
                                <label>Pilih Role</label>
                            </div>
                            <div class="input-field">
                                <input type="text" name="alamat" id="alamat" required class="validate">
                                <label for="alamat">Alamat</label>
                            </div>
                            <button type="submit" name="register" class="btn blue darken-3">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script>
        // sidenav
        const sideNav = document.querySelectorAll('.sidenav');
        M.Sidenav.init(sideNav);
        // select 
        document.addEventListener('DOMContentLoaded', function() {
            var sel = document.querySelectorAll('select');
            M.FormSelect.init(sel);
        });
    </script>
</body>

</html>