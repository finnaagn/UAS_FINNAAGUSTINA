<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Pendaftaran Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Form Pendaftaran Pasien</h5>
      </div>
      <div class="card-body">
        <?php if (session()->getFlashdata('errors')) : ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
              <p><?= $error ?></p>
            <?php endforeach ?>
          </div>
        <?php endif ?>

        <form action="<?= base_url('admin/pendaftaran/store') ?>" method="POST">
          <?= csrf_field() ?>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="id_pasien" class="form-label">Pasien <span class="text-danger">*</span></label>
              <select class="form-select" id="id_pasien" name="id_pasien" required>
                <option value="">Pilih Pasien...</option>
                <?php foreach ($pasien as $p) : ?>
                  <option value="<?= $p['id_pasien'] ?>">
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
                  <option value="<?= $d['id_dokter'] ?>">
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
                     min="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6">
              <label for="jam_kunjungan" class="form-label">Jam Kunjungan <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="jam_kunjungan" name="jam_kunjungan" 
                     min="08:00" max="16:00" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="keluhan" class="form-label">Keluhan <span class="text-danger">*</span></label>
            <textarea class="form-control" id="keluhan" name="keluhan" rows="5" required></textarea>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('admin/pendaftaran') ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('tanggal_kunjungan').valueAsDate = new Date();
</script>
<?= $this->endSection() ?>