<?php
require_once '../database/koneksi.php';

if (isset($_GET['id'])) {
    $id_peserta = $_GET['id'];
    $id_kelas = $_GET['id_kelas'];

    $query_hapus = mysqli_query($db,"DELETE FROM tbl_peserta WHERE id = '$id_peserta'") or die(mysqli_error($db));
        echo '<script>alert("Data Berhasil Dihapus");</script>';
        echo '<script>window.location.href="../data_kelas_matkul_superadmin/detail_kelas.php?id='.$id_kelas.'";</script>';


}


?>