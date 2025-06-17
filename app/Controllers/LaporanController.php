<?php
namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\PendaftaranModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class LaporanController extends BaseController
{
    protected $laporanModel;
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        $this->pendaftaranModel = new PendaftaranModel();
        helper(['form', 'date']);
    }

    // List semua laporan
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Manajemen Laporan',
            'laporan' => $this->laporanModel->getLaporanWithAdmin()->findAll()
        ];

        return view('admin/laporan/index', $data);
    }

    // Form generate laporan
    public function generate()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Generate Laporan'
        ];

        return view('admin/laporan/generate', $data);
    }

    // Proses generate laporan
    public function processGenerate()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/login');
    }

    $rules = [
        'jenis_laporan' => 'required|in_list[harian,mingguan,bulanan,tahunan,kustom]',
        'periode_mulai' => 'required|valid_date',
        'periode_selesai' => 'required|valid_date'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $jenis = $this->request->getPost('jenis_laporan');
    $mulai = $this->request->getPost('periode_mulai');
    $selesai = $this->request->getPost('periode_selesai');

    // Query untuk mendapatkan data pendaftaran dengan default value 0
    $query = $this->pendaftaranModel
        ->select("COUNT(*) as total, 
                 COALESCE(SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END), 0) as disetujui,
                 COALESCE(SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END), 0) as ditolak,
                 COALESCE(SUM(CASE WHEN status = 'dibatalkan' THEN 1 ELSE 0 END), 0) as dibatalkan")
        ->where('tanggal_kunjungan >=', $mulai)
        ->where('tanggal_kunjungan <=', $selesai)
        ->first();

    // Pastikan tidak ada nilai null
    $total = (int)($query['total'] ?? 0);
    $disetujui = (int)($query['disetujui'] ?? 0);
    $ditolak = (int)($query['ditolak'] ?? 0);
    $dibatalkan = (int)($query['dibatalkan'] ?? 0);

    // Simpan laporan
    $this->laporanModel->save([
        'jenis_laporan' => $jenis,
        'periode_mulai' => $mulai,
        'periode_selesai' => $selesai,
        'total_pendaftar' => $total,
        'total_disetujui' => $disetujui,
        'total_ditolak' => $ditolak,
        'total_dibatalkan' => $dibatalkan,
        'generated_by' => session()->get('id_admin')
    ]);

    return redirect()->to('/admin/laporan')
        ->with('message', 'Laporan berhasil digenerate');
}

    // View detail laporan
    public function view($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $laporan = $this->laporanModel->getLaporanWithAdmin()->find($id);
        if (!$laporan) {
            throw new PageNotFoundException('Laporan tidak ditemukan');
        }

        // Get detail pendaftaran berdasarkan periode laporan
        $pendaftaran = $this->pendaftaranModel->getPendaftaranWithRelations()
            ->where('tanggal_kunjungan >=', $laporan['periode_mulai'])
            ->where('tanggal_kunjungan <=', $laporan['periode_selesai'])
            ->findAll();

        $data = [
            'title' => 'Detail Laporan',
            'laporan' => $laporan,
            'pendaftaran' => $pendaftaran
        ];

        return view('admin/laporan/view', $data);
    }

    // Export ke PDF
    public function exportPDF($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $laporan = $this->laporanModel->getLaporanWithAdmin()->find($id);
        if (!$laporan) {
            throw new PageNotFoundException('Laporan tidak ditemukan');
        }

        $pendaftaran = $this->pendaftaranModel->getPendaftaranWithRelations()
            ->where('tanggal_kunjungan >=', $laporan['periode_mulai'])
            ->where('tanggal_kunjungan <=', $laporan['periode_selesai'])
            ->findAll();

        $data = [
            'laporan' => $laporan,
            'pendaftaran' => $pendaftaran
        ];

        $dompdf = new \Dompdf\Dompdf();
        $html = view('admin/laporan/export_pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("laporan-{$laporan['jenis_laporan']}-{$laporan['periode_mulai']}-{$laporan['periode_selesai']}.pdf", ["Attachment" => true]);
    }

    // Hapus laporan
    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $laporan = $this->laporanModel->find($id);
        if (!$laporan) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['error' => 'Laporan tidak ditemukan'])->setStatusCode(404);
            }
            throw new PageNotFoundException('Laporan tidak ditemukan');
        }

        // Hapus laporan dari database
        $this->laporanModel->delete($id);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Laporan berhasil dihapus']);
        }

        return redirect()->to('/admin/laporan')
            ->with('message', 'Laporan berhasil dihapus');
    }
}