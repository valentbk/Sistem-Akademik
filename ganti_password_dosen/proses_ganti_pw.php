<?php 

require_once '../database/koneksi.php'; // memanggil koneksi database

if (isset($_POST['btn-ganti'])) { // cek tombol ketika ditekan
    // menampung data dari input
    $username  = trim(mysqli_real_escape_string($db, $_POST['username']));
    $pw_baru   = trim(mysqli_real_escape_string($db, $_POST['password']));
    $c_password = trim(mysqli_real_escape_string($db, $_POST['konfirmasi_password']));

    if ($pw_baru == $c_password) {
        $pw_enkripsi = sha1($pw_baru);
        $query_ganti_password = mysqli_query($db, "UPDATE tbl_pengguna SET
        sandi = '$pw_enkripsi'
        WHERE username = '$username'
        ") or die(mysqli_error($db));
        echo '<script>alert("Ganti Password Berhasil");</script>';
        echo '<script>window.location.href="../logout.php";</script>';
    }else {
        echo '<script>alert("Password Baru dan Konfirmasi Password Tidak Sama");</script>';
        echo '<script>window.location.href="index.php";</script>';
    }
    
    
}

?>