<?php
error_reporting(1); // menampilkan error

class Database
{
    private $host = 'localhost';
    private $dbname = 'course';
    private $user = 'root';
    private $password = '';
    private $port = '3306';
    private $conn;

    // function yang pertama kali di load saat class dipanggil
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=utf8", $this->user, $this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function tampil_kelas()
    {
        $query = $this->conn->prepare("SELECT id_kelas, nama_kelas FROM kelas ORDER BY id_kelas");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        // mengembalikan data
        return $data;
        // hapus variable dari memori
        $query->closeCursor();
        unset($email, $data);
    }

    public function daftar_kelas($data)
    {
        $query = $this->conn->prepare("INSERT INTO pendaftaran (email, id_kelas, tanggal_daftar) VALUES (?,?,NOW())");
        $query->execute(array($data['email'], $data['id_kelas']));
        $query->closeCursor();
        unset($data);
    }

    public function registrasi($data)
    {
        $query = $this->conn->prepare("INSERT INTO user (email, nama, password, alamat, role) VALUES (?,?,?,?,?)");
        $query->execute(array($data['email'], $data['nama'], $data['password'], $data['alamat'], $data['role']));
        $query->closeCursor();
        unset($data);
    }

    public function login($email)
    {
        $query = $this->conn->prepare("SELECT * FROM user WHERE email = ?");
        $query->execute(array($email));
        // fetch 1 data
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data;
        // hapus variable dari memori
        $query->closeCursor();
        unset($data);
    }

    public function user()
    {
        $query = $this->conn->prepare("SELECT * FROM user");
        $query->execute();
        // fetch 1 data
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        // hapus variable dari memori
        $query->closeCursor();
        unset($data);
    }

    public function kelas_siswa($kelas)
    {
        $query = $this->conn->prepare("SELECT * FROM pendaftaran,kelas
                                        WHERE pendaftaran.id_kelas=kelas.id_kelas
                                        AND pendaftaran.email = ?");
        $query->execute(array($kelas));
        // fetch 1 data
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        // mengembalikan data
        return $data;
        // hapus variable dari memori
        $query->closeCursor();
        unset($kelas, $data);
    }

    public function tugas($kelas)
    {
        $query = $this->conn->prepare("SELECT a.email,a.file_subtugas FROM submit_tugas a LEFT JOIN tugas b ON a.id_tugas = b.id_tugas WHERE b.id_subkelas = ?");
        $query->execute(array($kelas));
        // fetch 1 data
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        // mengembalikan data
        return $data;
        // hapus variable dari memori
        $query->closeCursor();
        unset($kelas, $data);
    }

    public function materi($kelas)
    {
        $query = $this->conn->prepare("SELECT materi.* FROM materi WHERE materi.id_subkelas = ?");
        $query->execute(array($kelas));
        // fetch 1 data
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        // mengembalikan data
        return $data;
        // hapus variable dari memori
        $query->closeCursor();
        unset($kelas, $data);
    }

    public function submit_tugas($kelas)
    {
        $query = $this->conn->prepare("INSERT INTO submit_tugas
                                            VALUES
                                        (?,?,?,?)");
        $query->execute(array($kelas));
        // fetch 1 data
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        // mengembalikan data
        return $data;
        // hapus variable dari memori
        $query->closeCursor();
        unset($kelas, $data);
    }

    public function submit_materi($kelas)
    {
        $query = $this->conn->prepare("INSERT INTO materi
                                            VALUES
                                        (?,?,?,?,?)");
        $query->execute(array($kelas));
        // fetch 1 data
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        // mengembalikan data
        return $data;
        // hapus variable dari memori
        $query->closeCursor();
        unset($kelas, $data);
    }
}
