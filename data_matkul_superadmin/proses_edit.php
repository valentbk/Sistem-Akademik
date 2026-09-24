<?php 
// panggil koneksi
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) { // cek button ketika di tekan
    // tampung setap input ke setiap variabel
    $kode_matkul = trim(mysqli_real_escape_string($db,$_POST['kode_matkul']));
    $nama_matkul = trim(mysqli_real_escape_string($db,$_POST['nama_matkul']));
    

    //edit data input berdasarkan nim
    $query_edit_mahasiswa = mysqli_query($db," UPDATE tbl_matkul SET 
        nama_matkul ='$nama_matkul'
        WHERE kode_matkul='$kode_matkul'") or die(mysqli_error($db));
        // tampilkan allert dan diarahkan ke index
        echo '<script>alert ("Edit Data Berhasil")</script>';
        echo '<script>window.location.href="../data_matkul_superadmin"</script>';
    
}
?>