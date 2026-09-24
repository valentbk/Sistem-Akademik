<?php 
// panggil koneksi
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) { // cek button ketika di tekan
    // tampung setap input ke setiap variabel
    $nim = trim(mysqli_real_escape_string($db,$_POST['nim']));
    $nama = trim(mysqli_real_escape_string($db,$_POST['nama']));
    $kontak = trim(mysqli_real_escape_string($db,$_POST['kontak']));
    $email = trim(mysqli_real_escape_string($db,$_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($db,$_POST['kelamin']));
    $img = trim(mysqli_real_escape_string($db,$_POST['img']));

    //edit data input berdasarkan nim
    $query_edit_mahasiswa = mysqli_query($db," UPDATE tbl_mahasiswa SET 
        nama = '$nama',
        kontak = '$kontak',
        email = '$email',
        kelamin = '$kelamin',
        img ='$img'
        WHERE nim='$nim'") or die(mysqli_error($db));
    $query_edit_penguna = mysqli_query($db," UPDATE tbl_pengguna SET 
        nama = '$nama'
        WHERE username = '$nim'") or die(mysqli_error($db));
        // tampilkan allert dan diarahkan ke index
        echo '<script>alert ("Edit Data Berhasil")</script>';
        echo '<script>window.location.href="../data_mahasiswa"</script>';
    
}
?>