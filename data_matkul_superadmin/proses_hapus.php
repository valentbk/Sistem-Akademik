<?php
// panggil koneksi
require_once '../database/koneksi.php';

$kode_matkul = $_GET['kode_matkul']; // tampung  dari url

if (isset($kode_matkul)) { // ketika  ada atau terisi

    // hapus data dari tabel berdasarkan uniknya
    $query_hapus = mysqli_query($db, "DELETE FROM tbl_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($db));
    // menampilkan alert dan mengarahkan ke tabel
    echo '<script>alert("Data berhasil dihapus")</script>';
    echo '<script>window.location.href="../data_matkul_superadmin"</script>';
}
?>