<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Tambah Pengguna Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Form Tambah Pengguna</h5>
      </div>
      <div class="card-body">
        <?php if (isset($errors)) : ?>
          <div class="alert alert-danger">
            <ul>
              <?php foreach ($errors as $error) : ?>
                <li><?= esc($error) ?></li>
              <?php endforeach ?>
            </ul>
          </div>
        <?php endif ?>

        <form action="<?= base_url('admin/pengguna/store') ?>" method="POST">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <div class="mb-3">
            <label for="password_confirm" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
          </div>

          <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
          </div>

          <div class="mb-3">
            <label for="status_aktif" class="form-label">Status</label>
            <select class="form-select" id="status_aktif" name="status_aktif" required>
              <option value="aktif">Aktif</option>
              <option value="nonaktif">Nonaktif</option>
            </select>
          </div>

          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('admin/pengguna') ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>