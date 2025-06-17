<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Manajemen Pendaftaran<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Daftar Pendaftaran Pasien</h5>
        <div class="card-tools">
          <a href="<?= base_url('admin/pendaftaran/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Pendaftaran Baru
          </a>
        </div>
      </div>
      <div class="card-body">
        <?php if (session()->getFlashdata('message')) : ?>
          <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
          </div>
        <?php endif ?>

        <div class="table-responsive">
          <table class="table table-bordered table-hover" id="tablePendaftaran">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal Kunjungan</th>
                <th>Nama Pasien</th>
                <th>Dokter</th>
                <th>Keluhan</th>
                <th>Status</th>
                <th>Aksi</th>
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
                  <td>
                    <a href="<?= base_url('admin/pendaftaran/edit/' . $item['id_pendaftaran']) ?>" class="btn btn-sm btn-warning">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="<?= base_url('admin/pendaftaran/delete/' . $item['id_pendaftaran']) ?>" method="POST" class="d-inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                    <a href="<?= base_url('admin/pendaftaran/riwayat/' . $item['id_pendaftaran']) ?>" 
                        class="btn btn-sm btn-info" title="Lihat Riwayat">
                        <i class="fas fa-history"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#tablePendaftaran').DataTable({
        order: [[1, 'asc']]
    });
});
</script>
<?= $this->endSection() ?>