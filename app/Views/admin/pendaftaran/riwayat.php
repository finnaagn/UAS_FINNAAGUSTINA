<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Riwayat Pendaftaran<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Riwayat Perubahan Status Pendaftaran</h5>
      </div>
      <div class="card-body">
        <div class="mb-4">
          <h6>Detail Pendaftaran</h6>
          <div class="row">
            <div class="col-md-6">
              <p><strong>Pasien:</strong> <?= esc($pendaftaran['nama_pasien']) ?></p>
              <p><strong>Dokter:</strong> <?= esc($pendaftaran['nama_dokter']) ?></p>
            </div>
            <div class="col-md-6">
              <p><strong>Tanggal Kunjungan:</strong> 
                <?= date('d/m/Y', strtotime($pendaftaran['tanggal_kunjungan'])) ?> 
                <?= date('H:i', strtotime($pendaftaran['jam_kunjungan'])) ?>
              </p>
              <p><strong>Status Saat Ini:</strong> 
                <span class="badge 
                  <?= $pendaftaran['status'] == 'disetujui' ? 'bg-success' : 
                     ($pendaftaran['status'] == 'ditolak' ? 'bg-danger' : 
                     ($pendaftaran['status'] == 'dibatalkan' ? 'bg-secondary' : 'bg-warning')) ?>">
                  <?= ucfirst($pendaftaran['status']) ?>
                </span>
              </p>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Waktu</th>
                <th>Diubah Oleh</th>
                <th>Status Sebelumnya</th>
                <th>Status Baru</th>
                <th>Catatan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($riwayat as $item) : ?>
                <tr>
                  <td><?= date('d/m/Y H:i', strtotime($item['timestamp_perubahan'])) ?></td>
                  <td><?= esc($item['diubah_oleh']) ?></td>
                  <td>
                    <?php if ($item['status_sebelumnya']) : ?>
                      <span class="badge 
                        <?= $item['status_sebelumnya'] == 'disetujui' ? 'bg-success' : 
                           ($item['status_sebelumnya'] == 'ditolak' ? 'bg-danger' : 
                           ($item['status_sebelumnya'] == 'dibatalkan' ? 'bg-secondary' : 'bg-warning')) ?>">
                        <?= ucfirst($item['status_sebelumnya']) ?>
                      </span>
                    <?php else : ?>
                      -
                    <?php endif ?>
                  </td>
                  <td>
                    <span class="badge 
                      <?= $item['status_baru'] == 'disetujui' ? 'bg-success' : 
                         ($item['status_baru'] == 'ditolak' ? 'bg-danger' : 
                         ($item['status_baru'] == 'dibatalkan' ? 'bg-secondary' : 'bg-warning')) ?>">
                      <?= ucfirst($item['status_baru']) ?>
                    </span>
                  </td>
                  <td><?= esc($item['catatan_perubahan']) ?: '-' ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          <a href="<?= base_url('admin/pendaftaran') ?>" class="btn btn-secondary">
            Kembali ke Daftar Pendaftaran
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>