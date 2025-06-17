<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Edit Pendaftaran<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Edit Pendaftaran Pasien</h5>
      </div>
      <div class="card-body">
        <?php if (session()->getFlashdata('errors')) : ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
              <p><?= $error ?></p>
            <?php endforeach ?>
          </div>
        <?php endif ?>

        <form action="<?= base_url('admin/pendaftaran/update/' . $pendaftaran['id_pendaftaran']) ?>" method="POST">
          <?= csrf_field() ?>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="id_pasien" class="form-label">Pasien <span class="text-danger">*</span></label>
              <select class="form-select" id="id_pasien" name="id_pasien" required>
                <option value="">Pilih Pasien...</option>
                <?php foreach ($pasien as $p) : ?>
                  <option value="<?= $p['id_pasien'] ?>" <?= $p['id_pasien'] == $pendaftaran['id_pasien'] ? 'selected' : '' ?>>
                    <?= esc($p['nama_lengkap']) ?> (NIK: <?= esc($p['nik']) ?>)
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="id_dokter" class="form-label">Dokter <span class="text-danger">*</span></label>
              <select class="form-select" id="id_dokter" name="id_dokter" required>
                <option value="">Pilih Dokter...</option>
                <?php foreach ($dokter as $d) : ?>
                  <option value="<?= $d['id_dokter'] ?>" <?= $d['id_dokter'] == $pendaftaran['id_dokter'] ? 'selected' : '' ?>>
                    <?= esc($d['nama_dokter']) ?> (<?= esc($d['spesialisasi']) ?>)
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan" 
                     value="<?= $pendaftaran['tanggal_kunjungan'] ?>" required>
            </div>
            <div class="col-md-6">
              <label for="jam_kunjungan" class="form-label">Jam Kunjungan <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="jam_kunjungan" name="jam_kunjungan" 
                     value="<?= substr($pendaftaran['jam_kunjungan'], 0, 5) ?>" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="keluhan" class="form-label">Keluhan <span class="text-danger">*</span></label>
            <textarea class="form-control" id="keluhan" name="keluhan" rows="5" required><?= esc($pendaftaran['keluhan']) ?></textarea>
          </div>

          <div class="mb-3">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select" id="status" name="status" required>
              <option value="pending" <?= $pendaftaran['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
              <option value="disetujui" <?= $pendaftaran['status'] == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
              <option value="ditolak" <?= $pendaftaran['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
              <option value="dibatalkan" <?= $pendaftaran['status'] == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="catatan_admin" class="form-label">Catatan Admin</label>
            <textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="3"><?= esc($pendaftaran['catatan_admin'] ?? '') ?></textarea>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('admin/pendaftaran') ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>