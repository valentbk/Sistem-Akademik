    <?php
    require_once '../database/koneksi.php';
    require('../asset_adminlte/fpdf/fpdf.php');

    $id_kelas = isset($_GET['id']) ? $_GET['id'] : '';


    $nama_kelas = '-'; $nama_dosen = '-'; $periode = '-'; $nama_jurusan = '-'; $nama_matkul = '-';

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
    $pdf->Cell(0, 10, 'Nilai Presensi Mahasiswa', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, 'Detail Data Kelas Mata Kuliah', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 9);

    $pdf->Cell(35, 6, 'NAMA KELAS', 0, 0, 'L');
    $pdf->Cell(5, 6, ':', 0, 0, 'C');
    $pdf->Cell(60, 6, $nama_kelas, 0, 0, 'L');
    $pdf->Cell(35, 6, 'DOSEN', 0, 0, 'L');
    $pdf->Cell(5, 6, ':', 0, 0, 'C');
    $pdf->Cell(50, 6, $nama_dosen, 0, 1, 'L');

    $pdf->Cell(35, 6, 'PERIODE AKADEMIK', 0, 0, 'L');
    $pdf->Cell(5, 6, ':', 0, 0, 'C');
    $pdf->Cell(60, 6, $periode, 0, 0, 'L');
    $pdf->Cell(35, 6, 'JURUSAN', 0, 0, 'L');
    $pdf->Cell(5, 6, ':', 0, 0, 'C');
    $pdf->Cell(50, 6, $nama_jurusan, 0, 1, 'L');

    $pdf->Cell(35, 6, 'MATA KULIAH', 0, 0, 'L');
    $pdf->Cell(5, 6, ':', 0, 0, 'C');
    $pdf->Cell(60, 6, $nama_matkul, 0, 0, 'L');
    $pdf->Cell(35, 6, 'PRESENTASE NILAI', 0, 0, 'L');
    $pdf->Cell(5, 6, ':', 0, 0, 'C');
    $pdf->Cell(50, 6, '20%', 0, 1, 'L');

    $pdf->Ln(5);


    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 8, 'No', 1, 0, 'C');
    $pdf->Cell(25, 8, 'NIM', 1, 0, 'C');
    $pdf->Cell(65, 8, 'Nama Mahasiswa', 1, 0, 'C');
    $pdf->Cell(12, 8, 'Hadir', 1, 0, 'C');
    $pdf->Cell(12, 8, 'Izin', 1, 0, 'C');
    $pdf->Cell(12, 8, 'Sakit', 1, 0, 'C');
    $pdf->Cell(12, 8, 'Alpa', 1, 0, 'C');
    $pdf->Cell(25, 8, 'Kehadiran (%)', 1, 0, 'C');
    $pdf->Cell(17, 8, 'Nilai', 1, 1, 'C');

    $pdf->SetFont('Arial', 'B', 8);


    $arr_pertemuan = array();
    $q_pertemuan = mysqli_query($db, "SELECT id FROM tbl_pertemuan WHERE id_kelas = '$id_kelas'");
    while ($row_p = mysqli_fetch_array($q_pertemuan)) {
        $arr_pertemuan[] = $row_p['id'];
    }
    $in_pertemuan = implode("','", $arr_pertemuan);

    $no = 1;
    $bobot_nilai = 20;

    $q_peserta = mysqli_query($db, "SELECT nim FROM tbl_peserta WHERE id_kelas = '$id_kelas'");

    if (mysqli_num_rows($q_peserta) > 0) {
        while ($d_peserta = mysqli_fetch_array($q_peserta)) {
            $nim = $d_peserta['nim'];
            
            $nama_mhs = '-';
            $q_mhs = mysqli_query($db, "SELECT nama FROM tbl_mahasiswa WHERE nim = '$nim'");
            if ($d_mhs = mysqli_fetch_array($q_mhs)) {
                $nama_mhs = $d_mhs['nama'];
            }

            $hadir = 0; $izin = 0; $sakit = 0; $alpa = 0;
            
            if (!empty($arr_pertemuan)) {
                $q_presensi = mysqli_query($db, "SELECT status_kehadiran FROM tbl_presensi WHERE nim = '$nim' AND id_pertemuan IN ('$in_pertemuan')");
                while ($d_presensi = mysqli_fetch_array($q_presensi)) {
                    $status = strtolower($d_presensi['status_kehadiran']);
                    if ($status == 'hadir') {
                        $hadir++;
                    } elseif ($status == 'izin') {
                        $izin++;
                    } elseif ($status == 'sakit') {
                        $sakit++;
                    } elseif ($status == 'alpa') {
                        $alpa++;
                    }
                }
            }
            
            $total_pertemuan_mhs = $hadir + $izin + $sakit + $alpa;
            if ($total_pertemuan_mhs > 0) {
                $persentase = ($hadir / $total_pertemuan_mhs) * 100;
            } else {
                $persentase = 0;
            }
            $nilai = ($persentase / 100) * $bobot_nilai;

            $pdf->Cell(10, 7, $no++, 1, 0, 'C');
            $pdf->Cell(25, 7, $nim, 1, 0, 'C');
            $pdf->Cell(65, 7, $nama_mhs, 1, 0, 'L');
            $pdf->Cell(12, 7, $hadir, 1, 0, 'C');
            $pdf->Cell(12, 7, $izin, 1, 0, 'C');
            $pdf->Cell(12, 7, $sakit, 1, 0, 'C');
            $pdf->Cell(12, 7, $alpa, 1, 0, 'C');
            $pdf->Cell(25, 7, number_format($persentase, 2) . '%', 1, 0, 'C'); 
            $pdf->Cell(17, 7, number_format($nilai, 0), 1, 1, 'C');
        }
    } else {
        $pdf->Cell(190, 8, 'Data peserta belum ada di kelas ini.', 1, 1, 'C');
    }

    $pdf->Output('I', 'Laporan_Presensi_Nilai.pdf');
    ?>