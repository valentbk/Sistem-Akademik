<?php
require_once '../database/koneksi.php';
$halaman = 'data_kelas_matkul';

$id_kelas = isset($_GET['id']) ? $_GET['id'] : '';
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
    $q_dosen = mysqli_query($db,"SELECT nama, nik FROM tbl_dosen WHERE nik = '$nik'");
    $d_dosen = mysqli_fetch_array($q_dosen);
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
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
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
    <!-- Main content -->
    <div class="content mt-4">
      <div class="container-fluid">
        
        <div class="card">
              <div class="card-header bg-light">
                <h3 class="card-title">Detail Kelas Mata Kuliah</h3>
              </div>
              <div class="card-body">
                
                <?php if($data_kelas) { ?>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm m-0">
                            <tr>
                                <td width="35%">Periode Akademik</td>
                                <td width="5%">:</td>
                                <td><?= $periode; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Kelas</td>
                                <td>:</td>
                                <td><?= $data_kelas['nama_kelas']; ?></td>
                            </tr>
                            <tr>
                                <td>Jurusan</td>
                                <td>:</td>
                                <td><?= $d_jur['nama_jurusan']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm m-0">
                            <tr>
                                <td width="30%">Mata Kuliah</td>
                                <td width="5%">:</td>
                                <td><?= $d_mk['nama_matkul']; ?> - <?= $kode_matkul; ?></td>
                            </tr>
                            <tr>
                                <td>Dosen</td>
                                <td>:</td>
                                <td><?= $d_dosen['nama']; ?> - <?= $d_dosen['nik']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mb-4">
                  <button type="button" onclick="history.back()" class="btn btn-sm btn-danger"><i class="fas fa-arrow-left mr-1"></i> Kembali</button>
                  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus mr-1"></i> Tambah Data</button>
                  <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-import">
                  <i class="fas fa-file-excel"></i> Import Excel</button>
                </div>
                
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Mahasiswa</th>
                    <th width="10%" class="text-center">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $q_mhs = mysqli_query($db, "SELECT tbl_peserta.id as id_peserta, tbl_peserta.nim, tbl_mahasiswa.nama 
                                                      FROM tbl_peserta 
                                                      JOIN tbl_mahasiswa ON tbl_peserta.nim = tbl_mahasiswa.nim 
                                                      WHERE tbl_peserta.id_kelas = '$id_kelas'") 
                                      or die(mysqli_error($db));
                      
                      $no = 1;
                      while ($mhs = mysqli_fetch_array($q_mhs)) {
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <?= $mhs['nama']; ?>-<?= $mhs['nim']; ?>
                        </td>
                        <td class="text-center">
                            <a href="proses_hapus_peserta.php?id=<?= $mhs['id_peserta']; ?>&id_kelas=<?= $id_kelas?> " class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus mahasiswa ini dari kelas?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                
                <?php } else { ?>
                    <div class="alert alert-danger">Data Kelas tidak ditemukan! Pastikan URL memiliki ID yang benar.</div>
                <?php } ?>

              </div>
              <!-- /.card-body -->
        </div><!-- /.card -->

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">Sistem Management</a>.</strong>
    All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Kelas Matkul</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_tambah_peserta.php" method="post">
            <div class="modal-body">



                  <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
                  <div class="form-group">
                        <label for="mahasiswa">Mahasiswa</label>
                        <select name="nim" id="mahasiswa" class="form-control" required>
                        <option value="">-- Pilih Mahasiswa --</option>
                        <?php 
                        $query_panggil_mhs =mysqli_query($db,"SELECT nim,nama FROM tbl_mahasiswa ") or die(mysqli_error($db));
                        $rv = mysqli_num_rows($query_panggil_mhs);
                        if ($rv > 0) {
                          while ($data = mysqli_fetch_array($query_panggil_mhs)) {
                            ?>
                            <option value="<?= $data['nim']; ?>"><?= $data['nim']; ?>-<?= $data['nama']; ?></option>
                            <?php

                          }

                        }
                        ?>
                        </select>
                    </div>



                  
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-tambah" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-import">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Import Data Peserta</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_import.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                  <div class="row">
                    <div class="col-6">
                      <center>
                          <label for="">Download Template :</label>
                          <a href="template/template_peserta.xls" class="btn btn-info btn-sm">Download</a>
                      </center>
                      
                    </div>
                    <div class="col-6">
                      <center>
                        <label for="">Download Data Mahasiswa :</label>
                        <a href="../data_mahasiswa/eksport_exel.php" class="btn btn-info btn-sm">Download</a>
                      </center>
                      
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <input type="hidden" value="<?= $id_kelas ?>" name="id_kelas">
                    <label for="mahasiswa">Upload File Peserta</label>
                    <input type="file" name="file_mahasiswa" class="form-control" id="file_mahasiswa" required>
                  </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-import" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>

<!-- REQUIRED SCRIPTS -->
<?php include '../script.php'; ?>
</body>
</html>