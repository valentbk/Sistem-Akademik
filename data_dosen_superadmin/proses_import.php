<?php 
// panggil koneksi
require_once '../database/koneksi.php';
// panggil library
require '../vendor/autoload.php';
// panggil fugsi phpspreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['btn-import'])) { // cek button ketika di tekan
    // tampung nama input ke setiap variabel
    $file = $_FILES['file_dosen']['name'];
    // memisahkan ekstensi dengan titik dari nama file
    $ekstensi = explode('.',$file);
    // membuat nama file unix
    $nama_file = 'file'.round(microtime(true)).'.'.end($ekstensi);
    
    //mengambil alamat sumber file (temporary atau sementara)
    $alamat_sumber = $_FILES['file_dosen']['tmp_name'];
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
    $nik = $row [1];
    $nama = $row [2];
    $kontak = $row [3];
    $email = $row [4];
    $kelamin = $row [5];
    

    // ketika data yang ditampung kosong
    if ($nik == '' OR $nama == '' OR $kontak == '' OR $email == '' OR $kelamin == '') { 
        continue; // skip perulangan

    }
    //cek data jurusan dari database (ambil data)
    $query_cek = mysqli_query($db,"SELECT * FROM tbl_dosen WHERE nik = '$nik' OR nama ='$nama' OR kontak = '$kontak' OR email = '$email'") or die(mysqli_error($db));
    // ambil jumlah data
    $rv = mysqli_num_rows($query_cek);

    // jika datanya tidak ada di database
    if($rv == 0) {
        $sandi = sha1($nik);
        $peran = "D";
        $pin   = "12345";

        // simpan data ke database
       $queri_simpan = mysqli_query($db,"INSERT INTO tbl_dosen VALUES ('$nik','$nama','$kontak','$email','$kelamin', null)") or die(mysqli_error($db));
       $query_cek_pengguna = mysqli_query($db, "SELECT username FROM tbl_pengguna WHERE username = '$nik'") or die(mysqli_error($db));
        $rv_pengguna = mysqli_num_rows($query_cek_pengguna);
        
        if ($rv_pengguna == 0) {
            // simpan data ke tbl_pengguna
            $query_simpan_pengguna = mysqli_query($db, "INSERT INTO tbl_pengguna VALUES (NULL,'$nik', '$sandi', '$peran', '$nama', '$pin')") or die(mysqli_error($db));
        }

    }

    }
    unlink($alamat_tujuan); // hapus file
    // alert
    echo '<script>alert("Data Berhasil Di Import");</script>';
    echo '<script>window.location.href="../data_dosen_superadmin/";</script>'; 
    

    
}
?>