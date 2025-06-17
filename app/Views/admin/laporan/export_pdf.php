<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendaftaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 14px; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 20px; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN PENDAFTARAN PASIEN</div>
        <div class="subtitle"><?= strtoupper($laporan['jenis_laporan']) ?> (<?= date('d/m/Y', strtotime($laporan['periode_mulai'])) ?> - <?= date('d/m/Y', strtotime($laporan['periode_selesai'])) ?>)</div>
    </div>

    <div class="info">
        <div><strong>Dibuat Oleh:</strong> <?= $laporan['nama_admin'] ?></div>
        <div><strong>Tanggal Generate:</strong> <?= date('d/m/Y H:i', strtotime($laporan['tanggal_generate'])) ?></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Kunjungan</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendaftaran as $key => $item) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= date('d/m/Y H:i', strtotime($item['tanggal_kunjungan'].' '.$item['jam_kunjungan'])) ?></td>
                <td><?= $item['nama_pasien'] ?></td>
                <td><?= $item['nama_dokter'] ?></td>
                <td><?= ucfirst($item['status']) ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="summary">
        <h4>Ringkasan Statistik</h4>
        <table>
            <tr>
                <th>Total Pendaftar</th>
                <td><?= $laporan['total_pendaftar'] ?></td>
            </tr>
            <tr>
                <th>Disetujui</th>
                <td><?= $laporan['total_disetujui'] ?></td>
            </tr>
            <tr>
                <th>Ditolak</th>
                <td><?= $laporan['total_ditolak'] ?></td>
            </tr>
            <tr>
                <th>Dibatalkan</th>
                <td><?= $laporan['total_dibatalkan'] ?></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dicetak pada <?= date('d/m/Y H:i:s') ?>
    </div>
</body>
</html>