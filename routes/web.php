<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\KategoriController;
use App\Models\Buku;
use App\Models\Anggota;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('home');


// Route sederhana
Route::get('/hello', function () {
    return 'Hello dari Laravel!';
});

Route::get('/info', function () {
    return '<h1>Sistem Perpustakaan</h1><p>Selamat datang!</p>';
});

Route::get('/buku', function () {
    return [
        'judul'     => 'Laravel Programming',
        'pengarang' => 'John Doe',
        'harga'     => 150000
    ];
});

Route::get('/search/{kategori}/{keyword}', function ($kategori, $keyword) {
    return "Cari buku kategori: $kategori dengan keyword: $keyword";
});

// Named route
Route::get('/perpustakaan-home', function () {
    return 'Halaman Perpustakaan';
})->name('perpus.home');

Route::get('/test-route', function () {
    return "URL perpustakaan: " . route('perpus.home');
});


// PerpustakaanController
Route::get('/perpustakaan', [PerpustakaanController::class, 'index'])->name('perpustakaan.index');
Route::get('/buku/{id}',    [PerpustakaanController::class, 'show'])->name('buku.show');
Route::get('/about',        [PerpustakaanController::class, 'about'])->name('perpustakaan.about');


// Anggota
Route::get('/anggota', function () {
    $anggota_list = collect([
        ['id'=>1,'kode'=>'AGT-001','nama'=>'Budi Santoso', 'email'=>'budi@email.com', 'telepon'=>'081234567890','alamat'=>'Jakarta',   'pekerjaan'=>'Mahasiswa', 'tanggal_daftar'=>'01 Jan 2024','status'=>'Aktif'],
        ['id'=>2,'kode'=>'AGT-002','nama'=>'Siti Rahayu',  'email'=>'siti@email.com', 'telepon'=>'082345678901','alamat'=>'Bandung',   'pekerjaan'=>'Guru',      'tanggal_daftar'=>'15 Feb 2024','status'=>'Aktif'],
        ['id'=>3,'kode'=>'AGT-003','nama'=>'Ahmad Fauzi',  'email'=>'ahmad@email.com','telepon'=>'083456789012','alamat'=>'Semarang',  'pekerjaan'=>'Dosen',     'tanggal_daftar'=>'20 Mar 2024','status'=>'Aktif'],
        ['id'=>4,'kode'=>'AGT-004','nama'=>'Dewi Lestari', 'email'=>'dewi@email.com', 'telepon'=>'084567890123','alamat'=>'Yogyakarta','pekerjaan'=>'Peneliti',  'tanggal_daftar'=>'10 Apr 2024','status'=>'Non-Aktif'],
        ['id'=>5,'kode'=>'AGT-005','nama'=>'Rizky Pratama','email'=>'rizky@email.com','telepon'=>'085678901234','alamat'=>'Pekalongan','pekerjaan'=>'Mahasiswa', 'tanggal_daftar'=>'05 Mei 2024','status'=>'Aktif'],
        ['id'=>6,'kode'=>'AGT-006','nama'=>'Nurul Hidayah','email'=>'nurul@email.com','telepon'=>'086789012345','alamat'=>'Surabaya',  'pekerjaan'=>'Pustakawan','tanggal_daftar'=>'18 Jun 2024','status'=>'Aktif'],
    ]);
    return view('anggota.index', compact('anggota_list'));
})->name('anggota.index');

Route::get('/anggota/{id}', function ($id) {
    $data = [
        1 => ['id'=>1,'kode'=>'AGT-001','nama'=>'Budi Santoso', 'email'=>'budi@email.com', 'telepon'=>'081234567890','alamat'=>'Jl. Merdeka No.10, Jakarta',   'pekerjaan'=>'Mahasiswa', 'tanggal_daftar'=>'01 Jan 2024','status'=>'Aktif'],
        2 => ['id'=>2,'kode'=>'AGT-002','nama'=>'Siti Rahayu',  'email'=>'siti@email.com', 'telepon'=>'082345678901','alamat'=>'Jl. Sudirman No.25, Bandung',  'pekerjaan'=>'Guru',      'tanggal_daftar'=>'15 Feb 2024','status'=>'Aktif'],
        3 => ['id'=>3,'kode'=>'AGT-003','nama'=>'Ahmad Fauzi',  'email'=>'ahmad@email.com','telepon'=>'083456789012','alamat'=>'Jl. Diponegoro No.7, Semarang','pekerjaan'=>'Dosen',     'tanggal_daftar'=>'20 Mar 2024','status'=>'Aktif'],
        4 => ['id'=>4,'kode'=>'AGT-004','nama'=>'Dewi Lestari', 'email'=>'dewi@email.com', 'telepon'=>'084567890123','alamat'=>'Jl. Gajah Mada No.3, Jogja',  'pekerjaan'=>'Peneliti',  'tanggal_daftar'=>'10 Apr 2024','status'=>'Non-Aktif'],
        5 => ['id'=>5,'kode'=>'AGT-005','nama'=>'Rizky Pratama','email'=>'rizky@email.com','telepon'=>'085678901234','alamat'=>'Jl. Ahmad Yani No.55, PKL',   'pekerjaan'=>'Mahasiswa', 'tanggal_daftar'=>'05 Mei 2024','status'=>'Aktif'],
        6 => ['id'=>6,'kode'=>'AGT-006','nama'=>'Nurul Hidayah','email'=>'nurul@email.com','telepon'=>'086789012345','alamat'=>'Jl. Pahlawan No.12, Surabaya','pekerjaan'=>'Pustakawan','tanggal_daftar'=>'18 Jun 2024','status'=>'Aktif'],
    ];
    if (!isset($data[$id])) abort(404, 'Anggota tidak ditemukan');
    $anggota = $data[$id];
    return view('anggota.show', compact('anggota'));
})->name('anggota.show');


// KategoriController
Route::get('/kategori',                  [KategoriController::class, 'index']) ->name('kategori.index');
Route::get('/kategori/search/{keyword}', [KategoriController::class, 'search'])->name('kategori.search');
Route::get('/kategori/{id}',             [KategoriController::class, 'show'])  ->name('kategori.show');

// ========== TESTING BUKU ==========
 
// List all buku
Route::get('/buku', function () {
    $bukus = Buku::all();
    
    $html = '<h1>Daftar Buku</h1>';
    $html .= '<a href="/buku/create">Tambah Buku</a><br /><br />';
    $html .= '<table border="1" cellpadding="10">';
    $html .= '<tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
              </tr>';
    
    foreach ($bukus as $buku) {
        $html .= '<tr>';
        $html .= '<td>' . $buku->id . '</td>';
        $html .= '<td>' . $buku->kode_buku . '</td>';
        $html .= '<td>' . $buku->judul . '</td>';
        $html .= '<td>' . $buku->kategori . '</td>';
        $html .= '<td>' . $buku->harga_format . '</td>';
        $html .= '<td>' . $buku->stok . '</td>';
        $html .= '<td>
                    <a href="/buku/' . $buku->id . '">Detail</a> | 
                    <a href="/buku/' . $buku->id . '/edit">Edit</a>
                  </td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    
    return $html;
});
 
// Show single buku
Route::get('/buku/{id}', function ($id) {
    $buku = Buku::findOrFail($id);
    
    $html = '<h1>Detail Buku</h1>';
    $html .= '<a href="/buku">Kembali</a><br /><br />';
    $html .= '<table border="1" cellpadding="10">';
    $html .= '<tr><th>Field</th><th>Value</th></tr>';
    $html .= '<tr><td>ID</td><td>' . $buku->id . '</td></tr>';
    $html .= '<tr><td>Kode Buku</td><td>' . $buku->kode_buku . '</td></tr>';
    $html .= '<tr><td>Judul</td><td>' . $buku->judul . '</td></tr>';
    $html .= '<tr><td>Kategori</td><td>' . $buku->kategori . '</td></tr>';
    $html .= '<tr><td>Pengarang</td><td>' . $buku->pengarang . '</td></tr>';
    $html .= '<tr><td>Penerbit</td><td>' . $buku->penerbit . '</td></tr>';
    $html .= '<tr><td>Tahun</td><td>' . $buku->tahun_terbit . '</td></tr>';
    $html .= '<tr><td>ISBN</td><td>' . $buku->isbn . '</td></tr>';
    $html .= '<tr><td>Harga</td><td>' . $buku->harga_format . '</td></tr>';
    $html .= '<tr><td>Stok</td><td>' . $buku->stok . '</td></tr>';
    $html .= '<tr><td>Tersedia?</td><td>' . ($buku->tersedia ? 'Ya' : 'Tidak') . '</td></tr>';
    $html .= '<tr><td>Created</td><td>' . $buku->created_at . '</td></tr>';
    $html .= '<tr><td>Updated</td><td>' . $buku->updated_at . '</td></tr>';
    $html .= '</table>';
    
    return $html;
});
 
// ========== TESTING ANGGOTA ==========
 
// List all anggota
Route::get('/anggota', function () {
    $anggotas = Anggota::all();
    
    $html = '<h1>Daftar Anggota</h1>';
    $html .= '<table border="1" cellpadding="10">';
    $html .= '<tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Umur</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>';
    
    foreach ($anggotas as $anggota) {
        $html .= '<tr>';
        $html .= '<td>' . $anggota->id . '</td>';
        $html .= '<td>' . $anggota->kode_anggota . '</td>';
        $html .= '<td>' . $anggota->nama . '</td>';
        $html .= '<td>' . $anggota->email . '</td>';
        $html .= '<td>' . $anggota->umur . ' tahun</td>';
        $html .= '<td>' . $anggota->status . '</td>';
        $html .= '<td><a href="/anggota/' . $anggota->id . '">Detail</a></td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    
    return $html;
});
 
// Show single anggota
Route::get('/anggota/{id}', function ($id) {
    $anggota = Anggota::findOrFail($id);
    
    $html = '<h1>Detail Anggota</h1>';
    $html .= '<a href="/anggota">Kembali</a><br /><br />';
    $html .= '<table border="1" cellpadding="10">';
    $html .= '<tr><th>Field</th><th>Value</th></tr>';
    $html .= '<tr><td>Kode Anggota</td><td>' . $anggota->kode_anggota . '</td></tr>';
    $html .= '<tr><td>Nama</td><td>' . $anggota->nama . '</td></tr>';
    $html .= '<tr><td>Email</td><td>' . $anggota->email . '</td></tr>';
    $html .= '<tr><td>Telepon</td><td>' . $anggota->telepon . '</td></tr>';
    $html .= '<tr><td>Alamat</td><td>' . $anggota->alamat . '</td></tr>';
    $html .= '<tr><td>Tanggal Lahir</td><td>' . $anggota->tanggal_lahir->format('d-m-Y') . '</td></tr>';
    $html .= '<tr><td>Umur</td><td>' . $anggota->umur . ' tahun</td></tr>';
    $html .= '<tr><td>Jenis Kelamin</td><td>' . $anggota->jenis_kelamin . '</td></tr>';
    $html .= '<tr><td>Pekerjaan</td><td>' . $anggota->pekerjaan . '</td></tr>';
    $html .= '<tr><td>Tanggal Daftar</td><td>' . $anggota->tanggal_daftar->format('d-m-Y') . '</td></tr>';
    $html .= '<tr><td>Lama Anggota</td><td>' . $anggota->lama_anggota . ' hari</td></tr>';
    $html .= '<tr><td>Status</td><td>' . $anggota->status . '</td></tr>';
    $html .= '</table>';
    
    return $html;
});
 
// Testing Scope & Query
Route::get('/test-query', function () {
    $html = '<h1>Testing Query Eloquent</h1>';
    
    // Buku tersedia
    $tersedia = Buku::tersedia()->get();
    $html .= '<h3>Buku Tersedia (Stok > 0): ' . $tersedia->count() . '</h3>';
    $html .= '<ul>';
    foreach ($tersedia as $buku) {
        $html .= '<li>' . $buku->judul . ' (Stok: ' . $buku->stok . ')</li>';
    }
    $html .= '</ul>';
    
    // Buku Programming
    $programming = Buku::kategori('Programming')->get();
    $html .= '<h3>Buku Programming: ' . $programming->count() . '</h3>';
    $html .= '<ul>';
    foreach ($programming as $buku) {
        $html .= '<li>' . $buku->judul . '</li>';
    }
    $html .= '</ul>';
    
    // Anggota Aktif
    $aktif = Anggota::aktif()->get();
    $html .= '<h3>Anggota Aktif: ' . $aktif->count() . '</h3>';
    $html .= '<ul>';
    foreach ($aktif as $anggota) {
        $html .= '<li>' . $anggota->nama . ' (' . $anggota->email . ')</li>';
    }
    $html .= '</ul>';
    
    return $html;
});


// ROUTE: /test-accessor-scope
// Menampilkan hasil semua Accessor dan Scope pada Model Buku & Anggota.
Route::get('/test-accessor-scope', function () {
 
    // Ambil data
    $semuaBuku      = Buku::all();
    $bukuTerbaru    = Buku::terbaru()->get();
    $bukuMenipis    = Buku::stokMenipis()->get();
    $bukuRangeHarga = Buku::hargaRange(50000, 150000)->get();
 
    $semuaAnggota       = Anggota::all();
    $anggotaBulanIni    = Anggota::terdaftarBulanIni()->get();
    $anggotaLaki        = Anggota::jenisKelamin('L')->get();
    $anggotaPerempuan   = Anggota::jenisKelamin('P')->get();
 
    // Helper: render tabel 
    $tabel = function (string $judul, string $header, string $baris) {
        return <<<HTML
            <section class="mb-5">
                <h4 class="section-title">{$judul}</h4>
                <div class="table-wrapper">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-dark">{$header}</thead>
                        <tbody>{$baris}</tbody>
                    </table>
                </div>
            </section>
            HTML;
    };
 
    
    // MODEL BUKU
 
    // Semua Buku + status_stok_badge + tahun_label (accessor)
    $headerBuku = '<tr>
        <th>#</th><th>Judul</th><th>Pengarang</th>
        <th>Tahun</th><th>Tahun Label</th>
        <th>Stok</th><th>Status Stok</th><th>Harga</th>
    </tr>';
 
    $barisBuku = '';
    foreach ($semuaBuku as $i => $b) {
        $barisBuku .= "<tr>
            <td>" . ($i + 1) . "</td>
            <td>{$b->judul}</td>
            <td>{$b->pengarang}</td>
            <td>{$b->tahun_terbit}</td>
            <td><em>{$b->tahun_label}</em></td>
            <td class='text-center'>{$b->stok}</td>
            <td>{$b->status_stok_badge}</td>
            <td>Rp " . number_format($b->harga, 0, ',', '.') . "</td>
        </tr>";
    }
    $tableBukuSemua = $tabel(
        'Semua Buku — Accessor <code>status_stok_badge</code> &amp; <code>tahun_label</code>',
        $headerBuku,
        $barisBuku ?: '<tr><td colspan="8" class="text-center text-muted">Tidak ada data.</td></tr>'
    );
 
    // Scope terbaru()
    $barisTerbaru = '';
    foreach ($bukuTerbaru as $i => $b) {
        $barisTerbaru .= "<tr>
            <td>" . ($i + 1) . "</td>
            <td>{$b->judul}</td>
            <td>{$b->pengarang}</td>
            <td>{$b->tahun_terbit}</td>
            <td><em>{$b->tahun_label}</em></td>
            <td class='text-center'>{$b->stok}</td>
            <td>{$b->status_stok_badge}</td>
        </tr>";
    }
    $tableBukuTerbaru = $tabel(
        'Scope <code>terbaru()</code> — Buku Tahun ≥ 2024',
        '<tr><th>#</th><th>Judul</th><th>Pengarang</th><th>Tahun</th><th>Label</th><th>Stok</th><th>Status</th></tr>',
        $barisTerbaru ?: '<tr><td colspan="7" class="text-center text-muted">Tidak ada data.</td></tr>'
    );
 
    // Scope stokMenipis()
    $barisMenipis = '';
    foreach ($bukuMenipis as $i => $b) {
        $barisMenipis .= "<tr>
            <td>" . ($i + 1) . "</td>
            <td>{$b->judul}</td>
            <td class='text-center'>{$b->stok}</td>
            <td>{$b->status_stok_badge}</td>
        </tr>";
    }
    $tableBukuMenipis = $tabel(
        'Scope <code>stokMenipis()</code> — Stok &lt; 5',
        '<tr><th>#</th><th>Judul</th><th>Stok</th><th>Status</th></tr>',
        $barisMenipis ?: '<tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>'
    );
 
    // Scope hargaRange(50000, 150000)
    $barisRange = '';
    foreach ($bukuRangeHarga as $i => $b) {
        $barisRange .= "<tr>
            <td>" . ($i + 1) . "</td>
            <td>{$b->judul}</td>
            <td>Rp " . number_format($b->harga, 0, ',', '.') . "</td>
        </tr>";
    }
    $tableBukuRange = $tabel(
        'Scope <code>hargaRange(50000, 150000)</code>',
        '<tr><th>#</th><th>Judul</th><th>Harga</th></tr>',
        $barisRange ?: '<tr><td colspan="3" class="text-center text-muted">Tidak ada data.</td></tr>'
    );
 
   
    // MODEL ANGGOTA
 
    // Semua Anggota + status_badge + kategori_usia (accessor)
    $headerAnggota = '<tr>
        <th>#</th><th>Nama</th><th>Jenis Kelamin</th>
        <th>Tgl Lahir</th><th>Kategori Usia</th>
        <th>Status</th><th>Status Badge</th>
    </tr>';
 
    $barisAnggota = '';
    foreach ($semuaAnggota as $i => $a) {
        $jk      = $a->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
        $tglLahir = $a->tanggal_lahir ? $a->tanggal_lahir->format('d M Y') : '-';
        $barisAnggota .= "<tr>
            <td>" . ($i + 1) . "</td>
            <td>{$a->nama}</td>
            <td>{$jk}</td>
            <td>{$tglLahir}</td>
            <td><strong>{$a->kategori_usia}</strong></td>
            <td>{$a->status}</td>
            <td>{$a->status_badge}</td>
        </tr>";
    }
    $tableAnggotaSemua = $tabel(
        'Semua Anggota — Accessor <code>status_badge</code> &amp; <code>kategori_usia</code>',
        $headerAnggota,
        $barisAnggota ?: '<tr><td colspan="7" class="text-center text-muted">Tidak ada data.</td></tr>'
    );
 
    // Scope terdaftarBulanIni()
    $barisBulanIni = '';
    foreach ($anggotaBulanIni as $i => $a) {
        $terdaftar = $a->terdaftar_at
            ? $a->terdaftar_at->format('d M Y H:i')
            : $a->created_at->format('d M Y H:i');
        $barisBulanIni .= "<tr>
            <td>" . ($i + 1) . "</td>
            <td>{$a->nama}</td>
            <td>{$terdaftar}</td>
            <td>{$a->status_badge}</td>
        </tr>";
    }
    $tableAnggotaBulanIni = $tabel(
        'Scope <code>terdaftarBulanIni()</code> — Daftar Bulan Ini',
        '<tr><th>#</th><th>Nama</th><th>Terdaftar Pada</th><th>Status</th></tr>',
        $barisBulanIni ?: '<tr><td colspan="4" class="text-center text-muted">Belum ada anggota baru bulan ini.</td></tr>'
    );
 
    // Scope jenisKelamin()
    $barisLaki = '';
    foreach ($anggotaLaki as $i => $a) {
        $barisLaki .= "<tr>
            <td>" . ($i + 1) . "</td>
            <td>{$a->nama}</td>
            <td>{$a->kategori_usia}</td>
            <td>{$a->status_badge}</td>
        </tr>";
    }
    $barisPerempuan = '';
    foreach ($anggotaPerempuan as $i => $a) {
        $barisPerempuan .= "<tr>
            <td>" . ($i + 1) . "</td>
            <td>{$a->nama}</td>
            <td>{$a->kategori_usia}</td>
            <td>{$a->status_badge}</td>
        </tr>";
    }
    $colHeader = '<tr><th>#</th><th>Nama</th><th>Kategori Usia</th><th>Status</th></tr>';
    $tableAnggotaLaki = $tabel(
        'Scope <code>jenisKelamin(\'L\')</code>',
        $colHeader,
        $barisLaki ?: '<tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>'
    );
    $tableAnggotaPerempuan = $tabel(
        'Scope <code>jenisKelamin(\'P\')</code>',
        $colHeader,
        $barisPerempuan ?: '<tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>'
    );
 
  
    // Ringkasan Statistik
    $totalBuku     = $semuaBuku->count();
    $totalAnggota  = $semuaAnggota->count();
    $jumlahTerbaru = $bukuTerbaru->count();
    $jumlahMenipis = $bukuMenipis->count();
    $jumlahBulanIni = $anggotaBulanIni->count();
 
    $cardStats = <<<HTML
        <div class="row g-3 mb-5">
            <div class="col-6 col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body py-3">
                        <div class="fs-2 fw-bold text-primary">{$totalBuku}</div>
                        <div class="text-muted small">Total Buku</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body py-3">
                        <div class="fs-2 fw-bold text-success">{$jumlahTerbaru}</div>
                        <div class="text-muted small">Buku Terbaru (≥2024)</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body py-3">
                        <div class="fs-2 fw-bold text-warning">{$jumlahMenipis}</div>
                        <div class="text-muted small">Stok Menipis</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body py-3">
                        <div class="fs-2 fw-bold text-info">{$totalAnggota}</div>
                        <div class="text-muted small">Total Anggota</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body py-3">
                        <div class="fs-2 fw-bold text-danger">{$jumlahBulanIni}</div>
                        <div class="text-muted small">Daftar Bulan Ini</div>
                    </div>
                </div>
            </div>
        </div>
    HTML;
 
    // Render HTML Akhir
    return <<<HTML
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Testing Accessor & Scope</title>
            <link rel="stylesheet"
                  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
            <style>
                body        { background: #f8f9fa; }
                .page-wrap  { max-width: 1100px; margin: 0 auto; padding: 2rem 1rem; }
                .page-title { font-weight: 700; border-bottom: 3px solid #0d6efd; padding-bottom: .5rem; margin-bottom: 2rem; }
                .section-title { font-weight: 600; margin-bottom: .75rem; }
                .section-title code { background: #e9ecef; padding: .15rem .4rem; border-radius: .25rem; }
                .table-wrapper { overflow-x: auto; border-radius: .5rem; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
            </style>
        </head>
        <body>
        <div class="page-wrap">
            <h1 class="page-title">Testing Accessor &amp; Scope</h1>
            <p class="text-muted mb-4">Model Buku &amp; Anggota | Laravel Eloquent</p>
 
            {$cardStats}
 
            <h3 class="mb-3 mt-4 text-primary">Model Buku</h3>
            {$tableBukuSemua}
            {$tableBukuTerbaru}
            {$tableBukuMenipis}
            {$tableBukuRange}
 
            <h3 class="mb-3 mt-4 text-success">Model Anggota</h3>
            {$tableAnggotaSemua}
            {$tableAnggotaBulanIni}
            {$tableAnggotaLaki}
            {$tableAnggotaPerempuan}
        </div>
        </body>
        </html>
    HTML;
});