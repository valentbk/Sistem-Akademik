<?php 

require_once '../database/koneksi.php'; // memanggil koneksi database

if (isset($_POST['btn-tambah'])) { // cek tombol ketika ditekan
    // menampung data dari input
    $nim     = trim(mysqli_real_escape_string($db, $_POST['nim']));
    $nama    = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $kontak  = trim(mysqli_real_escape_string($db, $_POST['kontak']));
    $email   = trim(mysqli_real_escape_string($db, $_POST['email']));
    $kelamin = trim(mysqli_real_escape_string($db, $_POST['kelamin']));
    $img     = trim(mysqli_real_escape_string($db, $_POST['img']));
    
    // mengecek apakah NIM sudah ada di tbl_mahasiswa
    $query_cek_nim = mysqli_query($db, "SELECT nim FROM tbl_mahasiswa WHERE nim = '$nim'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek_nim);
    
    if ($rv > 0) {
        // tampilkan alert dan mengarahkan kembali ke form tambah
        echo '<script>alert("Data pengguna sudah ada");</script>';
        echo '<script>window.location.href="tambah.php";</script>';
    } else { 
        $sandi = sha1($nim);
        $peran = "M";
        $pin   = "12345";

        // simpan data ke tbl_mahasiswa
        $query_simpan = mysqli_query($db, "INSERT INTO tbl_mahasiswa VALUES ('$nim', '$nama', '$kontak', '$email', '$kelamin', NULL)") or die(mysqli_error($db));
        
        // cek apakah username (NIM) sudah ada di tbl_pengguna
        $query_cek_pengguna = mysqli_query($db, "SELECT username FROM tbl_pengguna WHERE username = '$nim'") or die(mysqli_error($db));
        $rv_pengguna = mysqli_num_rows($query_cek_pengguna);
        
        if ($rv_pengguna == 0) {
            // simpan data ke tbl_pengguna
            $query_simpan_pengguna = mysqli_query($db, "INSERT INTO tbl_pengguna VALUES (NULL, '$nim', '$sandi', '$peran', '$nama', '$pin')") or die(mysqli_error($db));
        }
        // tampilkan alert dan mengarahkan ke halaman index/data_mahasiswa
        echo '<script>alert("Tambah Data Berhasil");</script>';
        echo '<script>window.location.href="../data_mahasiswa";</script>';
    }
}

?>