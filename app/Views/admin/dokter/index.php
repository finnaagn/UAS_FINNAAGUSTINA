<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Manajemen Dokter<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Daftar Dokter</h5>
        <div class="card-tools">
          <a href="<?= base_url('admin/dokter/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Dokter
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
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Dokter</th>
                <th>Spesialisasi</th>
                <th>Jadwal Praktek</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dokter as $key => $item) : ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td><?= esc($item['nama_dokter']) ?></td>
                  <td><?= esc($item['spesialisasi']) ?></td>
                  <td><?= esc($item['jadwal_praktek']) ?></td>
                  <td>
                    <span class="badge <?= $item['status_aktif'] === 'aktif' ? 'bg-success' : ($item['status_aktif'] === 'cuti' ? 'bg-warning' : 'bg-danger') ?>">
                      <?= ucfirst($item['status_aktif']) ?>
                    </span>
                  </td>
                  <td>
                    <a href="<?= base_url('admin/dokter/edit/' . $item['id_dokter']) ?>" class="btn btn-sm btn-warning">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="<?= base_url('admin/dokter/delete/' . $item['id_dokter']) ?>" method="POST" class="d-inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
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
<?= $this->endSection() ?>