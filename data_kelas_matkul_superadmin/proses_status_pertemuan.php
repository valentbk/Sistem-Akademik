<?php
require_once '../database/koneksi.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id_pertemuan = mysqli_real_escape_string($db, $_GET['id']);
    $status = mysqli_real_escape_string($db, $_GET['status']);

    // Update status pertemuan (1 untuk aktif/buka, 0 untuk tidak aktif/tutup)
    $query_update = mysqli_query($db, "UPDATE tbl_pertemuan SET status_pertemuan = '$status' WHERE id = '$id_pertemuan'") or die(mysqli_error($db));

    if ($query_update) {
        echo '<script>window.location.href="presensi.php?id='.$id_pertemuan.'";</script>';
    } else {
        echo '<script>alert("Gagal mengubah status pertemuan!");</script>';
        echo '<script>window.location.href="presensi.php?id='.$id_pertemuan.'";</script>';
    }
} else {
    header("Location: index.php");
    exit();
}
?>