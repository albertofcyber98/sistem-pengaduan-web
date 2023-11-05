<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
<?php
$userRole = $_SESSION['role'];
?>
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-text mx-3"><?= $userRole=='pegawai'?'pegawai':'pelapor'?></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $page == 1 ? 'active' : '' ?>">
      <a class="nav-link" href="dashboard.php">
        <i class="fas fa-fw fa-home"></i>
        <span>Dashboard</span></a>
    </li>

    <?php
    if($userRole == 'pegawai'){
    ?>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Tables -->
    <li class="nav-item <?= $page == 2 ? 'active' : '' ?>">
      <a class="nav-link" href="data_akun_pegawai.php">
        <i class="fas fa-fw fa-table"></i>
        <span>Data Akun Pegawai</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Tables -->
    <li class="nav-item <?= $page == 3 ? 'active' : '' ?>">
      <a class="nav-link" href="data_akun_pelapor.php">
        <i class="fas fa-fw fa-table"></i>
        <span>Data Akun Pelapor</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Tables -->
    <li class="nav-item <?= $page == 5 ? 'active' : '' ?>">
      <a class="nav-link" href="data_skpd.php">
        <i class="fas fa-fw fa-table"></i>
        <span>Data SKPD</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Tables -->
    <li class="nav-item <?= $page == 6 ? 'active' : '' ?>">
      <a class="nav-link" href="data_jenis_laporan.php">
        <i class="fas fa-fw fa-table"></i>
        <span>Data Jenis Laporan</span></a>
    </li>
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Tables -->
    <li class="nav-item <?= $page == 7 ? 'active' : '' ?>">
      <a class="nav-link" href="data_form_laporan.php">
        <i class="fas fa-fw fa-table"></i>
        <span>Form Laporan</span></a>
    </li>
    <?php
    }elseif($userRole =='pelapor'){
    ?>
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Tables -->
    <li class="nav-item <?= $page == 4 ? 'active' : '' ?>">
      <a class="nav-link" href="data_form_pelapor.php">
        <i class="fas fa-fw fa-table"></i>
        <span>Form Pelaporan</span></a>
    </li>

    <?php
    }
    ?>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>