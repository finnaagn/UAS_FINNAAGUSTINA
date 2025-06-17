<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="<?= base_url('admin/dashboard') ?>" class="app-brand-link">
      <span class="app-brand-text demo menu-text fw-bolder ms-2">RS Finna</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>">
      <a href="<?= base_url('admin/dashboard') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <!-- Menu Administrasi -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Administrasi</span></li>
    
    <li class="menu-item <?= strpos(current_url(), base_url('admin/pengguna')) !== false ? 'active' : '' ?>">
      <a href="<?= base_url('admin/pengguna') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Manajemen Pengguna</div>
      </a>
    </li>
    
    <li class="menu-item <?= strpos(current_url(), base_url('admin/pasien')) !== false ? 'active' : '' ?>">
      <a href="<?= base_url('admin/pasien') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-face"></i>
        <div>Manajemen Pasien</div>
      </a>
    </li>

    <li class="menu-item <?= strpos(current_url(), base_url('admin/dokter')) !== false ? 'active' : '' ?>">
      <a href="<?= base_url('admin/dokter') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-plus-medical"></i>
        <div>Manajemen Dokter</div>
      </a>
    </li>

    <!-- Menu Pendaftaran -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Pendaftaran</span></li>
    
    <li class="menu-item <?= strpos(current_url(), base_url('admin/pendaftaran')) !== false ? 'active' : '' ?>">
      <a href="<?= base_url('admin/pendaftaran') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-edit-alt"></i>
        <div>Pendaftaran Pasien</div>
      </a>
    </li>

    <!-- Menu Laporan -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Laporan</span></li>
    
    <li class="menu-item <?= strpos(current_url(), base_url('admin/laporan')) !== false ? 'active' : '' ?>">
      <a href="<?= base_url('admin/laporan') ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div>Laporan Pendaftaran</div>
      </a>
    </li>
  </ul>
</aside>