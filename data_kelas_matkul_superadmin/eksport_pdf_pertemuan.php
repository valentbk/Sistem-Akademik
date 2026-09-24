<?php
require_once '../database/koneksi.php';
require('../asset_adminlte/fpdf/fpdf.php');

$id_kelas = isset($_GET['id']) ? mysqli_real_escape_string($db, $_GET['id']) : '';

$q_kelas = mysqli_query($db, "SELECT * FROM tbl_kelas_matkul WHERE id_kelas = '$id_kelas'");
if ($d_kelas = mysqli_fetch_array($q_kelas)) {
    $nama_kelas = $d_kelas['nama_kelas'];
    
    $q_dosen = mysqli_query($db, "SELECT nama FROM tbl_dosen WHERE nik = '".$d_kelas['nik']."'");
    if($d_dosen = mysqli_fetch_array($q_dosen)) $nama_dosen = $d_dosen['nama'];

    $q_akd = mysqli_query($db, "SELECT tahun, semester FROM tbl_akademik WHERE kode_akd = '".$d_kelas['kode_akd']."'");
    if($d_akd = mysqli_fetch_array($q_akd)) $periode = $d_akd['tahun'] . ' - ' . $d_akd['semester'];

    $q_jurusan = mysqli_query($db, "SELECT nama_jurusan FROM tbl_jurusan WHERE kode_jurusan = '".$d_kelas['kode_jurusan']."'");
    if($d_jurusan = mysqli_fetch_array($q_jurusan)) $nama_jurusan = $d_jurusan['nama_jurusan'];

    $q_matkul = mysqli_query($db, "SELECT nama_matkul FROM tbl_matkul WHERE kode_matkul = '".$d_kelas['kode_matkul']."'");
    if($d_matkul = mysqli_fetch_array($q_matkul)) $nama_matkul = $d_matkul['nama_matkul'];
}

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../asset_adminlte/img/logo Universitas Peradaban.png', 10, 12, 40);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 8, 'Fakultas Sains Dan Teknologi', 0, 2, 'C');
        $this->Cell(30, 6, 'Prodi Informatika', 0, 2, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 4, 'Jalan Raya Pagojengan KM 3, Kecamatan Paguyangan, Kab. Brebes', 0, 2, 'C');
        $this->Cell(30, 4, 'Provinsi Jawa Tengah, 52274', 0, 0, 'C');
        $this->SetLineWidth(1);
        $this->Line(10, 35, 200, 35);
        $this->Ln(15);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Data Pertemuan', 0, 1, 'C');
$pdf->Ln(2);

$pdf->SetFont('Arial', '', 9);

$pdf->Cell(30, 6, 'Periode Akademik', 0, 0, 'L');
$pdf->Cell(5, 6, ':', 0, 0, 'C');
$pdf->Cell(70, 6, $periode, 0, 0, 'L');
$pdf->Cell(25, 6, 'Mata Kuliah', 0, 0, 'L');
$pdf->Cell(5, 6, ':', 0, 0, 'C');
$pdf->Cell(55, 6, $nama_matkul, 0, 1, 'L');

$pdf->Cell(30, 6, 'Nama Kelas', 0, 0, 'L');
$pdf->Cell(5, 6, ':', 0, 0, 'C');
$pdf->Cell(70, 6, $nama_kelas, 0, 0, 'L');
$pdf->Cell(25, 6, 'Dosen', 0, 0, 'L');
$pdf->Cell(5, 6, ':', 0, 0, 'C');
$pdf->Cell(55, 6, $nama_dosen, 0, 1, 'L');

$pdf->Cell(30, 6, 'Jurusan', 0, 0, 'L');
$pdf->Cell(5, 6, ':', 0, 0, 'C');
$pdf->Cell(70, 6, $nama_jurusan, 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetLineWidth(0.2);
$pdf->Ln(5);

$q_pertemuan = mysqli_query($db, "SELECT * FROM tbl_pertemuan WHERE id_kelas = '$id_kelas'");

if (mysqli_num_rows($q_pertemuan) > 0) {
    while ($d_pertemuan = mysqli_fetch_array($q_pertemuan)) {
        $id_pertemuan = $d_pertemuan['id'];
        $pertemuan_ke      = $d_pertemuan['pertemuan_ke'];
        $judul_pertemuan   = $d_pertemuan['judul_pertemuan'];
        $tanggal_pertemuan = date('d-m-Y', strtotime($d_pertemuan['tanggal']));

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 8, "Pertemuan Ke-$pertemuan_ke : $judul_pertemuan ($tanggal_pertemuan)", 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(15, 7, 'No', 1, 0, 'C');
        $pdf->Cell(35, 7, 'NIM', 1, 0, 'C');
        $pdf->Cell(95, 7, 'Nama Mahasiswa', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Status Kehadiran', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 9);
        $q_peserta = mysqli_query($db, "SELECT nim FROM tbl_peserta WHERE id_kelas = '$id_kelas'");
        $no = 1;
        
        if (mysqli_num_rows($q_peserta) > 0) {
            while ($d_peserta = mysqli_fetch_array($q_peserta)) {
                $nim = $d_peserta['nim'];
                
                $nama_mhs = '-';
                $q_mhs = mysqli_query($db, "SELECT nama FROM tbl_mahasiswa WHERE nim = '$nim'");
                if ($d_mhs = mysqli_fetch_array($q_mhs)) {
                    $nama_mhs = $d_mhs['nama'];
                }

                $status = ''; 
                $q_presensi = mysqli_query($db, "SELECT status_kehadiran FROM tbl_presensi WHERE nim = '$nim' AND id_pertemuan = '$id_pertemuan'");
                if ($d_presensi = mysqli_fetch_array($q_presensi)) {
                    $status = $d_presensi['status_kehadiran'];
                }

                $pdf->Cell(15, 6, $no++, 1, 0, 'C');
                $pdf->Cell(35, 6, $nim, 1, 0, 'C');
                $pdf->Cell(95, 6, $nama_mhs, 1, 0, 'L');
                $pdf->Cell(45, 6, $status, 1, 1, 'C');
            }
        } else {
            $pdf->Cell(190, 7, 'Belum ada peserta di kelas ini.', 1, 1, 'C');
        }

        $pdf->Ln(8); 
    }
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(190, 10, 'Data pertemuan untuk kelas ini belum ada.', 1, 1, 'C');
}

$pdf->Output('I', 'Laporan_Presensi_Per_Pertemuan.pdf');
?>