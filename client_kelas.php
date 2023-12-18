<?php
error_reporting(1);
class Client
{
    private $url;

    // function yan pertama kali di load saat class dipanggil 
    public function __construct($url)
    {
        $this->url = $url;
        unset($url);
    }

    // function untuk menghapus selain huruf dan angka
    public function filter($data)
    {
        $data = preg_replace('/[^a-zA-Z0-9]/', '', $data);
        return $data;
        unset($data);
    }
    //TAMPIL SEMUA DATA
    public function tampil_semua_berkas()
    {
        $client = curl_init($this->url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($client);
        curl_close($client);
        $data = json_decode($response);
        // mengembalikan data 
        return $data;
        // menghapus variabel dari memory 
        unset($data, $client, $response);
    }

    //TAMPIL DATA
    public function tampil_berkas($id_berkas)
    {
        $id_berkas = $this->filter($id_berkas);
        $client = curl_init($this->url . "?aksi=tampil&kelas=" . $id_berkas);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($client);
        curl_close($client);
        $data = json_decode($response);
        return $data;
        unset($id_berkas, $client, $response, $data);
    }

    public function tambah_kelas($data)
    {
        $data = '{  "id_kelas":"' . $data['id_kelas'] . '",
                    "email":"' . $data['email'] . '",
                    "file":"' . $data['file'] . '",
                    "portofolio":"' . $data['portofolio'] . '",
                    "ijazah":"' . $data['ijazah'] . '",
                    "aksi":"' . $data['aksi'] . '"
                }';
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($c);
        curl_close($c);
        unset($data, $c, $response);
    }

    // public function ubah_user($data)
    // {
    //     $data = '{  "id_kelas":"' . $data['id_kelas'] . '",
    //         "email":"' . $data['email'] . '",
    //         "file":"' . $data['file'] . '",
    //         "portofolio":"' . $data['portofolio'] . '",
    //         "ijazah":"' . $data['ijazah'] . '",
    //         "aksi":"' . $data['aksi'] . '"
    //     }';
    //     $c = curl_init();
    //     curl_setopt($c, CURLOPT_URL, $this->url);
    //     curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($c, CURLOPT_POST, true);
    //     curl_setopt($c, CURLOPT_POSTFIELDS, $data);
    //     $response = curl_exec($c);
    //     curl_close($c);
    //     unset($data, $c, $response);
    // }

    public function hapus_course($data)
    {
        $id_kelas = $this->filter($data['id_kelas']);
        $data = '{  "id_kelas":"' . $id_kelas . '",
                    "aksi":"' . $data['aksi'] . '"
                }';
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($c);
        curl_close($c);
        unset($id_kelas, $data, $c, $response);
    }

    // function yang terakhir kali di-load saat class dipanggil
    public function __destruct()
    { // hapus variable dari memory 
        unset($this->url);
    }
}

$url = 'http://192.168.56.73/course-server/server/server_kelas.php';
// buat objek baru dari class client
$abc = new Client($url);
