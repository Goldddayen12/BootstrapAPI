<?php
header('Content-Type: application/json; charset=utf-8');

$koneksi = mysqli_connect("localhost","root","","absen_db");

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'get_single') {
        $id = $_GET['id'];
        $sql = "SELECT * FROM siswa WHERE id = '$id'";
        $query = mysqli_query($koneksi, $sql);
        $array_data = array();
        while ($data = mysqli_fetch_assoc($query)) {
            $array_data[] = $data;
        }
        echo json_encode($array_data);
    } else {
        $sql = "SELECT * FROM siswa";
        $query = mysqli_query($koneksi, $sql);
        $array_data = array();
        while ($data = mysqli_fetch_assoc($query)) {
            $array_data[] = $data;
        }
        echo json_encode($array_data);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $sql = "INSERT INTO siswa (nama_lengkap, kelas, jurusan) VALUES ('$nama_lengkap', '$kelas', '$jurusan')";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            "status" => "Data berhasil ditambah",
        ];
        echo json_encode([$data]);
    }else{
        $data = [
            "status" => "Data gagal ditambah",
        ];
        echo json_encode([$data]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $id = $_GET['id'];
    $sql = "DELETE FROM siswa WHERE id = '$id'";
    $cek = mysqli_query($koneksi, $sql);

    if($cek){
        $data = [
            "status" => "Data berhasil dihapus",
        ];
        echo json_encode([$data]);
    }else{
        $data = [
            "status" => "Data gagal dihapus",
        ];
        echo json_encode([$data]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT'){
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        $id = $_GET['id'];
        $nama_lengkap = $_GET['nama_lengkap'];
        $kelas = $_GET['kelas'];
        $jurusan = $_GET['jurusan'];

        $sql = "UPDATE siswa SET nama_lengkap = '$nama_lengkap', kelas = '$kelas', jurusan = '$jurusan' WHERE id = '$id'";
        $cek = mysqli_query($koneksi, $sql);

        if($cek){
            $data = [
                "status" => "Data berhasil diUpdate",
            ];
            echo json_encode([$data]);
        }else{
            $data = [
                "status" => "Data gagal diUpdate",
            ];
            echo json_encode([$data]);
        }
    } else {
        $data = [
            "status" => "Aksi tidak valid",
        ];
        echo json_encode([$data]);
    }
}
