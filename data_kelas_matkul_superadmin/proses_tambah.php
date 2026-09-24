<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {
    // Ambil data dari form input 
    $kode_akd     = trim(mysqli_real_escape_string($db, $_POST['kode_akd']));
    $kode_jurusan = trim(mysqli_real_escape_string($db, $_POST['kode_jurusan']));
    $kode_matkul  = trim(mysqli_real_escape_string($db, $_POST['kode_matkul']));
    $nik          = trim(mysqli_real_escape_string($db, $_POST['nik']));
    $nama_kelas   = trim(mysqli_real_escape_string($db, $_POST['nama_kelas']));
    
    // Cek apakah kombinasi Akademik + Matkul + Nama Kelas sudah pernah ada
    // Supaya 1 Tahun Akademik bisa punya banyak kelas/matkul lain
    $query_cek = mysqli_query($db, "SELECT * FROM tbl_kelas_matkul 
                                    WHERE kode_akd = '$kode_akd' 
                                    AND kode_matkul = '$kode_matkul' 
                                    AND nama_kelas = '$nama_kelas'") or die(mysqli_error($db));
    
    $rv = mysqli_num_rows($query_cek);

    if ($rv > 0) {
        echo '<script>alert("Kelas untuk Mata Kuliah dan Tahun Akademik ini sudah ada!");</script>';
        echo '<script>window.location.href="../data_kelas_matkul_superadmin/";</script>';
    } else {
        // Simpan data baru
        $query_simpan = mysqli_query($db, "INSERT INTO tbl_kelas_matkul (kode_akd, kode_jurusan, kode_matkul, nik, nama_kelas) 
                                           VALUES ('$kode_akd', '$kode_jurusan', '$kode_matkul', '$nik', '$nama_kelas')") or die(mysqli_error($db));
        
        if ($query_simpan) {
            echo '<script>alert("Data Berhasil Disimpan");</script>';
            echo '<script>window.location.href="../data_kelas_matkul_superadmin/";</script>';
        }
    }
}
?>