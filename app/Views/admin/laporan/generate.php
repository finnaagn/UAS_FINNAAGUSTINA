<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Generate Laporan<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">Generate Laporan Pendaftaran</h5>
      </div>
      <div class="card-body">
        <?php if (session()->getFlashdata('errors')) : ?>
          <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
              <p><?= $error ?></p>
            <?php endforeach ?>
          </div>
        <?php endif ?>

        <form action="<?= base_url('admin/laporan/processGenerate') ?>" method="POST">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label for="jenis_laporan" class="form-label">Jenis Laporan <span class="text-danger">*</span></label>
            <select class="form-select" id="jenis_laporan" name="jenis_laporan" required>
              <option value="">Pilih Jenis Laporan...</option>
              <option value="harian">Harian</option>
              <option value="mingguan">Mingguan</option>
              <option value="bulanan">Bulanan</option>
              <option value="tahunan">Tahunan</option>
              <option value="kustom">Periode Kustom</option>
            </select>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="periode_mulai" class="form-label">Periode Mulai <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="periode_mulai" name="periode_mulai" required>
            </div>
            <div class="col-md-6">
              <label for="periode_selesai" class="form-label">Periode Selesai <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="periode_selesai" name="periode_selesai" required>
            </div>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary">Generate</button>
            <a href="<?= base_url('admin/laporan') ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('jenis_laporan').addEventListener('change', function() {
    const jenis = this.value;
    const today = new Date();
    let startDate, endDate;

    switch(jenis) {
        case 'harian':
            startDate = endDate = today.toISOString().split('T')[0];
            break;
        case 'mingguan':
            const day = today.getDay();
            const diff = today.getDate() - day + (day === 0 ? -6 : 1); // adjust for Sunday
            startDate = new Date(today.setDate(diff)).toISOString().split('T')[0];
            endDate = new Date(today.setDate(diff + 6)).toISOString().split('T')[0];
            break;
        case 'bulanan':
            startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
            endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
            break;
        case 'tahunan':
            startDate = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
            endDate = new Date(today.getFullYear(), 11, 31).toISOString().split('T')[0];
            break;
        default:
            // For custom, don't auto-fill
            return;
    }

    document.getElementById('periode_mulai').value = startDate;
    document.getElementById('periode_selesai').value = endDate;
});
</script>
<?= $this->endSection() ?>