<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?> - RS Finna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .registration-card {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            background: white;
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-header h2 {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-card">
            <div class="form-header">
                <h2>Pendaftaran Pasien Terdaftar</h2>
                <p class="text-muted">Masukkan data Anda untuk membuat janji baru</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('booking/process-existing') ?>" method="post">
                <!-- Data Verifikasi Pasien -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2">Verifikasi Data Pasien</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" 
                                   required minlength="16" maxlength="16"
                                   value="<?= old('nik') ?>">
                            <small class="text-muted">16 digit NIK sesuai KTP</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="no_telepon" name="no_telepon" 
                                   required value="<?= old('no_telepon') ?>">
                        </div>
                    </div>
                </div>

                <!-- Data Pendaftaran -->
                <div class="mb-4">
                    <h5 class="border-bottom pb-2">Data Pendaftaran</h5>
                    <div class="mb-3">
                        <label for="id_dokter" class="form-label">Pilih Dokter</label>
                        <select class="form-select" id="id_dokter" name="id_dokter" required>
                            <option value="">-- Pilih Dokter --</option>
                            <?php foreach ($dokter as $d): ?>
                                <option value="<?= $d['id_dokter'] ?>" <?= old('id_dokter') == $d['id_dokter'] ? 'selected' : '' ?>>
                                    <?= $d['nama_dokter'] ?> (<?= $d['spesialisasi'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                            <input type="date" class="form-control" id="tanggal_kunjungan" 
                                   name="tanggal_kunjungan" required min="<?= date('Y-m-d') ?>" 
                                   value="<?= old('tanggal_kunjungan') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jam_kunjungan" class="form-label">Jam Kunjungan</label>
                            <select class="form-select" id="jam_kunjungan" name="jam_kunjungan" required>
                                <option value="">-- Pilih Jam --</option>
                                <option value="08:00">08:00 - 09:00</option>
                                <option value="09:00">09:00 - 10:00</option>
                                <option value="10:00">10:00 - 11:00</option>
                                <option value="13:00">13:00 - 14:00</option>
                                <option value="14:00">14:00 - 15:00</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="keluhan" class="form-label">Keluhan</label>
                        <textarea class="form-control" id="keluhan" name="keluhan" 
                                  rows="3" required><?= old('keluhan') ?></textarea>
                        <small class="text-muted">Jelaskan keluhan Anda minimal 10 karakter</small>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Daftar Sekarang</button>
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">
                        Kembali ke Menu Utama
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set tanggal minimal ke hari ini
        document.getElementById('tanggal_kunjungan').min = new Date().toISOString().split('T')[0];
    </script>
</body>
</html>