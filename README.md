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
<img width="1510" height="747" alt="image" src="https://github.com/user-attachments/assets/0ba66a05-62a1-4440-9608-e501cf8d831c" />
<img width="1386" height="662" alt="image" src="https://github.com/user-attachments/assets/814f53b7-155a-45ff-82e6-85cd5f2d6371" />

