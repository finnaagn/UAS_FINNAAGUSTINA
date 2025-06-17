<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Tambah Pasien Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Form Tambah Pasien</h5>
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

        <form action="<?= base_url('admin/pasien/store') ?>" method="POST">
                  <?= csrf_field() ?>
                  <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <p><?= $error ?></p>
                <?php endforeach ?>
            </div>
        <?php endif ?>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="nik" name="nik" required maxlength="16">
            </div>
            <div class="col-md-6">
              <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="col-md-4">
              <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
              <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="">Pilih...</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="no_telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('admin/pasien') ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>