<?php
require_once '../database/koneksi.php';
$halaman = 'data_dosen';
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
      include '../sidebar_superadmin.php';
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
                <h3 class="card-title">Data Dosen</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-import">
                  <i class="fas fa-file-excel"></i> Import Data
                </button>
                <a class ="btn btn-success btn-sm" href="eksport_exel.php"><i class="fas fa-file-excel"></i> Eksport exel</a>
                <a class ="btn btn-danger btn-sm" href="eksport_pdf.php"><i class="fas fa-file-pdf"></i> Eksport Pdf</a>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Kelamin</th>
                    <th>Img</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $query_ambil_data = mysqli_query($db,"SELECT * FROM tbl_dosen") or die (mysqli_error($db));
                    $rv = mysqli_num_rows($query_ambil_data);
                    if ($rv > 0) {
                    $no = 1;
                    while ($data = mysqli_fetch_array($query_ambil_data)) {
                        $nik = $data ['nik'];
                        $nama = $data ['nama'];
                        $kontak = $data ['kontak'];
                        $email = $data ['email'];
                        $kelamin = $data ['kelamin'];
                        $img = $data ['img'];

                        ?>
                        <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $nik; ?></td>
                        <td><?= $nama; ?></td>
                        <td><?= $kontak; ?></td>
                        <td><?= $email; ?></td>
                        <td><?php 
                        if($kelamin == 'L') {
                            echo 'Laki-Laki';
                        }else {
                            echo 'Perempuan';
                        }
                        ?></td>
                        <td><?php 
                        if ($kelamin == 'L') {
                          ?>
                          <button type="button" data-toggle="modal" data-target="#modal-foto" class="btn btn-default"
                          data-nik="<?= $nik; ?>"
                          >

                          <img src="<?= ($img != NULL) ?$img:'../asset_adminlte/img/dsn-lk.webp' ?>" alt="foto mahasiswa laki-laki" style="width:100px"
                          >

                          </button>
                          <?php

                        }else {
                          ?>
                          <button type="button" data-toggle="modal" data-target="#modal-foto" class="btn btn-default"
                          data-nik="<?= $nik; ?>"
                          >
                          <img src="<?= ($img != NULL) ?$img:'../asset_adminlte/img/dsn-p.jpg' ?>" alt="foto mahasiswa perempuan" style="width:100px">
                          </button>
                          <?php

                        }
                        ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-edit" 
                          data-nik="<?= $nik; ?>"
                          data-nama="<?= $nama; ?>"
                          data-kontak="<?= $kontak; ?>"
                          data-email="<?= $email; ?>"
                          data-kelamin="<?= $kelamin; ?>"
                          >
                            <i class="fas fa-edit"></i>
                          </button>
                          <a name= "btn-hapus" class="btn btn-sm  btn-danger" href="proses_hapus.php?nik=<?= $nik ?>" onclick="return confirm('apakah kamu yakin akan menghapus data ini?')"><i class="fas fa-trash" ></i></a>
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
              <h4 class="modal-title">Tambah Data Dosen</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_tambah.php" method="post">
            <div class="modal-body">
                  <div class="form-group">
                    <label for="nik">Nik</label>
                    <input type="text" name="nik" class="form-control" id="nik" placeholder="Masukan Nik" required>
                  </div>
                  
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
                  </div>

                  <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" name="kontak" class="form-control" id="kontak" placeholder="Masukan Kontak" required>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Masukan Email" required>
                  </div>

                  <div class="form-group">
                    <label>Kelamin</label>
                    <select name="kelamin" class="form-control" required>
                      <option value="">-- Pilih Jenis Kelamin --</option>
                      <option value="L">Laki-Laki</option>
                      <option value="P">Perempuan</option>
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

<div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Dosen</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_edit.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                    <input type="hidden" name="id" hidden>
                    <label for="nik">Nik</label>
                    <input type="text" name="nik" class="form-control" id="nik" placeholder="Masukan Nik" readonly>
                  </div>
                  
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama" required>
                  </div>

                  <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" name="kontak" class="form-control" id="kontak" placeholder="Masukan Kontak" required>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Masukan Email" required>
                  </div>

                  <div class="form-group">
                    <label>Kelamin</label>
                    <select name="kelamin" class="form-control" required>
                      <option value="">-- Pilih Jenis Kelamin --</option>
                      <option value="L">Laki-Laki</option>
                      <option value="P">Perempuan</option>
                    </select>
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

<div class="modal fade" id="modal-import">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Import Data Dosen</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_import.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                  <label for="">Download Template</label>
                  <a href="template/template_dosen.xls" class="btn btn-info btn-sm">Download</a>
                  <div class="form-group">
                    <label for="dosen">Upload File Dosen</label>
                    <input type="file" name="file_dosen" class="form-control" id="file_dosen" required>
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


      <!-- /.modal -->
<div class="modal fade" id="modal-foto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Foto Dosen</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="proses_edit_foto.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                  <input type="hidden" name="nik" hidden>
                  <div class="form-group">
                    <label for="foto">Upload Foto</label>
                    <input type="file" name="foto" class="form-control" id="foto" placeholder="Masukan Foto" accept="image/*" required>
                  </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button name="btn-editfoto" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>


<!-- REQUIRED SCRIPTS -->

<?php
include '../script.php'; 
 ?>

 <script>
  $('#modal-edit').on('show.bs.modal' , function(e){
    var nik=$(e.relatedTarget).data('nik');
    var nama=$(e.relatedTarget).data('nama');
    var kontak=$(e.relatedTarget).data('kontak');
    var email=$(e.relatedTarget).data('email');
    var kelamin=$(e.relatedTarget).data('kelamin');

    
    
    $(e.currentTarget).find('input[name="nik"]').val(nik);
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('input[name="kontak"]').val(kontak);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('select[name="kelamin"]').val(kelamin);

  })

  $('#modal-foto').on('show.bs.modal', function(e){
    var nik=$(e.relatedTarget).data('nik');

    $(e.currentTarget).find('input[name="nik"]').val(nik);


  })
 </script>
</body>
</html>