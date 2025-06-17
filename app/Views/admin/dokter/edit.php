<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Edit Data Dokter<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Form Edit Dokter</h5>
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

        <?php if (session()->getFlashdata('errors')) : ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
              <p><?= $error ?></p>
            <?php endforeach ?>
          </div>
        <?php endif ?>

        <form action="<?= base_url('admin/dokter/update/' . $dokter['id_dokter']) ?>" method="POST">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label for="nama_dokter" class="form-label">Nama Dokter <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" 
                   value="<?= esc($dokter['nama_dokter']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="spesialisasi" class="form-label">Spesialisasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" 
                   value="<?= esc($dokter['spesialisasi']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="jadwal_praktek" class="form-label">Jadwal Praktek</label>
            <textarea class="form-control" id="jadwal_praktek" name="jadwal_praktek" rows="3"><?= esc($dokter['jadwal_praktek']) ?></textarea>
          </div>

          <div class="mb-3">
            <label for="status_aktif" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select" id="status_aktif" name="status_aktif" required>
              <option value="aktif" <?= $dokter['status_aktif'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
              <option value="cuti" <?= $dokter['status_aktif'] === 'cuti' ? 'selected' : '' ?>>Cuti</option>
              <option value="nonaktif" <?= $dokter['status_aktif'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('admin/dokter') ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>