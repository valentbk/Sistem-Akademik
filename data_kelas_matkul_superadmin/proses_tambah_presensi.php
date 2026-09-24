<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {
    $id_pertemuan     = trim(mysqli_real_escape_string($db, $_POST['id_pertemuan']));
    $nim              = trim(mysqli_real_escape_string($db, $_POST['nim']));
    $status_kehadiran = trim(mysqli_real_escape_string($db, $_POST['status_kehadiran']));

    $query_simpan = mysqli_query($db, "INSERT INTO tbl_presensi (id, nim, status_kehadiran, id_pertemuan) VALUES (NULL, '$nim', '$status_kehadiran', '$id_pertemuan')") or die(mysqli_error($db));

    if ($query_simpan) {
        echo '<script>alert("Data Presensi Berhasil Ditambahkan");</script>';
        echo '<script>window.location.href="presensi.php?id='.$id_pertemuan.'";</script>';
    } else {
        echo '<script>alert("Gagal menambahkan data presensi!");</script>';
        echo '<script>window.location.href="presensi.php?id='.$id_pertemuan.'";</script>';
    }
}
?>