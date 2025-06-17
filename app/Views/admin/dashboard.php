<?= $this->extend('layouts/app') ?>

<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-12 mb-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Selamat Datang, <?= session('nama_lengkap') ?></h5>
        <p class="card-text">Anda berhasil login ke sistem administrasi RS Finna.</p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  // Script khusus dashboard bisa ditambahkan di sini
  $(document).ready(function() {
    console.log('Dashboard ready');
  });
</script>
<?= $this->endSection() ?>