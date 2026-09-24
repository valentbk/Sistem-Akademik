<?php
require_once '../database/koneksi.php';
$halaman = 'data_kelas_matkul';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 3</title>

<?php
include '../library.php'; 
?>
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
      <!-- Navbar Search -->

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          Hallo, <?= $_SESSION['nama']; ?> <i class="far fa-user"></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-book mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar Sistem
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">Sistem Manajemen</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <?php
      include '../sidebar_dosen.php';
      ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Kelas Matkul</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah">Tambah Data</button>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Akademik</th>
                    <th>Jurusan</th>
                    <th>Matkul</th>
                    <th>Nik</th>
                    <th>Nama Kelas</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $nik_login = $_SESSION['nik'];

                    $query_kelas_matkul = mysqli_query($db,"SELECT * FROM tbl_kelas_matkul WHERE nik = '$nik_login'")  or die(mysqli_error($db));
                    $rv = mysqli_num_rows($query_kelas_matkul); // BISA PAKE LEFT JOIN
                    if ($rv > 0) {
                    $no = 1;
                    while ($data =mysqli_fetch_array($query_kelas_matkul)) {
                        $id_kelas = $data['id_kelas'];
                        $kode_akd = $data['kode_akd'];
                        $query_akademik = mysqli_query($db,"SELECT tahun, semester FROM tbl_akademik WHERE kode_akd = '$kode_akd'") or die(mysqli_error($db));
                        $data_akademik = mysqli_fetch_array($query_akademik);

                        $kode_jurusan = $data['kode_jurusan'];
                        $query_jurusan = mysqli_query($db,"SELECT nama_jurusan FROM tbl_jurusan WHERE kode_jurusan = '$kode_jurusan'") or die(mysqli_error($db));
                        $data_jurusan = mysqli_fetch_array($query_jurusan);

                        $kode_matkul = $data['kode_matkul'];
                        $query_matkul = mysqli_query($db,"SELECT nama_matkul FROM tbl_matkul WHERE kode_matkul = '$kode_matkul'") or die(mysqli_error($db));
                        $data_matkul = mysqli_fetch_array($query_matkul);

                        $nik = $data['nik'];
                        $query_dosen = mysqli_query($db,"SELECT nama, nik FROM tbl_dosen WHERE nik = '$nik'") or die(mysqli_error($db));
                        $data_dosen = mysqli_fetch_array($query_dosen);

                        $nama_kelas = $data['nama_kelas'];
                        ?>
                        <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data_akademik['tahun'];?>-<?= $data_akademik['semester'] == "GL" ? 'Ganjil' : 'genap';?></td>
                        <td><?= $data_jurusan['nama_jurusan'];?></td>
                        <td><?= $data_matkul['nama_matkul'];?></td>
                        <td><?= $data_dosen['nama'];?>-<?= $data_dosen['nik'];?></td>
                        <td><?= $nama_kelas; ?></td>
                    
                        <td>
                          <a class="btn btn-sm btn-primary" href="detail_kelas.php?id=<?= $id_kelas; ?>"><i class="fas fa-eye"></i></a>
                          <a href="pertemuan.php?id=<?= $id_kelas ?>" class="btn btn-warning btn-sm"><i class="fas fa-qrcode"></i></a>
                        </td>
                        </tr>
                        <?php

                    }

                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
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
            <form action="proses_tambah.php" method="post">
            <div class="modal-body">

                  <div class="form-group">
                        <label for="kode_akd">Kode Akademik</label>
                        <select name="kode_akd" id="kode_akd" class="form-control" required>
                        <option value="">-- Pilih Tahun Akademik --</option>
                        <?php 
                        $q_akd = mysqli_query($db, "SELECT * FROM tbl_akademik");
                        while ($akd = mysqli_fetch_array($q_akd)) {
                            $sem = ($akd['semester'] == 'GL') ? 'Ganjil' : 'Genap';
                            echo "<option value='".$akd['kode_akd']."'>".$akd['tahun']." - ".$sem."</option>";
                        }
                        ?>
                        </select>
                    </div>

                  <div class="form-group">
                        <label for="kode_jurusan">Jurusan</label>
                        <select name="kode_jurusan" id="kode_jurusan" class="form-control" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <?php 
                        $q_jur = mysqli_query($db, "SELECT * FROM tbl_jurusan");
                        while ($jur = mysqli_fetch_array($q_jur)) {
                            echo "<option value='".$jur['kode_jurusan']."'>".$jur['nama_jurusan']."</option>";
                        }
                        ?>
                        </select>
                    </div>

                  <div class="form-group">
                        <label for="kode_matkul">Mata Kuliah</label>
                        <select name="kode_matkul" id="kode_matkul" class="form-control" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <?php 
                        $q_matkul = mysqli_query($db, "SELECT * FROM tbl_matkul");
                        while ($mk = mysqli_fetch_array($q_matkul)) {
                            echo "<option value='".$mk['kode_matkul']."'>".$mk['nama_matkul']."</option>";
                        }
                        ?>
                        </select>
                    </div>

                  <div class="form-group">
                        <label for="nik">Dosen Pengampu</label>
                        <select name="nik" id="nik" class="form-control" required>
                        <option value="">-- Pilih Dosen --</option>
                        <?php 
                        $q_dosen = mysqli_query($db, "SELECT * FROM tbl_dosen");
                        while ($dosen = mysqli_fetch_array($q_dosen)) {
                            echo "<option value='".$dosen['nik']."'>".$dosen['nama']."</option>";
                        }
                        ?>
                        </select>
                    </div>

                  <div class="form-group">
                    <label for="nama_kelas">Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" placeholder="Masukan Nama Kelas" required>
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

<div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Akademik</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_edit.php" method="post">
            <div class="modal-body">
                  <input type="hidden" name="id" id="id">

                  <div class="form-group">
                        <label for="kode_akd">Tahun Akademik</label>
                        <select name="kode_akd" id="kode_akd" class="form-control" required>
                        <option value="">-- Pilih Tahun Akademik --</option>
                        <?php 
                        $q_akd = mysqli_query($db, "SELECT * FROM tbl_akademik");
                        while ($akd = mysqli_fetch_array($q_akd)) {
                            $sem = ($akd['semester'] == 'GL') ? 'Ganjil' : 'Genap';
                            echo "<option value='".$akd['kode_akd']."'>".$akd['tahun']." - ".$sem."</option>";
                        }
                        ?>
                        </select>
                    </div>

                  <div class="form-group">
                        <label for="kode_jurusan">Jurusan</label>
                        <select name="kode_jurusan" id="kode_jurusan" class="form-control" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <?php 
                        $q_jur = mysqli_query($db, "SELECT * FROM tbl_jurusan");
                        while ($jur = mysqli_fetch_array($q_jur)) {
                            echo "<option value='".$jur['kode_jurusan']."'>".$jur['nama_jurusan']."</option>";
                        }
                        ?>
                        </select>
                    </div>

                  <div class="form-group">
                        <label for="kode_matkul">Mata Kuliah</label>
                        <select name="kode_matkul" id="kode_matkul" class="form-control" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <?php 
                        $q_matkul = mysqli_query($db, "SELECT * FROM tbl_matkul");
                        while ($mk = mysqli_fetch_array($q_matkul)) {
                            echo "<option value='".$mk['kode_matkul']."'>".$mk['nama_matkul']."</option>";
                        }
                        ?>
                        </select>
                    </div>

                  <div class="form-group">
                        <label for="nik">Dosen Pengampu</label>
                        <select name="nik" id="nik" class="form-control" required>
                        <option value="">-- Pilih Dosen --</option>
                        <?php 
                        $q_dosen = mysqli_query($db, "SELECT * FROM tbl_dosen");
                        while ($dosen = mysqli_fetch_array($q_dosen)) {
                            echo "<option value='".$dosen['nik']."'>".$dosen['nama']."</option>";
                        }
                        ?>
                        </select>
                    </div>

                  <div class="form-group">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" placeholder="Masukan Nama Kelas" required>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-edit" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- /.modal -->

<!-- REQUIRED SCRIPTS -->

<?php
include '../script.php'; 
 ?>

 <script>
  $('#modal-edit').on('show.bs.modal' , function(e){
    var id = $(e.relatedTarget).data('id_kelas'); 
    var kode_akd = $(e.relatedTarget).data('kode_akd');
    var kode_jurusan = $(e.relatedTarget).data('kode_jurusan');
    var kode_matkul = $(e.relatedTarget).data('kode_matkul');
    var nik = $(e.relatedTarget).data('nik');
    var nama_kelas = $(e.relatedTarget).data('nama_kelas');

    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('select[name="kode_akd"]').val(kode_akd);
    $(e.currentTarget).find('select[name="kode_jurusan"]').val(kode_jurusan);
    $(e.currentTarget).find('select[name="kode_matkul"]').val(kode_matkul);
    $(e.currentTarget).find('select[name="nik"]').val(nik);
    $(e.currentTarget).find('input[name="nama_kelas"]').val(nama_kelas);
  })
</script>
</body>
</html>