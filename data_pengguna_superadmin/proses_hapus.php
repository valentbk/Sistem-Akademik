<?php 
require_once '../database/koneksi.php';

$id = $_GET['id'];


if (isset($id)) {

$query_hapus =mysqli_query($db,"DELETE FROM tbl_pengguna WHERE id ='$id'") or die(mysqli_error($db));
    echo '<script>alert ("Data berhasil dihapus")</script>';
    echo '<script>window.location.href="../data_pengguna_superadmin"</script>';
}

?>