<?php 
// Wajib ditambahkan agar tabel bisa tarik data
require_once '../database/koneksi.php';
$id_pertemuan = $_GET['id_pertemuan'];
$id_kelas = $_GET['id_kelas'];
?>

<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th width="5%">No</th>
    <th>Mahasiswa</th>
    <th>Status</th>
    <th width="10%" class="text-center">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php 
        $query_peserta = mysqli_query($db, "SELECT * FROM tbl_peserta WHERE id_kelas = '$id_kelas'") or die(mysqli_error($db));
        
        $no = 1;
        while ($peserta = mysqli_fetch_array($query_peserta)) {
            $nim_mhs = $peserta['nim'];

            $query_mhs = mysqli_query($db, "SELECT * FROM tbl_mahasiswa WHERE nim = '$nim_mhs'");
            $data_mhs = mysqli_fetch_array($query_mhs);
            $nama_mhs = $data_mhs['nama'];

            $query_presensi = mysqli_query($db, "SELECT * FROM tbl_presensi WHERE nim = '$nim_mhs' AND id_pertemuan = '$id_pertemuan'");
            $data_presensi = mysqli_fetch_array($query_presensi);
            $id_presensi = $data_presensi ? $data_presensi['id'] : '';
            
            $status_kehadiran = $data_presensi ? $data_presensi['status_kehadiran'] : '';
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td>
            <?= $nama_mhs; ?> - <?= $nim_mhs; ?>
        </td>
        <td>
            <?php
            $warna = 'danger';
            if ($status_kehadiran == 'hadir') {
                $warna = 'success'; 
            }elseif ($status_kehadiran == 'izin') {
                $warna = 'warning'; 
            }elseif ($status_kehadiran == 'sakit') {
                $warna = 'primary'; 
            }
            ?>
            <span class="badge badge-<?= $warna ?>"><?=$status_kehadiran;?></span>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-edit" 
            data-id="<?= $id_presensi; ?>"
            data-nim="<?= $nim_mhs; ?>"
            data-nama="<?= $nama_mhs; ?>"
            data-status="<?= $status_kehadiran; ?>"
            >
            <i class="fas fa-edit"></i>
            </button>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>