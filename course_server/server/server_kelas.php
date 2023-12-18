<?php
error_reporting(1);
include "database.php";
$abc = new Database();

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}
$postdata = file_get_contents("php://input");

// fungsi untuk menghapus selain huruf dan angka
function filter($data)
{
    $data = preg_replace('/[^a-zA-Z0-9]/', '', $data);
    return $data;
    unset($data);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode($postdata);
    $email = $data->email;
    $id_kelas = $data->id_kelas;
    // $id_daftar = $data->id_daftar;
    $tanggal_daftar = $data->tanggal_daftar;
    $aksi = $data->aksi;


    if ($aksi == 'daftarkelas') {
        $data2 = array(
            // 'id_daftar' => $id_daftar,
            'email' => $email,
            'id_kelas' => $id_kelas
            // 'tanggal_daftar' => $tanggal_daftar
        );
        $abc->daftar_kelas($data2);
    } 

    // elseif ($aksi == 'ubah') {
    //     $data2 = array(
    //         '' => $,
    //         'nama_barang' => $nama_barang,
    //         'stok_barang' => $stok_barang,
    //         'harga_satuan' => $harga_satuan,
    //     );
    //     $abc->ubah_data($data2);
    // } elseif ($aksi == 'hapus') {
    //     $abc->hapus_data($);
    // }
    unset($input, $data, $data2, $id_daftar, $email, $id_kelas, $tanggal_daftar, $aksi, $abc);
} 

elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ((isset($_GET['email']))) 
    {
        $email = filter_var($_GET['email']);	
		$data=$abc->kelas_siswa($email);
		echo json_encode($data);
	} else  //menampilkan semua data 
	{	$data = $abc->tampil_kelas();
		echo json_encode($data);     
	}
	unset($postdata,$data,$email,$abc);	
}
