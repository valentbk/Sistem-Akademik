<?php
require_once "../database/koneksi.php";
// panggl library
require '../vendor/autoload.php'; 

//panggil funsi spreadsheeet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// buka bufering
ob_start();

//nama file
$nama_file = "Data-mahasiswa-" . date('Y-m-d');
// ambil data mahasiswa dari database
$quey_panggil_mahasiswa = mysqli_query($db,"SELECT * FROM tbl_mahasiswa") or die(mysqli_error($db));

// buat spreadseet
$spreadsheet = new Spreadsheet();
// pilih sheet yang aktif
$sheet = $spreadsheet->getActiveSheet();
// ubah judul sheet
$sheet->setTitle('Data mahasiswa');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'NIM');
$sheet->setCellValue('C1', 'NAMA');
$sheet->setCellValue('D1', 'KONTAK');
$sheet->setCellValue('E1', 'EMAIL');
$sheet->setCellValue('F1', 'KELAMIN');

// konfigurasi styling 
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
// konfigurasi dan konfirmasi syling style
$sheet->getStyle('A1:F1')->applyFromArray($styleArray);
// styling font menjadi bold pada cell yang dituju
$sheet->getStyle('A1:F1')->getFont()->setBold(true);

// styling agar lbar cell manjadi auto (sesuai panjang text data)
foreach (array('A', 'B', 'C', 'D', 'E', 'F') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// nomor dari baris 1 
$no = 1;
$baris = 2; //bikin baris
//tampung data dari database
while ($row = mysqli_fetch_assoc($quey_panggil_mahasiswa)) {
    $nim = $row['nim'];
    $nama = $row['nama'];
    $kontak = $row['kontak'];
    $email = $row['email'];
    $kelamin = $row['kelamin'];

    // isi nilai cell cell dengan data
    $sheet->setCellValue("A" . $baris, $no);
    $sheet->setCellValue("B" . $baris, $nim);
    $sheet->setCellValue("C" . $baris, $nama);
    $sheet->setCellValue("D" . $baris, $kontak);
    $sheet->setCellValue("E" . $baris, $email);
    $sheet->setCellValue("F" . $baris, $kelamin);
    $baris++;
    $no++;
}

// Buat file excel
$filename = $nama_file . ".xlsx";
$writer = new Xlsx($spreadsheet);

ob_end_clean(); // Bersihkan output buffer

// Atur header untuk pengunduhan file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();
?>