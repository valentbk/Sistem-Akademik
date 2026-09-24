<?php
// panggil koneksi
require_once '../database/koneksi.php';

$kode_akd = $_GET['kode_akd']; // tampung nim dari url

if (isset($kode_akd)) { // ketika nimnya ada atau terisi

    // hapus data dari tabel berdasarkan uniknya
    $query_hapus = mysqli_query($db, "DELETE FROM tbl_akademik WHERE kode_akd = '$kode_akd'") or die(mysqli_error($db));
    // menampilkan alert dan mengarahkan ke tabel
    echo '<script>alert("Data berhasil dihapus")</script>';
    echo '<script>window.location.href="../data_akademik_superadmin"</script>';
}
?>