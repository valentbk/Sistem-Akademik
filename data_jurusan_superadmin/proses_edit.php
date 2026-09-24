<?php 
// panggil koneksi
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) { // cek button ketika di tekan
    // tampung setap input ke setiap variabel
    $kode_jurusan = trim(mysqli_real_escape_string($db,$_POST['kode_jurusan']));
    $nama_jurusan = trim(mysqli_real_escape_string($db,$_POST['nama_jurusan']));
    

    //edit data input berdasarkan nim
    $query_edit_jurusan = mysqli_query($db," UPDATE tbl_jurusan SET 
        nama_jurusan ='$nama_jurusan'
        WHERE kode_jurusan='$kode_jurusan'") or die(mysqli_error($db));
        // tampilkan allert dan diarahkan ke index
        echo '<script>alert ("Edit Data Berhasil")</script>';
        echo '<script>window.location.href="../data_jurusan_superadmin"</script>';
    
}
?>