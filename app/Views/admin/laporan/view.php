<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Detail Laporan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Detail Laporan Pendaftaran</h5>
        <div class="card-tools">
          <a href="<?= base_url('admin/laporan/exportPDF/' . $laporan['id_laporan']) ?>" 
             class="btn btn-danger btn-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-6">
            <h6>Informasi Laporan</h6>
            <p><strong>Jenis Laporan:</strong> <?= ucfirst($laporan['jenis_laporan']) ?></p>
            <p><strong>Periode:</strong> 
              <?= date('d/m/Y', strtotime($laporan['periode_mulai'])) ?> - 
              <?= date('d/m/Y', strtotime($laporan['periode_selesai'])) ?>
            </p>
            <p><strong>Dibuat Oleh:</strong> <?= esc($laporan['nama_admin']) ?></p>
            <p><strong>Tanggal Generate:</strong> <?= date('d/m/Y H:i', strtotime($laporan['tanggal_generate'])) ?></p>
          </div>
          <div class="col-md-6">
            <h6>Statistik Pendaftaran</h6>
            <div class="row">
              <div class="col-6">
                <div class="info-box bg-success">
                  <span class="info-box-icon"><i class="fas fa-check"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Disetujui</span>
                    <span class="info-box-number"><?= $laporan['total_disetujui'] ?></span>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="info-box bg-danger">
                  <span class="info-box-icon"><i class="fas fa-times"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Ditolak</span>
                    <span class="info-box-number"><?= $laporan['total_ditolak'] ?></span>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="info-box bg-secondary">
                  <span class="info-box-icon"><i class="fas fa-ban"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Dibatalkan</span>
                    <span class="info-box-number"><?= $laporan['total_dibatalkan'] ?></span>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="info-box bg-primary">
                  <span class="info-box-icon"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total</span>
                    <span class="info-box-number"><?= $laporan['total_pendaftar'] ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <h5 class="mb-3">Detail Pendaftaran</h5>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal Kunjungan</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Keluhan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pendaftaran as $key => $item) : ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td>
                    <?= date('d/m/Y', strtotime($item['tanggal_kunjungan'])) ?><br>
                    <?= date('H:i', strtotime($item['jam_kunjungan'])) ?>
                  </td>
                  <td><?= esc($item['nama_pasien']) ?></td>
                  <td><?= esc($item['nama_dokter']) ?></td>
                  <td><?= esc(substr($item['keluhan'], 0, 50)) ?>...</td>
                  <td>
                    <span class="badge 
                      <?= $item['status'] == 'disetujui' ? 'bg-success' : 
                         ($item['status'] == 'ditolak' ? 'bg-danger' : 
                         ($item['status'] == 'dibatalkan' ? 'bg-secondary' : 'bg-warning')) ?>">
                      <?= ucfirst($item['status']) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          <a href="<?= base_url('admin/laporan') ?>" class="btn btn-secondary">
            Kembali ke Daftar Laporan
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>