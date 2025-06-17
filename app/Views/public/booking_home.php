<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?> - RS Finna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .option-card {
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            height: 100%;
        }
        .option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .option-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">Sistem Pendaftaran Online</h1>
            <p class="lead text-muted">RS Finna - Layanan Kesehatan Terbaik untuk Anda</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card option-card" onclick="window.location.href='<?= base_url('booking/new') ?>'">
                    <div class="card-body text-center p-5">
                        <i class="fas fa-user-plus option-icon"></i>
                        <h3 class="card-title">Pasien Baru</h3>
                        <p class="card-text">Daftar sebagai pasien baru untuk mendapatkan layanan kami</p>
                        <button class="btn btn-primary">Daftar Baru</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card option-card" onclick="window.location.href='<?= base_url('booking/existing') ?>'">
                    <div class="card-body text-center p-5">
                        <i class="fas fa-user-check option-icon"></i>
                        <h3 class="card-title">Pasien Terdaftar</h3>
                        <p class="card-text">Sudah terdaftar? Buat janji baru dengan data yang sudah ada</p>
                        <button class="btn btn-primary">Daftar Sekarang</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card option-card" onclick="window.location.href='<?= base_url('booking/search') ?>'">
                    <div class="card-body text-center p-5">
                        <i class="fas fa-search option-icon"></i>
                        <h3 class="card-title">Cek Pendaftaran</h3>
                        <p class="card-text">Cek status pendaftaran Anda dengan NIK dan nomor telepon</p>
                        <button class="btn btn-outline-primary">Cari Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5 pt-4">
            <p class="text-muted">© <?= date('Y') ?> RS Finna. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>