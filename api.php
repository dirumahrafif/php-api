<?php 
error_reporting(0);

$host = "localhost";
$user = "root";
$pass = "root";
$db   = "api";

$koneksi = mysqli_connect($host,$user,$pass,$db);

$op = $_GET['op'];
switch($op){
    case '':normal();break;
    default:normal();break;
    case 'create':create();break;
    case 'detail':detail();break;
    case 'update':update();break;
    case 'delete':delete();break;
}

function normal(){
    global $koneksi;
    $sql1 = "select * from pegawai order by id desc";
    $q1 = mysqli_query($koneksi,$sql1);
    while($r1 = mysqli_fetch_array($q1)){
        $hasil[] = array(
            'id' => $r1['id'],
            'nama' => $r1['nama'],
            'alamat' => $r1['alamat'],
            'tgl_input' => $r1['tgl_input']
        );
    }
    $data['data']['result'] = $hasil;
    echo json_encode($data);
}

function create(){
    global $koneksi;
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $hasil = "Gagal dimasukkan data";
    if($nama and $alamat){
        $sql1 = "insert into pegawai(nama,alamat) values ('$nama','$alamat')";
        $q1 = mysqli_query($koneksi,$sql1);
        if($q1){
            $hasil = "Berhasil menambahkan data";
        }
    }
    $data['data']['result'] = $hasil;
    echo json_encode($data);
}

function detail(){
    global $koneksi;
    $id = $_GET['id'];
    $sql1 = "select * from pegawai where id = '$id'";
    $q1 = mysqli_query($koneksi,$sql1);
    while($r1 = mysqli_fetch_array($q1)){
        $hasil[] = array(
            'id' => $r1['id'],
            'nama' => $r1['nama'],
            'alamat' => $r1['alamat'],
            'tgl_input' => $r1['tgl_input']
        );
    }
    $data['data']['result'] = $hasil;
    echo json_encode($data);
}

function update(){
    global $koneksi;
    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    if($nama){
        $set[] = "nama='$nama'";
    }
    if($alamat){
        $set[] = "alamat='$alamat'";
    }
    $hasil = "Gagal melakukan update data";
    if($nama or $alamat){
        $sql1 = "update pegawai set ".implode(",",$set).",tgl_input=now() where id = '$id'";
        $q1 = mysqli_query($koneksi,$sql1);
        if($q1){
            $hasil = "Data berhasil diupdate";
        }
    }
    $data['data']['result'] = $hasil;
    echo json_encode($data);
}

function delete(){
    global $koneksi;
    $id = $_GET['id'];
    $sql1 = "delete from pegawai where id = '$id'";
    $q1 = mysqli_query($koneksi,$sql1);
    if($q1){
        $hasil = "Berhasil menghapus data";
    }else{
        $hasil = "Gagal menghapus data";
    }
    $data['data']['result'] = $hasil;
    echo json_encode($data);
}