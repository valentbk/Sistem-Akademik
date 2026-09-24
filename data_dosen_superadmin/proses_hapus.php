<?php
// panggil koneksi
require_once '../database/koneksi.php';

$nik = $_GET['nik']; // tampung nik dari url

if (isset($nik)) { // ketika niknya ada atau terisi

    // hapus data dari tabel berdasarkan uniknya
    $query_hapus = mysqli_query($db, "DELETE FROM tbl_dosen WHERE nik = '$nik'") or die(mysqli_error($db));
    $query_pengguna = mysqli_query($db, "DELETE FROM tbl_pengguna WHERE username = '$nik'") or die(mysqli_error($db));
    // menampilkan alert dan mengarahkan ke tabel
    echo '<script>alert("Data berhasil dihapus")</script>';
    echo '<script>window.location.href="../data_dosen_superadmin"</script>';
}
?>