<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    // Ambil data dari form modal edit
    $id           = trim(mysqli_real_escape_string($db, $_POST['id']));
    $kode_akd     = trim(mysqli_real_escape_string($db, $_POST['kode_akd']));
    $kode_jurusan = trim(mysqli_real_escape_string($db, $_POST['kode_jurusan']));
    $kode_matkul  = trim(mysqli_real_escape_string($db, $_POST['kode_matkul']));
    $nik          = trim(mysqli_real_escape_string($db, $_POST['nik']));
    $nama_kelas   = trim(mysqli_real_escape_string($db, $_POST['nama_kelas']));

    // Cek apakah kombinasi Akademik + Matkul + Nama Kelas sudah digunakan oleh DATA LAIN
    $query_cek = mysqli_query($db, "SELECT * FROM tbl_kelas_matkul 
                                    WHERE kode_akd = '$kode_akd' 
                                    AND kode_matkul = '$kode_matkul' 
                                    AND nama_kelas = '$nama_kelas' 
                                    AND id != '$id'") or die(mysqli_error($db));

    if (mysqli_num_rows($query_cek) > 0) {
        echo '<script>alert("Kombinasi Kelas, Matkul, dan Tahun Akademik ini sudah ada pada data lain!");</script>';
        echo '<script>window.location.href="../data_kelas_matkul_superadmin/";</script>';
    } else {
        // Eksekusi Update Data
        $query_update = mysqli_query($db, "UPDATE tbl_kelas_matkul SET 
                                            kode_akd     = '$kode_akd',
                                            kode_jurusan = '$kode_jurusan',
                                            kode_matkul  = '$kode_matkul',
                                            nik          = '$nik',
                                            nama_kelas   = '$nama_kelas' 
                                           WHERE id = '$id'") or die(mysqli_error($db));

        if ($query_update) {
            echo '<script>alert("Data Berhasil Diperbarui");</script>';
            echo '<script>window.location.href="../data_kelas_matkul_superadmin/";</script>';
        }
    }
}
?>