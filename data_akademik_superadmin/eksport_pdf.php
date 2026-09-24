<?php
require_once '../database/koneksi.php';
require('../asset_adminlte/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../asset_adminlte/img/logo Universitas Peradaban.png', 10, 12, 40);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 8, 'Fakultas Sains Dan Teknologi', 0, 2, 'C'); 
        $this->Cell(30, 6, 'Prodi Informatika', 0, 2, 'C');

        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 4, 'Jalan Raya Pagojengan KM 3, Kecamatan Paguyangan, Kab. Brebes', 0, 2, 'C');
        $this->Cell(30, 4, 'Provinsi Jawa Tengah, 52274', 0, 0, 'C');
        $this->SetLineWidth(1);
        $this->Line(10, 35, 200, 35);
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// --- MULAI PERUBAHAN DATA DI BAWAH GARIS ---

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(80);
// Ubah judul
$pdf->Cell(30, 4, 'Data Akademik', 0, 1, 'C');
$pdf->Ln(5);

// Set font tabel
$pdf->SetFont('Times', 'B', 10); 

// Total lebar A4 = 190 (setelah dikurangi margin)
// Pembagian lebar Cell yang baru dirapikan: 10 + 35 + 45 + 45 + 55 = 190
$pdf->Cell(10, 6, 'No', 1, 0, 'C');
$pdf->Cell(35, 6, 'Kode Akademik', 1, 0, 'C');
$pdf->Cell(45, 6, 'Semester', 1, 0, 'C');
$pdf->Cell(45, 6, 'Tahun', 1, 0, 'C');
$pdf->Cell(55, 6, 'Status', 1, 1, 'C'); // 1, 1 berarti ganti baris setelah ini

$pdf->SetFont('Times', '', 10);

// Ambil data akademik (variabel disesuaikan namanya)
$query_panggil_akademik = mysqli_query($db, "SELECT * FROM tbl_akademik")or die(mysqli_error($db));
$rv = mysqli_num_rows($query_panggil_akademik);
$no = 1;

if ($rv > 0) {
    while ($data = mysqli_fetch_array($query_panggil_akademik)) {
        $pdf->Cell(10, 6, $no++, 1, 0, 'C');
        $pdf->Cell(35, 6, $data['kode_akd'], 1, 0, 'C');
        $pdf->Cell(45, 6, ($data['semester'] == 'GL' ? 'Ganjil' : 'Genap'), 1, 0, 'C');
        $pdf->Cell(45, 6, $data['tahun'], 1, 0, 'C');
        $pdf->Cell(55, 6, ($data['is_active'] == '1' ? 'Aktif' : 'Tidak Aktif'), 1, 1, 'C');
    }
}
$pdf->Output();
?>