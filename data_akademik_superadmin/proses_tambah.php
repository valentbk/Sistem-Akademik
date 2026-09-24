<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {
    $kode_akd = trim(mysqli_real_escape_string($db,$_POST['kode_akademik']));
    $semester = trim(mysqli_real_escape_string($db,$_POST['semester']));
    $tahun = trim(mysqli_real_escape_string($db,$_POST['tahun']));
    $is_active = trim(mysqli_real_escape_string($db,$_POST['is_active']));

$query_cek = mysqli_query($db,"SELECT * FROM tbl_akademik WHERE kode_akd = '$kode_akd'") or die(mysqli_error($db));
$rv = mysqli_num_rows($query_cek);

if($rv > 0 ) {
    echo '<script>alert("Data Akademik sudah ada");</script>';
    echo '<script>window.location.href="../data_akademik_superadmin/";</script>';
}else{
    $queri_simpan = mysqli_query($db,"INSERT INTO tbl_akademik VALUES ('$kode_akd','$semester','$tahun','$is_active')") or die(mysqli_error($db));
    echo '<script>alert("Data Berhasil Disimpan");</script>';
    echo '<script>window.location.href="../data_akademik_superadmin/";</script>';
}


}
?>

