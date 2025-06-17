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
        .result-card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card result-card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Hasil Pencarian Pendaftaran</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5>Data Pasien</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>NIK:</strong> <?= $pasien['nik'] ?></p>
                            <p><strong>Nama:</strong> <?= esc($pasien['nama_lengkap']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>No. Telepon:</strong> <?= $pasien['no_telepon'] ?></p>
                            <p><strong>Jenis Kelamin:</strong> <?= $pasien['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h5 class="mb-3">Riwayat Pendaftaran</h5>
                
                <?php if (empty($pendaftaran)) : ?>
                    <div class="alert alert-info">
                        Tidak ada data pendaftaran ditemukan.
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No. Pendaftaran</th>
                                    <th>Tanggal Kunjungan</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendaftaran as $item) : ?>
                                <tr>
                                    <td><?= $item['id_pendaftaran'] ?></td>
                                    <td>
                                        <?= date('d/m/Y', strtotime($item['tanggal_kunjungan'])) ?><br>
                                        <?= date('H:i', strtotime($item['jam_kunjungan'])) ?>
                                    </td>
                                    <td><?= esc($item['nama_dokter']) ?></td>
                                    <td>
                                        <?php 
                                            $badgeClass = [
                                                'pending' => 'bg-warning text-dark',
                                                'disetujui' => 'bg-success text-white', // Ubah 'confirmed' menjadi 'disetujui'
                                                'ditolak' => 'bg-danger text-white', // Tambahkan 'ditolak'
                                                'dibatalkan' => 'bg-danger text-white'
                                            ];
                                        ?>
                                        <span class="badge <?= $badgeClass[strtolower($item['status'])] ?> status-badge">
                                            <?= ucfirst($item['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('booking/success/'.$item['id_pendaftaran']) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="<?= base_url('/') ?>" class="btn btn-primary">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>