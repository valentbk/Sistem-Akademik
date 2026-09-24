<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {
    // Ambil data dari form input 
    $id_kelas = trim(mysqli_real_escape_string($db, $_POST['id_kelas']));
    $nim  = trim(mysqli_real_escape_string($db, $_POST['nim']));
    
    // Cek apakah kombinasi Akademik + Matkul + Nama Kelas sudah pernah ada
    // Supaya 1 Tahun Akademik bisa punya banyak kelas/matkul lain
    $query_cek = mysqli_query($db, "SELECT * FROM tbl_peserta
                                    WHERE nim = '$nim'
                                    AND id_kelas = '$id_kelas'") or die(mysqli_error($db));
    
    $rv = mysqli_num_rows($query_cek);
    if ($rv > 0) {
        echo '<script>alert("data peserta sudah ada!");</script>';
        echo '<script>window.location.href="../data_kelas_matkul_superadmin/detail_kelas.php?id='.$id_kelas.'";</script>';
    } else {
        // Simpan data baru
        $query_simpan = mysqli_query($db, "INSERT INTO tbl_peserta VALUES(NULL,'$id_kelas', '$nim')") or die(mysqli_error($db));
        
        if ($query_simpan) {
            echo '<script>alert("Data Berhasil Disimpan");</script>';
            echo '<script>window.location.href="../data_kelas_matkul_superadmin/detail_kelas.php?id='.$id_kelas.'";</script>';
        }
    }
}
?>