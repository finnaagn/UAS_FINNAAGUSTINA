<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pendaftaran Berhasil - RS Finna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .success-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }
        .detail-card {
            background-color: #f8f9fa;
            border-left: 4px solid #28a745;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Pendaftaran Berhasil</h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle success-icon"></i>
                        <h4 class="mb-3">Terima kasih telah mendaftar!</h4>
                        
                        <?php if (session()->getFlashdata('message')) : ?>
                            <div class="alert alert-info">
                                <?= session()->getFlashdata('message') ?>
                            </div>
                        <?php endif ?>

                        <div class="card mb-4 detail-card">
                            <div class="card-body text-start">
                                <h5 class="card-title">Detail Pendaftaran</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Nomor Pendaftaran:</strong> <?= $pendaftaran['id_pendaftaran'] ?></p>
                                        <p><strong>Nama Pasien:</strong> <?= esc($pendaftaran['nama_pasien']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tanggal Kunjungan:</strong> 
                                            <?= date('d/m/Y', strtotime($pendaftaran['tanggal_kunjungan'])) ?>
                                            <?= date('H:i', strtotime($pendaftaran['jam_kunjungan'])) ?>
                                        </p>
                                        <p><strong>Dokter:</strong> <?= esc($pendaftaran['nama_dokter']) ?></p>
                                    </div>
                                </div>
                                <p class="mt-3"><strong>Status:</strong> 
                                    <span class="badge bg-warning text-dark"><?= ucfirst($pendaftaran['status']) ?></span>
                                </p>
                            </div>
                        </div>

                        <p class="mb-4">Silakan datang ke rumah sakit pada tanggal yang telah ditentukan dengan membawa bukti pendaftaran ini.</p>
                        
                        <div class="d-grid gap-2 d-md-block">
                            <a href="<?= base_url('/') ?>" class="btn btn-primary">
                                <i class="fas fa-home"></i> Kembali ke Halaman Utama
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-secondary ms-md-2 mt-2 mt-md-0">
                                <i class="fas fa-print"></i> Cetak Bukti
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-muted">© <?= date('Y') ?> RS Finna. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>