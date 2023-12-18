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
    public function user()
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
    public function login($user)
    {
        $user = $this->filter($user);
        $client = curl_init($this->url . "?aksi=tampil&user=" . $user);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($client);
        curl_close($client);
        $data = json_decode($response);
        return $data;
        unset($user, $client, $response, $data);
    }

    public function register($data)
    {
        $data = '{  "email":"' . $data['email'] . '",
                    "nama":"' . $data['nama'] . '",
                    "alamat":"' . $data['alamat'] . '",
                    "password":"' . $data['password'] . '",
                    "role":"' . $data['role'] . '",
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

    public function ubah_job($data)
    {
        $data = '{  "email":"' . $data['email'] . '",
            "nama":"' . $data['nama'] . '",
            "alamat":"' . $data['alamat'] . '",
            "password":"' . $data['password'] . '",
            "role":"' . $data['role'] . '",
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

    public function hapus_job($data)
    {
        $email = $this->filter($data['email']);
        $data = '{  "email":"' . $email . '",
                    "aksi":"' . $data['aksi'] . '"
                }';
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $this->url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($c);
        curl_close($c);
        unset($email, $data, $c, $response);
    }

    // function yang terakhir kali di-load saat class dipanggil
    public function __destruct()
    { // hapus variable dari memory 
        unset($this->url);
    }
}

$url = 'http://192.168.56.73/course-server/server/server_user.php';
// buat objek baru dari class client
$abc = new Client($url);
