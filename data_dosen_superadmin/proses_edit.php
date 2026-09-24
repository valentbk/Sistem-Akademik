<?php 
// panggil koneksi
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) { // cek button ketika di tekan
    // tampung setap input ke setiap variabel
    $nik = trim(mysqli_real_escape_string($db,$_POST['nik']));
    $nama = trim(mysqli_real_escape_string($db,$_POST['nama']));
    $kontak = trim(mysqli_real_escape_string($db,$_POST['kontak']));
    $email = trim(mysqli_real_escape_string($db,$_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($db,$_POST['kelamin']));

    //edit data input berdasarkan nim
    $query_edit_dosen = mysqli_query($db," UPDATE tbl_dosen SET 
        nama = '$nama',
        kontak = '$kontak',
        email = '$email',
        kelamin = '$kelamin'
        WHERE nik='$nik'") or die(mysqli_error($db));
    $query_edit_penguna = mysqli_query($db," UPDATE tbl_pengguna SET 
        nama = '$nama'
        WHERE username = '$nik'") or die(mysqli_error($db));
        // tampilkan allert dan diarahkan ke index
        echo '<script>alert ("Edit Data Berhasil")</script>';
        echo '<script>window.location.href="../data_dosen_superadmin"</script>';
    
}
?>