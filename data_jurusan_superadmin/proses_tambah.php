<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {
    $kode_jurusan = trim(mysqli_real_escape_string($db,$_POST['kode_jurusan']));
    $nama_jurusan = trim(mysqli_real_escape_string($db,$_POST['nama_jurusan']));

$query_cek = mysqli_query($db,"SELECT * FROM tbl_jurusan WHERE kode_jurusan = '$kode_jurusan' OR nama_jurusan ='$nama_jurusan'") or die(mysqli_error($db));
$rv = mysqli_num_rows($query_cek);

if($rv > 0 ) {
    echo '<script>alert("Data Jurusan sudah ada");</script>';
    echo '<script>window.location.href="../data_jurusan_superadmin/";</script>';
}else{
    $queri_simpan = mysqli_query($db,"INSERT INTO tbl_jurusan VALUES ('$kode_jurusan','$nama_jurusan')") or die(mysqli_error($db));
    echo '<script>alert("Data Berhasil Disimpan");</script>';
    echo '<script>window.location.href="../data_jurusan_superadmin/";</script>';
}


}
?>

