<?php 

require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    $nama = trim(mysqli_real_escape_string($db,$_POST['nama']));
    $username = trim(mysqli_real_escape_string($db,$_POST['username']));
    $peran = trim(mysqli_real_escape_string($db,$_POST['peran']));
    $id = trim(mysqli_real_escape_string($db,$_POST['id']));

    $query_edit_pengguna = mysqli_query($db,"UPDATE tbl_pengguna SET 
        nama = '$nama',
        username ='$username',
        peran = '$peran'
        WHERE id='$id'") or die(mysqli_error($db));
        echo '<script>alert ("Edit Data Berhasil")</script>';
        echo '<script>window.location.href="../data_pengguna_superadmin"</script>';
    
}
?>