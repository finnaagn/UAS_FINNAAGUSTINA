<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Manajemen Pasien<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Daftar Pasien</h5>
      </div>
      <div class="card-body">
        <?php if (session()->getFlashdata('message')) : ?>
          <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
          </div>
        <?php endif; ?>

        <div class="mb-3">
          <a href="<?= base_url('admin/pasien/create') ?>" class="btn btn-primary">
            <i class="bx bx-plus"></i> Tambah Pasien
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-hover" id="tablePasien">
            <thead>
              <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>No. Telepon</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pasien as $index => $row) : ?>
                <tr>
                  <td><?= $index + 1 ?></td>
                  <td><?= esc($row['nik']) ?></td>
                  <td><?= esc($row['nama_lengkap']) ?></td>
                  <td><?= date('d/m/Y', strtotime($row['tanggal_lahir'])) ?></td>
                  <td><?= $row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                  <td><?= esc($row['no_telepon']) ?></td>
                  <td>
                    <a href="<?= base_url("admin/pasien/edit/{$row['id_pasien']}") ?>" class="btn btn-sm btn-warning">
                      <i class="bx bx-edit"></i>
                    </a>
                    <form action="<?= base_url("admin/pasien/delete/{$row['id_pasien']}") ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pasien ini?')">
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

<?= $this->section('scripts') ?>
<script>
  $(document).ready(function() {
    $('#tablePasien').DataTable();
  });
</script>
<?= $this->endSection() ?>