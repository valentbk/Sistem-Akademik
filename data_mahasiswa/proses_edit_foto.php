<?php 
// panggil koneksi
require_once '../database/koneksi.php';

if (isset($_POST['btn-editfoto'])) { // cek button ketika di tekan
    // tampung setap input ke setiap variabel
    $nim = trim(mysqli_real_escape_string($db,$_POST['nim']));
    $file = $_FILES['foto']['name'];
    $ekstensi = explode('.',$file);
    $nama_file = 'foto-mhs'.round(microtime(true)).'.'.end($ekstensi);
    
    $alamat_sumber = $_FILES['foto']['tmp_name'];
    $alamat_tujuan = '../asset_adminlte/img/'.$nama_file;
    move_uploaded_file($alamat_sumber,$alamat_tujuan);

    $query_update_foto = mysqli_query($db,"UPDATE tbl_mahasiswa SET
    img = '$alamat_tujuan'
    WHERE nim = '$nim'
    ") or die(mysqli_error($db));
    echo '<script>alert ("Edit Foto Berhasil")</script>';
    echo '<script>window.location.href="../data_mahasiswa"</script>';
    
    
}
?>