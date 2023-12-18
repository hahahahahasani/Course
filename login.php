<?php
// require "aksi/aksi_login.php";

// // kondisi jika sudah login 
// if (isset($_SESSION['email']) == 1) {
//     # code...
//     header("location:home.php");
// }

// // kondisi apakah masuk sudah ditekan 
// if (isset($_POST['masuk'])) {
//     # code...
//     // kondisi jika email atau password user benar
//     if (masuk($_POST) < 1) {
//         # code...
//         echo "<script>
//                 alert('Email / Password salah!');
//             </script>";
//     }
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

    <!-- login page -->
    <section class="login" id="login">
        <div class="container">
            <h3 class="center blue-grey-text darken-4">Login</h3>
            <div class="card-panel">
                <div class="row">
                    <div class="col m6">
                        <img src="image/login.jpg" alt="" class="responsive-img">
                    </div>
                    <div class="col m6 s12">
                        <form action="proses_user.php" method="post">
                            <br>
                            <input type="hidden" name="aksi" value="user">
                            <h5 class="center blue-grey-text darken-4">Masuk disini</h5><br>
                            <div class="input-field">
                                <input type="text" name="email" id="email" class="validate">
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field">
                                <input type="password" name="password" id="pass" required>
                                <label for="pass">Password</label>
                            </div>
                            <div class="input-field center">
                                <button type="submit" class="btn blue darken-3" name="masuk">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script>
        const sideNav = document.querySelectorAll('.sidenav');
        M.Sidenav.init(sideNav);
    </script>
</body>

</html>