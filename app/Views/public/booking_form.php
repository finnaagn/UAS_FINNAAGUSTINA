<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pendaftaran Online - RS Finna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Pendaftaran Online</h2>
                    <p class="text-muted">RS Finna - Layanan Pendaftaran Pasien Baru</p>
                </div>
                
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Form Pendaftaran Pasien Baru</h5>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="alert alert-danger">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <p><?= $error ?></p>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>

                        <form action="<?= base_url('booking/process') ?>" method="POST">
                            <?= csrf_field() ?>

                            <h6 class="mb-3">Data Pribadi</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nik" class="form-label required-field">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik" required maxlength="16">
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label required-field">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="tanggal_lahir" class="form-label required-field">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="jenis_kelamin" class="form-label required-field">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">Pilih...</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="no_telepon" class="form-label required-field">No. Telepon</label>
                                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label required-field">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Data Kunjungan</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="id_dokter" class="form-label required-field">Dokter</label>
                                    <select class="form-select" id="id_dokter" name="id_dokter" required>
                                        <option value="">Pilih Dokter...</option>
                                        <?php foreach ($dokter as $d) : ?>
                                            <option value="<?= $d['id_dokter'] ?>">
                                                <?= esc($d['nama_dokter']) ?> (<?= esc($d['spesialisasi']) ?>)
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="tanggal_kunjungan" class="form-label required-field">Tanggal Kunjungan</label>
                                    <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan" 
                                           min="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="jam_kunjungan" class="form-label required-field">Jam Kunjungan</label>
                                    <input type="time" class="form-control" id="jam_kunjungan" name="jam_kunjungan" 
                                           min="08:00" max="16:00" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keluhan" class="form-label required-field">Keluhan</label>
                                <textarea class="form-control" id="keluhan" name="keluhan" rows="5" required></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-secondary me-md-2">Reset Form</button>
                                <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <p class="text-muted">© <?= date('Y') ?> RS Finna. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set tanggal default untuk kunjungan (hari ini)
        document.getElementById('tanggal_kunjungan').valueAsDate = new Date();
        
        // Validasi NIK harus angka
        document.getElementById('nik').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Validasi nomor telepon harus angka
        document.getElementById('no_telepon').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>