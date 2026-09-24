<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    $id_pertemuan     = trim(mysqli_real_escape_string($db, $_POST['id_pertemuan']));
    $nim              = trim(mysqli_real_escape_string($db, $_POST['nim']));
    $status_kehadiran = trim(mysqli_real_escape_string($db, $_POST['status_kehadiran']));

    // Query untuk mengupdate status kehadiran berdasarkan NIM dan ID Per
    $query_update = mysqli_query($db, "UPDATE tbl_presensi SET status_kehadiran = '$status_kehadiran' WHERE nim = '$nim' AND id_pertemuan = '$id_pertemuan'") or die(mysqli_error($db));

    if ($query_update) {
        echo '<script>alert("Status Kehadiran Berhasil Diperbarui");</script>';
        echo '<script>window.location.href="presensi.php?id=' . $id_pertemuan . '";</script>';
    } else {
        echo '<script>alert("Gagal memperbarui status kehadiran!");</script>';
        echo '<script>window.location.href="presensi.php?id=' . $id_pertemuan . '";</script>';
    }
}
?>