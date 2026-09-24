<?php 
// panggil koneksi
require_once '../database/koneksi.php';
// panggil library
require '../vendor/autoload.php';
// panggil fugsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn-import'])) { // cek button ketika di tekan
    // tampung nama input ke setiap variabel (ditambahkan pengecekan isset untuk menghindari undefined key)
    $file = $_FILES['file_jurusan']['name'];
    // memisahkan ekstensi dengan titik dari nama file
    $ekstensi = explode('.',$file);
    // membuat nama file unix
    $nama_file = 'file'.round(microtime(true)).'.'.end($ekstensi);
    
    //mengambil alamat sumber file (temporary atau sementara)
    $alamat_sumber = $_FILES['file_jurusan']['tmp_name'];
    // membuat alamat tujuan atau alamat file disimpan 
    $alamat_tujuan = 'template/'.$nama_file;
    //upload file (pindahkan file dari alamat sumber ke alamat tujuan)
    move_uploaded_file($alamat_sumber,$alamat_tujuan);

    // membaca file exel
    $file_spreadsheet = IOFactory::load($alamat_tujuan);
    //membaca exel yang aktif (menggunakan kurung buka tutup getgetActiveSheet())
    $sheet = $file_spreadsheet->getActiveSheet();
    // tampung data jadikan array
    $data = $sheet->toArray();
    // perulangan membaca array
    foreach ($data as $index => $row) {
        // cek kolom judul
        if ($index == 0) {
            continue; //skip perulangan 
        }
    // tampung data dari exel ke variabel berdasarkan kolom nya 
    $kode_jurusan = $row[1];
    $nama_jurusan = $row[2];

    // ketika data yang ditampung kosong
    if ($kode_jurusan == '' OR $nama_jurusan == '') { 
        continue; // skip perulangan

    }
    //cek data jurusan dari database (ambil data)
    $query_cek = mysqli_query($db,"SELECT * FROM tbl_jurusan WHERE kode_jurusan = '$kode_jurusan' OR nama_jurusan ='$nama_jurusan'") or die(mysqli_error($db));
    // ambil jumlah data
    $rv = mysqli_num_rows($query_cek);

    // jika datanya tidak ada di database
    if($rv == 0) {
        // simpan data ke database
       $queri_simpan = mysqli_query($db,"INSERT INTO tbl_jurusan VALUES ('$kode_jurusan','$nama_jurusan')") or die(mysqli_error($db));
    }

    }
    unlink($alamat_tujuan); // hapus file
    // alert
    echo '<script>alert("Data Berhasil Di Import");</script>';
    echo '<script>window.location.href="../data_jurusan_superadmin/";</script>'; 
}
?>