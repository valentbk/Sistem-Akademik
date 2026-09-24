<?php
require_once '../database/koneksi.php';
$halaman = 'data_kelas_matkul';

$id_pertemuan = isset($_GET['id']) ? $_GET['id'] : '';

$query_pertemuan = mysqli_query($db, "SELECT * FROM tbl_pertemuan WHERE id = '$id_pertemuan'") or die(mysqli_error($db));
$data_pertemuan = mysqli_fetch_array($query_pertemuan);
$tanggal = $data_pertemuan['tanggal'];
$tanggal_baru = date_create($tanggal);

$data_kelas = null;

if($data_pertemuan) {
    $id_kelas = $data_pertemuan['id_kelas'];
    
    $query_kelas = mysqli_query($db, "SELECT * FROM tbl_kelas_matkul WHERE id_kelas = '$id_kelas'") or die(mysqli_error($db));
    $data_kelas = mysqli_fetch_array($query_kelas);

    if($data_kelas) {
        $kode_akd = $data_kelas['kode_akd'];
        $q_akd = mysqli_query($db,"SELECT tahun, semester FROM tbl_akademik WHERE kode_akd = '$kode_akd'");
        $d_akd = mysqli_fetch_array($q_akd);
        $periode = $d_akd['tahun'] . "-" . ($d_akd['semester'] == "GL" ? "Ganjil" : "Genap");

        $kode_jurusan = $data_kelas['kode_jurusan'];
        $q_jur = mysqli_query($db,"SELECT nama_jurusan FROM tbl_jurusan WHERE kode_jurusan = '$kode_jurusan'");
        $d_jur = mysqli_fetch_array($q_jur);

        $kode_matkul = $data_kelas['kode_matkul'];
        $q_mk = mysqli_query($db,"SELECT nama_matkul FROM tbl_matkul WHERE kode_matkul = '$kode_matkul'");
        $d_mk = mysqli_fetch_array($q_mk);

        $nik = $data_kelas['nik'];
        $q_dosen = mysqli_query($db,"SELECT nama, nik, kelamin,img FROM tbl_dosen WHERE nik = '$nik'");
        $d_dosen = mysqli_fetch_array($q_dosen);

        $img = $d_dosen ['img'];
        $kelamin = $d_dosen ['kelamin'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Detail Kelas Mata Kuliah</title>

<?php include '../library.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Hallo, <?= isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Admin'; ?> <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"><i class="fas fa-book mr-2"></i> Profil</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i> Keluar Sistem</a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
      <span class="brand-text font-weight-light">Sistem Manajemen</span>
    </a>
    <div class="sidebar">
      <?php include '../sidebar_superadmin.php'; ?>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content mt-4">
      <div class="container-fluid">
        
        <div class="card">
              <div class="card-header bg-light">
                <h3 class="card-title">Presensi Pertemuan Ke-<?= isset($data_pertemuan['pertemuan_ke']) ? $data_pertemuan['pertemuan_ke'] : ''; ?></h3>
              </div>
              <div class="card-body">
                
                <?php if($data_kelas) { ?>
                <div class="row mb-4">
                    <!-- KOLOM 1: Foto Dosen & Tombol Status -->
                    <div class="col-4 text-center">
                     <?php 
                        if ($kelamin == 'L') {
                          ?>
                          <img src="<?= ($img != NULL) ?$img:'../asset_adminlte/img/dsn-lk.webp' ?>" alt="foto dosen laki-laki" style="width:200px">
                          <?php
                        } else {
                          ?>
                          <img src="<?= ($img != NULL) ?$img:'../asset_adminlte/img/dsn-p.jpg' ?>" alt="foto dosen perempuan" style="width:100px">
                          <?php
                        }

                        $status_pertemuan = isset($data_pertemuan['status_pertemuan']) ? $data_pertemuan['status_pertemuan'] : 1;
                        ?>

                        <div class="mt-3">
                            <?php if ($status_pertemuan == 1) { ?>
                                <a href="proses_status_pertemuan.php?id=<?= $id_pertemuan; ?>&status=0" class="btn btn-danger btn-sm">Tutup Presensi</a>
                            <?php } else { ?>
                                <a href="proses_status_pertemuan.php?id=<?= $id_pertemuan; ?>&status=1" class="btn btn-success btn-sm">Buka Presensi</a>
                            <?php } ?>
                        </div> 
                    </div>
                    
                    <div class="col-4">
                        <table>
                            <tr>
                                <td width="35%">Periode</td>
                                <td width="5%">:</td>
                                <td><?= $periode; ?></td>
                            </tr>
                            <tr>
                                <td>Dosen</td>
                                <td>:</td>
                                <td><?= $d_dosen['nama']; ?> - <?= $d_dosen['nik']; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Kelas</td>
                                <td>:</td>
                                <td><?= $data_kelas['nama_kelas']; ?></td>
                            </tr>
                            <tr>
                                <td>Jurusan</td>
                                <td>:</td>
                                <td><?= $d_jur['nama_jurusan']?></td>
                            </tr>
                            <tr>
                                <td>Mata Kuliah</td>
                                <td>:</td>
                                <td><?= $d_mk['nama_matkul']?></td>
                            </tr>
                            <tr>
                                <td>Judul</td>
                                <td>:</td>
                                <td><?= $data_pertemuan['judul_pertemuan']?></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td><?= date_format($tanggal_baru, "l, d F Y") ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- KOLOM 3: QR Code -->
                    <div class="col-4 text-center">
                        <?php
                            include('../asset_adminlte/phpqrcode/qrlib.php');
                        
                            $isi_qr = $id_pertemuan; 
                            $fileName = 'file-qr-'.$isi_qr.'.png';
                            $alamat_tujuan = 'qr/'.$fileName;
                            
                            QRcode::png($isi_qr, $alamat_tujuan);
                        ?>
                          <img src="<?= $alamat_tujuan; ?>" alt="foto qr" style="width:200px">
                          <?php 
                          if ($status_pertemuan == 1) {
                            ?>
                            <p id="waktu"></p>
                            <?php

                          }
                          
                          ?>
                          

                          <div></div>
                    </div>
                </div>

                <div class="mb-4">
                  <a href="pertemuan.php?id=<?= $id_kelas ?>" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus mr-1"></i> Tambah Data</button>
                  
                </div>
                <div id="tabel_presensi"></div>
            
                <?php } else { ?>
                    <div class="alert alert-danger">Data Kelas tidak ditemukan! Pastikan URL memiliki ID yang benar.</div>
                <?php } ?>

              </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">Sistem Management</a>.</strong>
    All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- MODAL TAMBAH PRESENSI -->
<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Presensi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_tambah_presensi.php" method="post">
            <div class="modal-body">
                  <input type="hidden" name="id_pertemuan" value="<?= isset($id_pertemuan) ? $id_pertemuan : '' ?>">

                  <div class="form-group">
                        <label for="mahasiswa">Mahasiswa</label>
                        <select name="nim" id="mahasiswa" class="form-control" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        <?php 
                        $query_panggil_peserta = mysqli_query($db, "SELECT * FROM tbl_peserta WHERE id_kelas = '$id_kelas'") or die(mysqli_error($db));
                        $rv = mysqli_num_rows($query_panggil_peserta);

                        if ($rv > 0) {
                            while ($peserta = mysqli_fetch_array($query_panggil_peserta)) {
                                $nim_mhs = $peserta['nim'];

                                $query_panggil_mhs = mysqli_query($db, "SELECT * FROM tbl_mahasiswa WHERE nim = '$nim_mhs'");
                                $data_mhs = mysqli_fetch_array($query_panggil_mhs);
                                $nama_mhs = $data_mhs ? $data_mhs['nama'] : '';
                                ?>
                                <option value="<?= $nim_mhs; ?>"><?= $nim_mhs; ?> - <?= $nama_mhs; ?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status_kehadiran">Status Kehadiran</label>
                        <select name="status_kehadiran" id="status_kehadiran" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpa">Alpa</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-tambah" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
        </div>
</div>

<!-- MODAL EDIT PRESENSI -->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Status Kehadiran</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="proses_edit_presensi.php" method="post">
        <div class="modal-body">

              <input type="hidden" name="id_presensi" id="edit-id-presensi">
              <input type="hidden" name="nim" id="edit-nim">
              <input type="hidden" name="id_pertemuan" value="<?= $id_pertemuan; ?>">

              <div class="form-group">
                <label for="nama_mhs">Mahasiswa</label>
                <input type="text" name="nama" id="edit-nama" class="form-control" readonly>
              </div>
              
              <div class="form-group">
                <label for="status_kehadiran">Status Kehadiran</label>
                <select name="status_kehadiran" id="edit-status" class="form-control" required>
                  <option value="">-- Pilih Status --</option>
                  <option value="hadir">Hadir</option>
                  <option value="izin">Izin</option>
                  <option value="sakit">Sakit</option>
                  <option value="alpa">Alpa</option>
                </select>
              </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button name="btn-edit" type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
        </form>
      </div>
    </div>
</div>

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>

 <script>
  $('#modal-edit').on('show.bs.modal', function (e) {
    var id_presensi = $(e.relatedTarget).data('id');
    var nim = $(e.relatedTarget).data('nim');
    var nama = $(e.relatedTarget).data('nama');
    var status = $(e.relatedTarget).data('status');
    
    // Masukkan data ke dalam form modal
    $(e.currentTarget).find('input[name="id_presensi"]').val(id_presensi);
    $(e.currentTarget).find('input[name="nim"]').val(nim);
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('select[name="status_kehadiran"]').val(status);
  });
</script>

<script>
// Set the date we're counting down to
var countDownDate = new Date().getTime()+60*5*1000;

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("waktu").innerHTML = minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    // document.getElementById("waktu").innerHTML = "Presensi Di tutup";
    window.location.href= "proses_status_pertemuan.php?id=<?= $id_pertemuan; ?>&status=0"
    // document.getElementById("myForm").submit();
  }
}, 1000);
</script>

<script>
  function refresh_kehadiran() {
    $('#tabel_presensi').load('tabel_presensi.php?id_kelas=<?= $id_kelas; ?>&id_pertemuan=<?= $id_pertemuan ?>');
    setTimeout(refresh_kehadiran, 5000); 
  }

  $(document).ready(function(){
      refresh_kehadiran();
  });
</script>
</body>
</html>