<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Manajemen Laporan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Daftar Laporan</h5>
        <div class="card-tools">
          <a href="<?= base_url('admin/laporan/generate') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Generate Laporan
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
          <table class="table table-bordered table-hover" id="tableLaporan">
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Periode</th>
                <th>Total Pendaftar</th>
                <th>Disetujui</th>
                <th>Ditolak</th>
                <th>Dibatalkan</th>
                <th>Dibuat Oleh</th>
                <th>Tanggal Generate</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($laporan as $key => $item) : ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td><?= ucfirst($item['jenis_laporan']) ?></td>
                  <td>
                    <?= date('d/m/Y', strtotime($item['periode_mulai'])) ?> - 
                    <?= date('d/m/Y', strtotime($item['periode_selesai'])) ?>
                  </td>
                  <td><?= $item['total_pendaftar'] ?></td>
                  <td><?= $item['total_disetujui'] ?></td>
                  <td><?= $item['total_ditolak'] ?></td>
                  <td><?= $item['total_dibatalkan'] ?></td>
                  <td><?= esc($item['nama_admin']) ?></td>
                  <td><?= date('d/m/Y H:i', strtotime($item['tanggal_generate'])) ?></td>
                  <td>
                    <a href="<?= base_url('admin/laporan/view/' . $item['id_laporan']) ?>" 
                       class="btn btn-sm btn-info" title="Lihat Detail">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="<?= base_url('admin/laporan/exportPDF/' . $item['id_laporan']) ?>" 
                       class="btn btn-sm btn-danger" title="Export PDF">
                      <i class="fas fa-file-pdf"></i>
                    </a>
                    <!-- Tombol Hapus dengan Konfirmasi -->
                    <button type="button" class="btn btn-sm btn-danger delete-laporan" 
                            data-id="<?= $item['id_laporan'] ?>" title="Hapus Laporan">
                        <i class="fas fa-trash"></i>
                    </button>
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
<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus laporan ini? Data yang dihapus tidak dapat dikembalikan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-danger" id="confirmDeleteButton">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tableLaporan').DataTable({
        order: [[8, 'desc']]
    });

    // Handle tombol hapus
    $('.delete-laporan').click(function() {
        var id = $(this).data('id');
        var deleteUrl = '<?= base_url('admin/laporan/delete/') ?>' + id;
        
        $('#confirmDeleteButton').attr('href', deleteUrl);
        $('#confirmDeleteModal').modal('show');
    });

    // Jika modal ditutup, hapus URL dari tombol konfirmasi
    $('#confirmDeleteModal').on('hidden.bs.modal', function () {
        $('#confirmDeleteButton').attr('href', '#');
    });
});
</script>

<script>
$(document).ready(function() {
    $('#tableLaporan').DataTable({
        order: [[8, 'desc']]
    });
});
</script>
<?= $this->endSection() ?>