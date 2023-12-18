<?php
include "koneksi.php";

$kelas = $_POST['id_kelas'];
$tampil = mysqli_query($conn, "SELECT * FROM subkelas WHERE id_kelas='$kelas'");
$row = mysqli_num_rows($tampil);

if ($row > 0) {
    while ($r = mysqli_fetch_array($tampil)) {
?>
        <option value="<?= $r['id_subkelas'] ?>"><?= $r['nama_subkelas'] ?></option>
<?php
    }
} else {
    echo "<option selected>- Data Tidak Ada, Pilih Yang Lain -</option>";
}

?>

<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
    // select
    $(document).ready(function() {
        $('select').formSelect();
    });
</script>