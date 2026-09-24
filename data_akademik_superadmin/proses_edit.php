<?php 
// panggil koneksi
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) { // cek button ketika di tekan
    // tampung setap input ke setiap variabel
    $kode_akd = trim(mysqli_real_escape_string($db,$_POST['kode_akd']));
    $semester = trim(mysqli_real_escape_string($db,$_POST['semester']));
    $tahun = trim(mysqli_real_escape_string($db,$_POST['tahun']));
    $is_active = trim(mysqli_real_escape_string($db,$_POST['is_active']));
    
    //edit data input berdasarkan nim
    $query_edit_akademik = mysqli_query($db," UPDATE tbl_akademik SET 
        semester ='$semester',
        tahun = '$tahun',
        is_active = '$is_active'
        WHERE kode_akd='$kode_akd'") or die(mysqli_error($db));
        // tampilkan allert dan diarahkan ke index
        echo '<script>alert ("Edit Data Berhasil")</script>';
        echo '<script>window.location.href="../data_akademik_superadmin"</script>';
    
}
?>