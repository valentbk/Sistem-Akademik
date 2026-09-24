<?php
// panggil koneksi
require_once '../database/koneksi.php';

$kode_jurusan = $_GET['kode_jurusan']; // tampung  dari url

if (isset($kode_jurusan)) { // ketika  ada atau terisi

    // hapus data dari tabel berdasarkan uniknya
    $query_hapus = mysqli_query($db, "DELETE FROM tbl_jurusan WHERE kode_jurusan = '$kode_jurusan'") or die(mysqli_error($db));
    // menampilkan alert dan mengarahkan ke tabel
    echo '<script>alert("Data berhasil dihapus")</script>';
    echo '<script>window.location.href="../data_jurusan_superadmin"</script>';
}
?>