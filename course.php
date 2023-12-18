<?php
session_start();
include "aksi/koneksi.php";
// include "home.php";
// require "aksi/upload_file.php";

if (isset($_SESSION['email']) < 1) {
  # code...
  header("location:login.php");
}

ini_set('display_errors', 0);

$id_kelas = $_GET['id'];
// buat query untuk mengambil nama subkelas yang sesuai dengan id url
$hasilnamakelas = mysqli_query($conn, "SELECT subkelas.nama_subkelas FROM subkelas WHERE subkelas.id_subkelas = '$id_kelas'");
// ambil baris data dari $hasilnamakelas
$rowsnamakelas = mysqli_fetch_assoc($hasilnamakelas);

// buat query untuk mengambil data pada tabel materi sesuai id url
$hasilmateri = mysqli_query($conn, "SELECT materi.* FROM materi WHERE materi.id_subkelas = '$id_kelas'");

// buat query untuk mengambil data pada tabel tugas sesuai id url
$hasilTugas = mysqli_query($conn, "SELECT tugas.* FROM tugas WHERE tugas.id_subkelas = '$id_kelas'");

// buat query untuk mengambil data pada tabel diskusi sesuai id url
$hasilDiskusi = mysqli_query($conn, "SELECT * FROM forum_diskusi WHERE forum_diskusi.id_subkelas = '$id_kelas'");

// buat query untuk mengambil data pada tabel submit kuis
$hasilSubKuis = mysqli_query($conn, "SELECT a.email,a.file_subkuis FROM submit_kuis a LEFT JOIN tugas b ON a.id_tugas = b.id_tugas WHERE b.id_subkelas = '$id_kelas'");

// buat query untuk mengambil data pada tabel submit tugas
$hasilSubTugas = mysqli_query($conn, "SELECT a.email,a.file_subtugas FROM submit_tugas a LEFT JOIN tugas b ON a.id_tugas = b.id_tugas WHERE b.id_subkelas = '$id_kelas'");

// buat query mengambil data pada tabel pendaftaran course
$hasilDaftarKelas = mysqli_query($conn, "SELECT * FROM pendaftaran_course WHERE id_subkelas = '$id_kelas'");

$hasilNilai = mysqli_query($conn, "SELECT * FROM penilaian WHERE id_subkelas = '$id_kelas'");

$email = $_SESSION['email'];
// buat query untuk mengambil nama dan role
$hasilrole = mysqli_query($conn, "SELECT nama,level FROM user WHERE email = '$email'");
// ambil baris data dari $hasilrole
$rows = mysqli_fetch_assoc($hasilrole);

// inisialisasi tiap variabel 
$nama = $rows['nama'];
$level = $rows['level'];

// akses subkelas user
$query3 = mysqli_query($conn, "SELECT id_subkelas FROM subkelas WHERE email = '$email'");
$subs = mysqli_fetch_assoc($query3);
// inisialisasi variabel
$subkelasId = $subs['id_subkelas'];

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
          <a href="home.php" class="brand-logo">SkillHub</a>
          <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li><a href="home.php">Home</a></li>
            <li><a href="logout.php" onclick="return confirm('Yakin ingin keluar?');">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </div>

  <!-- sidenav -->
  <ul class="sidenav" id="mobile-nav">
    <li><a href="home.php">Home</a></li>
    <li><a href="logout.php" onclick="return confirm('Yakin ingin keluar?');">Logout</a></li>
  </ul>

  <!-- materi & tugas untuk siswa-->
  <?php if ($level == "siswa") : ?>
    <div class="container">
      <div class="row">
        <div class="col m8">
          <h2 class="light"><?= $nama ?> - <?= $level ?></h2>
          <div class="card-panel">
            <h5 class="light">Materi hari ini untuk <?= $rowsnamakelas['nama_subkelas'] ?> </h5>
            <br>
            <?php while ($rowsmateri = mysqli_fetch_assoc($hasilmateri)) : ?>
              <div class="row">
                <div class="col m7">
                  <h6 class="light"><?= $rowsmateri['nama_materi'] ?></h6>
                </div>
                <div class="col m5">
                  <a class="waves-effect waves-light btn modal-trigger" href="#<?= $rowsmateri['id_materi'] ?>">Lihat Materi</a>
                  <!-- Modal Structure -->
                  <div id="<?= $rowsmateri['id_materi'] ?>" class="modal">
                    <div class="modal-content">
                      <h4 class="light"><?= $rowsmateri['nama_materi'] ?></h4>
                      <p class="light"><?= $rowsmateri['desk_materi'] ?></p>
                      <br>
                      <div class="video-container">
                        <iframe width="800" height="400" src="<?= $rowsmateri['url_materi'] ?>" frameborder="0" allowfullscreen></iframe>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
          <div class="card-panel">
            <h5 class="light">Forum Diskusi - Course Anda</h5>
            <form action="aksi/upload_diskusi.php" method="post">
              <input type="number" name="id_subkelas" value="<?= $_GET['id'] ?>" hidden>
              <div class="input-field">
                <textarea id="textarea1" class="materialize-textarea" name="diskusi"></textarea>
                <label for="textarea1">Komentar</label>
              </div>
              <button class="btn-small waves-effect waves-light" type="submit" name="action">
                <i class="material-icons right">send</i></button>
            </form>
            <br>
            <?php while ($rowsdiskusi = mysqli_fetch_array($hasilDiskusi)) : ?>
              <h6 class="light"><?= $rowsdiskusi['email'] ?></h6>
              <p class="light"><?= $rowsdiskusi['diskusi'] ?></p>
            <?php endwhile ?>
          </div>
        </div>
        <div class="col m4">
          <br><br><br>
          <div class="card-panel">
            <h5 class="light">Tugas anda hari ini</h5>
            <br>
            <?php while ($rowstugas = mysqli_fetch_assoc($hasilTugas)) : ?>
              <div class="row">
                <div class="col m8">
                  <span><?= $rowstugas['nama_tugas'] ?></span>
                </div>
                <div class="col m4">
                  <a class="btn-small waves-effect waves-light btn modal-trigger" href="#<?= $rowstugas['id_tugas'] ?>"><i class="material-icons">add</i></a>
                  <div id="<?= $rowstugas['id_tugas'] ?>" class="modal">
                    <div class="modal-content">
                      <h4 class="light"><?= $rowstugas['nama_tugas'] ?></h4>
                      <h6 class="light"><?= $rowstugas['desk_tugas'] ?></h6>
                      <p class="light">Upload <?= $rowstugas['jenis_tugas'] ?> anda dibawah : </p>
                      <form action="aksi/aksi_uploadTugas.php" method="post" enctype="multipart/form-data">
                        <div class="file-field input-field">
                          <div class="btn">
                            <span>File</span>
                            <input type="file" name="file_subTugas">
                            <input type="hidden" name="id_tugas" id="delete-id" value="<?= $rowstugas['id_tugas'] ?>">
                          </div>
                          <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button class="btn" name="sub_tugas">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal Structure -->
            <?php endwhile; ?>
          </div>
          <div class="card-panel">
            <!-- Modal Trigger -->
            <a class="waves-effect waves-light btn modal-trigger" href="#modal3" style="margin-left: 43px;">Daftar Nilai</a>
            <!-- Modal Structure -->
            <div id="modal3" class="modal">
              <div class="modal-content">
                <h4 class="light">Daftar Nilai <?= $nama ?></h4>
                <p class="light">Nilai - Nilai Siswa</p>
                <table>
                  <thead>
                    <tr>
                      <th>Nilai Keuletan</th>
                      <th>Nilai Kreativitas</th>
                      <th>Nilai Pengetahuan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // echo $email;
                    $nilai = mysqli_query($conn, "SELECT * FROM penilaian  WHERE penilaian.email = '$email' AND penilaian.id_subkelas = '$id_kelas'"); ?>
                    <?php while ($penilaian = mysqli_fetch_assoc($nilai)) : ?>
                      <tr>
                        <td>
                          <div class="input-field">
                            <input name="nilai_ulet" id="nilai_ulet" type="text" class="validate" readonly value="<?= $penilaian['keuletan'] ?>">
                            <label for="nilai_ulet">Nilai Keuletan</label>
                          </div>
                        </td>
                        <td>
                          <div class="input-field">
                            <input name="nilai_kreativ" id="nilai_kreativ" type="text" class="validate" readonly value="<?= $penilaian['kreativitas'] ?>">
                            <label for="nilai_kreativ">Nilai Kreativitas</label>
                          </div>
                        </td>
                        <td>
                          <div class="input-field">
                            <input name="nilai_tahu" id="nilai_tahu" type="text" class="validate" readonly value="<?= $penilaian['pengetahuan'] ?>">
                            <label for="nilai_tahu">Nilai Pengetahuan</label>
                          </div>
                        </td>
                      </tr>
                    <?php endwhile ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- upload materi & tugas untuk siswa -->
  <?php if ($level == "pengajar") : ?>
    <div class="container">
      <div class="row">
        <div class="col m8">
          <h2 class="light"><?= $nama ?> - <?= $level ?></h2>
          <div class="card-panel">
            <?php
            $q1 = mysqli_query($conn, "SELECT subkelas.nama_subkelas FROM subkelas WHERE email = '$email'");
            $show = mysqli_fetch_assoc($q1);
            $nm_course = $show['nama_subkelas'];
            ?>
            <h5 class="light">Upload materi hari ini untuk - <?= $nm_course ?></h5>
            <br>
            <div class="row">
              <div class="col m12">
                <?php $date = date('jS \of F Y') ?>
                <p class="light">Silahkan upload materi dan tugas - tugas untuk Course anda hari ini <?= $date ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col m6">
                <!-- Modal Trigger -->
                <a class="waves-effect waves-light btn modal-trigger" href="#modal6">Upload Materi</a>
                <!-- Modal Structure -->
                <div id="modal6" class="modal">
                  <div class="modal-content">
                    <h4 class="light">Upload Materi</h4>
                    <p class="light">Upload materi anda dibawah : </p>
                    <form action="aksi/upload_filePengajar.php" method="post">
                      <div class="input-field">
                        <input name="nm_materi" id="nm_materi" type="text" class="validate">
                        <label for="nm_materi">Nama Materi</label>
                      </div>
                      <div class="input-field">
                        <input name="url_materi" id="url_materi" type="text" class="validate">
                        <label for="url_materi">URL Materi</label>
                      </div>
                      <label for="desk_materi">Deskripsi Materi</label>
                      <textarea name="desk_materi" id="desk_materi" cols="30" rows="10" class="materialize-textarea validate"></textarea>
                      <div class="modal-footer">
                        <button class="btn modal-close waves-effect waves-green btn-flat" name="submit_tugas">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col m6">
                <!-- Modal Trigger -->
                <a class="waves-effect waves-light btn modal-trigger" href="#modal2">Upload Tugas</a>
                <!-- Modal Structure -->
                <div id="modal2" class="modal">
                  <div class="modal-content">
                    <h4 class="light">Upload Tugas</h4>
                    <p class="light">Upload tugas anda dibawah : </p>
                    <form action="aksi/upload_tugas.php" method="post">
                      <label for="nm_tugas">Nama Tugas</label>
                      <input name="nm_tugas" id="nm_tugas" type="text" class="validate">
                      <div class="input-field">
                        <select name="jenis_tugas">
                          <option value="" disabled selected></option>
                          <option value="tugas">Tugas</option>
                          <option value="kuis">Kuis</option>
                        </select>
                        <label>Jenis Tugas</label>
                      </div>
                      <label for="desk_tugas">Deskripsi Tugas</label>
                      <textarea name="desk_tugas" id="desk_tugas" cols="30" rows="10" class="materialize-textarea validate"></textarea>
                      <div class="modal-footer">
                        <button class="btn modal-close waves-effect waves-green btn-flat" name="submit_tugas">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-panel">
            <table>
              <thead>
                <tr>
                  <th>Jenis</th>
                  <th>Nama</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $querytugas = mysqli_query($conn, "SELECT * FROM tugas WHERE id_subkelas = '$subkelasId'");
                ?>
                <?php while ($tugas2 = mysqli_fetch_assoc($querytugas)) : ?>
                  <tr>
                    <td><?= $tugas2['jenis_tugas'] ?></td>
                    <td><?= $tugas2['nama_tugas'] ?></td>
                    <td>
                      <form action="aksi/aksi_hapusTugas.php" method="post">
                        <input type="hidden" name="id_tugas" id="delete-id" value="<?= $tugas2['id_tugas'] ?>">
                        <button type="submit" class="btn waves-effect waves-light red">
                          <i class="material-icons">delete</i>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endwhile ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col m4">
          <br><br><br>
          <div class="card-panel">
            <h6 class="light">Siswa yang telah submit tugas</h6>
            <div class="row">
              <?php while ($rowstugas = mysqli_fetch_assoc($hasilSubTugas)) : ?>
                <div class="col s9">
                  <p><?= $rowstugas['email'] ?></p>
                </div>
                <div class="col s3">
                  <a href="aksi/downloadtugas.php?url=<?= $rowstugas['file_subtugas'] ?>" class="btn-floating btn-small waves-effect waves-light" style="margin-top: 11px;">
                    <i class="material-icons">arrow_downward</i></a>
                </div>
              <?php endwhile ?>
            </div>
          </div>
          <div class="card-panel">
            <h6 class="light">Siswa yang telah submit kuis</h6>
            <div class="row">
              <?php while ($rowskuis = mysqli_fetch_assoc($hasilSubKuis)) : ?>
                <div class="col s9">
                  <p><?= $rowskuis['email'] ?></p>
                </div>
                <div class="col s3">
                  <a href="aksi/downloadkuis.php?url=<?= $rowskuis['file_subkuis'] ?>" class="btn-floating btn-small waves-effect waves-light" style="margin-top: 11px;">
                    <i class="material-icons">arrow_downward</i></a>
                </div>
              <?php endwhile ?>
            </div>
          </div>
          <div class="card-panel">
            <!-- Modal Trigger -->
            <a class="waves-effect waves-light btn modal-trigger" href="#modal3" style="margin-left: 43px;">Input Nilai Siswa</a>
            <!-- Modal Structure -->
            <div id="modal3" class="modal">
              <div class="modal-content">
                <h4 class="light">Input Nilai Siswa</h4>
                <p class="light">Upload Nilai anda dibawah : </p>
                <form action="" method="post">
                  <table>
                    <thead>
                      <tr>
                        <th>Email Siswa</th>
                        <th>Nilai Keuletan</th>
                        <th>Nilai Kreativitas</th>
                        <th>Nilai Pengetahuan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($rowsdaftar = mysqli_fetch_assoc($hasilDaftarKelas)) : ?>
                        <tr>
                          <td>
                            <input type="hidden" name="id_subkelas[]" value="<?= $rowsdaftar['id_subkelas'] ?>">
                            <input type="hidden" name="email[]" value="<?= $rowsdaftar['email'] ?>">
                            <h6><?= $rowsdaftar['email'] ?></h6>
                          </td>
                          <td>
                            <div class="input-field">
                              <input name="nilai_ulet[]" id="nilai_ulet" type="text" class="validate">
                              <label for="nilai_ulet">Nilai Keuletan</label>
                            </div>
                          </td>
                          <td>
                            <div class="input-field">
                              <input name="nilai_kreativ[]" id="nilai_kreativ" type="text" class="validate">
                              <label for="nilai_kreativ">Nilai Kreativitas</label>
                            </div>
                          </td>
                          <td>
                            <div class="input-field">
                              <input name="nilai_tahu[]" id="nilai_tahu" type="text" class="validate">
                              <label for="nilai_tahu">Nilai Pengetahuan</label>
                            </div>
                          </td>
                        </tr>
                      <?php endwhile ?>
                    </tbody>
                  </table>
                  <?php
                  $kuericount = mysqli_query($conn, "SELECT COUNT(email) FROM pendaftaran_course WHERE id_subkelas='$id_kelas'");
                  while ($jml = mysqli_fetch_assoc($kuericount)) {
                    # code...
                    $jumlah = $jml['COUNT(email)'];
                  }
                  ?>
                  <input type="hidden" name="count" value="<?= $jumlah ?>">
                  <div class="modal-footer">
                    <button class="btn modal-close waves-effect waves-green btn-flat" name="submit_nilai">Submit</button>
                  </div>
                  <?php
                  if (isset($_POST['submit_nilai'])) {
                    # code...
                    $count = $_POST['count'];

                    for ($i = 0; $i < $count; $i++) {
                      $id_subkelas = $_POST['id_subkelas'][$i];
                      $email = $_POST['email'][$i];
                      $ulet = $_POST['nilai_ulet'][$i];
                      $kreativ = $_POST['nilai_kreativ'][$i];
                      $tahu = $_POST['nilai_tahu'][$i];

                      # code...
                      $tambah = mysqli_query($conn, "INSERT INTO penilaian
                                    (id_subkelas,email,keuletan,kreativitas,pengetahuan) 
                                                        VALUES 
                                    ('$id_subkelas', '$email', '$ulet', '$kreativ','$tahu')");

                      if (mysqli_affected_rows($conn) > 0) {
                        # code...
                        echo "<script>
                                alert('anda berhasil submit nilai')
                                document.location.href='home.php'
                              </script>";
                      } else {
                        # code...
                        mysqli_error($conn);
                      }
                    }
                  }
                  ?>
                </form>
              </div>
            </div>
          </div>
          <div class="card-panel">
            <a class="waves-effect waves-light btn modal-trigger" href="#modal8" style="margin-left: 38px;">Update Nilai Siswa</a>
            <div id="modal8" class="modal">
              <div class="modal-content">
                <h4 class="light">Update Nilai Siswa</h4>
                <p class="light">Upload Nilai anda dibawah : </p>
                <form action="" method="post">
                  <table>
                    <thead>
                      <tr>
                        <th>Email Siswa</th>
                        <th>Nilai Keuletan</th>
                        <th>Nilai Kreativitas</th>
                        <th>Nilai Pengetahuan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($rowsnilai = mysqli_fetch_assoc($hasilNilai)) : ?>
                        <tr>
                          <td>
                            <input type="hidden" name="id_subkelas[]" value="<?= $rowsnilai['id_subkelas'] ?>">
                            <input type="hidden" name="email[]" value="<?= $rowsnilai['email'] ?>">
                            <h6><?= $rowsnilai['email'] ?></h6>
                          </td>
                          <td>
                            <div class="input-field">
                              <input name="nilai_ulet[]" value="<?= $rowsnilai['keuletan'] ?>" id="nilai_ulet" type="text" class="validate">
                              <label for="nilai_ulet">Nilai Keuletan</label>
                            </div>
                          </td>
                          <td>
                            <div class="input-field">
                              <input name="nilai_kreativ[]" value="<?= $rowsnilai['kreativitas'] ?>" id="nilai_kreativ" type="text" class="validate">
                              <label for="nilai_kreativ">Nilai Kreativitas</label>
                            </div>
                          </td>
                          <td>
                            <div class="input-field">
                              <input name="nilai_tahu[]" value="<?= $rowsnilai['pengetahuan'] ?>" id="nilai_tahu" type="text" class="validate">
                              <label for="nilai_tahu">Nilai Pengetahuan</label>
                            </div>
                          </td>
                        </tr>
                      <?php endwhile ?>
                    </tbody>
                  </table>
                  <?php
                  $kuerihit = mysqli_query($conn, "SELECT COUNT(email) FROM pendaftaran_course WHERE id_subkelas='$id_kelas'");
                  while ($hit = mysqli_fetch_assoc($kuerihit)) {
                    # code...
                    $hitung = $hit['COUNT(email)'];
                  }
                  ?>
                  <input type="hidden" name="hitung" value="<?= $hitung ?>">
                  <div class="modal-footer">
                    <button class="btn modal-close waves-effect waves-green btn-flat" name="edit_nilai">Submit</button>
                  </div>
                  <?php
                  if (isset($_POST['edit_nilai'])) {
                    # code...
                    $count = $_POST['hitung'];

                    for ($i = 0; $i < $count; $i++) {
                      $id_subkelas = $_POST['id_subkelas'][$i];
                      $email = $_POST['email'][$i];
                      $ulet = $_POST['nilai_ulet'][$i];
                      $kreativ = $_POST['nilai_kreativ'][$i];
                      $tahu = $_POST['nilai_tahu'][$i];

                      # code...
                      $tambah = mysqli_query($conn, "UPDATE penilaian SET
                                    id_subkelas = '$id_subkelas', email = '$email', keuletan = '$ulet',
                                    kreativitas = '$kreativ', pengetahuan = '$tahu' 
                                    WHERE id_subkelas = '$id_kelas'");

                      if (mysqli_affected_rows($conn) > 0) {
                        # code...
                        echo "<script>
                                alert('anda berhasil edit nilai')
                                document.location.href='home.php'
                              </script>";
                      } else {
                        # code...
                        mysqli_error($conn);
                      }
                    }
                  }
                  ?>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>

  <!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script>
    // sidenav
    const sideNav = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sideNav);
    // modals
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.modal');
      var instances = M.Modal.init(elems);
    });
    // select 
    document.addEventListener('DOMContentLoaded', function() {
      var sel = document.querySelectorAll('select');
      M.FormSelect.init(sel);
    });
  </script>
</body>

</html>