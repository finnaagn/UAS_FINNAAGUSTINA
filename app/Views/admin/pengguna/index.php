<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Manajemen Pengguna<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Daftar Pengguna</h5>
      </div>
      <div class="card-body">
        <?php if (session()->getFlashdata('message')) : ?>
          <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
          <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
          </div>
        <?php endif; ?>

        <div class="mb-3">
          <a href="<?= base_url('admin/pengguna/create') ?>" class="btn btn-primary">
            <i class="bx bx-plus"></i> Tambah Pengguna
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Status</th>
                <th>Terakhir Login</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($admins as $index => $admin) : ?>
                <tr>
                  <td><?= $index + 1 ?></td>
                  <td><?= esc($admin['username']) ?></td>
                  <td><?= esc($admin['nama_lengkap']) ?></td>
                  <td>
                    <span class="badge bg-<?= $admin['status_aktif'] === 'aktif' ? 'success' : 'danger' ?>">
                      <?= ucfirst($admin['status_aktif']) ?>
                    </span>
                  </td>
                  <td><?= $admin['terakhir_login'] ? date('d/m/Y H:i', strtotime($admin['terakhir_login'])) : 'Belum pernah login' ?></td>
                  <td>
                    <a href="<?= base_url("admin/pengguna/edit/{$admin['id_admin']}") ?>" class="btn btn-sm btn-warning">
                      <i class="bx bx-edit"></i>
                    </a>
                    <form action="<?= base_url("admin/pengguna/delete/{$admin['id_admin']}") ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                      <?= csrf_field() ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bx bx-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>