<?php
// panggil koneksi
require_once '../database/koneksi.php';

$nim = $_GET['nim']; // tampung nim dari url

if (isset($nim)) { // ketika nimnya ada atau terisi

    // hapus data dari tabel berdasarkan uniknya
    $query_hapus = mysqli_query($db, "DELETE FROM tbl_mahasiswa WHERE nim = '$nim'") or die(mysqli_error($db));
    $query_pengguna = mysqli_query($db, "DELETE FROM tbl_pengguna WHERE username = '$nim'") or die(mysqli_error($db));
    // menampilkan alert dan mengarahkan ke tabel
    echo '<script>alert("Data berhasil dihapus")</script>';
    echo '<script>window.location.href="../data_mahasiswa"</script>';
}
?>