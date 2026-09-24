<?php
require_once '../database/koneksi.php';

if (isset($_GET['id_pertemuan'])) { 
    $id_pertemuan = trim(mysqli_real_escape_string($db, $_GET['id_pertemuan']));
    $nim = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    
    if(empty($nim)) {
        echo '<script>alert("Sesi login tidak ditemukan. Silakan login kembali.");</script>';
        echo '<script>window.location.href="../login.php";</script>';
        exit;
    }
    
    $query_ambil_status = mysqli_query($db, "SELECT status_pertemuan FROM tbl_pertemuan WHERE id = '$id_pertemuan'") or die(mysqli_error($db));
    $data_status = mysqli_fetch_array($query_ambil_status);
    $status = $data_status['status_pertemuan'];

    if ($status == 0 ) {
        echo '<script>alert("Presensi sudah di tutup");</script>';
        echo '<script>window.location.href="../presensi_mahasiswa/";</script>';
    } else {
        $query_status_kehadiran = mysqli_query($db, "SELECT status_kehadiran FROM tbl_presensi WHERE nim ='$nim' AND id_pertemuan = '$id_pertemuan'") or die(mysqli_error($db));
        
        $data_presensi = mysqli_fetch_array($query_status_kehadiran);
        
        if ($data_presensi) {
            $kehadiran = $data_presensi['status_kehadiran'];
            if ($kehadiran == 'hadir') {
                echo '<script>alert("Kamu telah melakukan presensi ini");</script>';
                echo '<script>window.location.href="../presensi_mahasiswa/";</script>';
            } else {
                $status_hadir  = 'hadir';
                $query_update_kehadiran = mysqli_query($db, "UPDATE tbl_presensi SET status_kehadiran ='$status_hadir' WHERE nim ='$nim' AND id_pertemuan = '$id_pertemuan'") or die(mysqli_error($db));
                echo '<script>alert("Presensi Berhasil");</script>';
                echo '<script>window.location.href="../presensi_mahasiswa/";</script>';
            }
        } else {
             $status_hadir  = 'hadir';
             $query_insert_kehadiran = mysqli_query($db, "INSERT INTO tbl_presensi (id, nim, status_kehadiran, id_pertemuan) VALUES (NULL, '$nim', '$status_hadir', '$id_pertemuan')") or die(mysqli_error($db));
             echo '<script>alert("Presensi Berhasil ditambahkan");</script>';
             echo '<script>window.location.href="../presensi_mahasiswa/";</script>';
        }
    }
}
?>