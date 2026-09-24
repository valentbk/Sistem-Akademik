<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../home_superadmin" class="nav-link <?php if ($halaman == 'home') {echo 'active';}?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_pengguna_superadmin" class="nav-link <?php if ($halaman == 'data_pengguna') {echo 'active';}?>">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Data pengguna
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_akademik_superadmin" class="nav-link <?php if ($halaman == 'data_akademik') {echo 'active';}?>">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                Data Akademik
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_mahasiswa" class="nav-link <?php if ($halaman == 'data_mahasiswa') {echo 'active';}?>">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                Data mahasiswa
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_dosen_superadmin" class="nav-link <?php if ($halaman == 'data_dosen') {echo 'active';}?>">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Data Dosen
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_matkul_superadmin" class="nav-link <?php if ($halaman == 'data_matkul') {echo 'active';}?>">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Data Mata Kuliah
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_jurusan_superadmin" class="nav-link <?php if ($halaman == 'data_jurusan') {echo 'active';}?>">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Data Jurusan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_kelas_matkul_superadmin" class="nav-link <?php if ($halaman == 'data_kelas_matkul') {echo 'active';}?>">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                Data Kelas Matkul
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../ganti_password_superadmin" class="nav-link <?php if ($halaman == 'ganti_pw') {echo 'active';}?>">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                Ganti Password
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Keluar
              </p>
            </a>
          </li>
          
        </ul>
      </nav>