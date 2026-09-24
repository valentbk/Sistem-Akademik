<?php 
// panggil koneksi
require_once '../database/koneksi.php';
// panggil library
require '../vendor/autoload.php';
// panggil fugsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn-import'])) { // cek button ketika di tekan
    // tampung nama input ke setiap variabel
    $file = $_FILES['file_mahasiswa']['name'];
    $id_kelas = trim(mysqli_real_escape_string($db, $_POST['id_kelas']));
    // memisahkan ekstensi dengan titik dari nama file
    $ekstensi = explode('.',$file);
    // membuat nama file unix
    $nama_file = 'file'.round(microtime(true)).'.'.end($ekstensi);
    
    //mengambil alamat sumber file (temporary atau sementara)
    $alamat_sumber = $_FILES['file_mahasiswa']['tmp_name'];
    // membuat alamat tujuan atau alamat file disimpan 
    $alamat_tujuan = 'template/'.$nama_file;
    //upload file (pindahkan file dari alamat sumber ke alamat tujuan)
    move_uploaded_file($alamat_sumber,$alamat_tujuan);

    // membaca file exel
    $file_spreadsheet = IOFactory::load($alamat_tujuan);
    //membaca exel yang aktif
    $sheet = $file_spreadsheet->getActiveSheet();
    // tampung data jadikan array
    $data = $sheet->toArray();
    // perulangan membaca array
    foreach ($data as $index => $row) {
        // cek kolom judul
        if ($index == 0) {continue; //skip perulangan 
        }
    // tampung data dari exel ke variabel berdasarkan kolom nya 
    $nim = $row [1];
    

    // ketika data yang ditampung kosong
    if ($nim == '') { 
        continue; // skip perulangan

    }
    //cek data jurusan dari database (ambil data)
    $query_cek = mysqli_query($db,"SELECT * FROM tbl_peserta WHERE nim = '$nim' AND id_kelas = '$id_kelas'") or die(mysqli_error($db));
    // ambil jumlah data
    $rv = mysqli_num_rows($query_cek);

    // jika datanya tidak ada di database
    if($rv == 0) {

        // simpan data ke database
       $queri_simpan = mysqli_query($db,"INSERT INTO tbl_peserta VALUES (NULL,'$id_kelas', '$nim')") or die(mysqli_error($db));

    }

    }
    unlink($alamat_tujuan); // hapus file
    // alert
    echo '<script>alert("Data Berhasil Di Import");</script>';
    echo '<script>window.location.href="../data_kelas_matkul_superadmin/detail_kelas.php?id='.$id_kelas.'";</script>'; 
    

    
}
?>