<?php
require_once '../database/koneksi.php';

if (isset($_GET['id'])) {
    // Ambil dan amankan ID dari parameter URL
    $id = trim(mysqli_real_escape_string($db, $_GET['id']));

    // Eksekusi Query Hapus Data berdasarkan ID
    $query_hapus = mysqli_query($db, "DELETE FROM tbl_kelas_matkul WHERE id = '$id'") or die(mysqli_error($db));

    if ($query_hapus) {
        echo '<script>alert("Data Berhasil Dihapus");</script>';
        echo '<script>window.location.href="../data_kelas_matkul_superadmin/";</script>';
    }
} else {
    // Jika file diakses langsung tanpa parameter ID
    header("Location: ../data_kelas_matkul_superadmin/");
    exit();
}
?>