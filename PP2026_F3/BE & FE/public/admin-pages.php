<?php
$adminPages = [
    'admin-monitor' => ['monitor', 'Monitor', 'Monitoring Langsung'],
    'admin-rekap' => ['recap', 'Rekap Absensi', 'Rekap Pegawai'],
    'admin-keterlambatan' => ['lateness', 'Verifikasi Karyawan', 'Pusat Verifikasi Terlambat'],
    'admin-log-kedatangan' => ['logs', 'Detail Log Kedatangan', 'Detail Log Kedatangan'],
];
[$adminPage, $adminTitle, $adminHeading] = $adminPages[$attendancePage];
$activeNav = $adminPage === 'logs' ? 'monitor' : $adminPage;

function admin_nav_item(string $page, string $label, string $icon, string $activeNav): void
{
    $active = $page === $activeNav;
    $icons = [
        'monitor' => '<rect x="4" y="4" width="6" height="6"/><rect x="14" y="4" width="6" height="6"/><rect x="4" y="14" width="6" height="6"/><rect x="14" y="14" width="6" height="6"/>',
        'recap' => '<path d="M4 19V5m0 14h16M8 15v-3m4 3V8m4 7v-5"/>',
        'approval' => '<path d="M4 6h10M4 12h7m-7 6h5m4-7 3 3 5-6"/>',
        'lateness' => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8m-8 5h8m-8 5h4"/>',
    ];
    $hrefs = [
        'monitor' => '?page=admin-monitor',
        'recap' => '?page=admin-rekap',
        'approval' => '?page=admin-lembur',
        'lateness' => '?page=admin-keterlambatan',
    ];
    ?>
    <a href="<?= $hrefs[$icon] ?>" class="<?= $active ? 'active' : '' ?>"<?= $active ? ' aria-current="page"' : '' ?>>
        <svg viewBox="0 0 24 24" aria-hidden="true"><?= $icons[$icon] ?></svg><span><?= $label ?></span>
    </a>
    <?php
}

function admin_export_modal(): void
{
    ?>
    <div class="admin-modal-backdrop" id="admin-export-modal" hidden>
        <section class="admin-export-modal" role="dialog" aria-modal="true" aria-labelledby="admin-export-title">
            <header class="admin-export-heading">
                <span class="admin-export-file" aria-hidden="true">PDF</span>
                <div><h2 id="admin-export-title">Ekspor Rekapitulasi Presensi</h2><p>● Format Dokumen Resmi (.PDF)</p></div>
                <button class="admin-modal-close" type="button" aria-label="Tutup">×</button>
            </header>
            <fieldset class="admin-export-period">
                <legend>Periode Laporan</legend>
                <div class="admin-export-period-tabs">
                    <button type="button" class="active" data-export-period="current">Bulan Ini</button>
                    <button type="button" data-export-period="previous">Bulan Lalu</button>
                    <button type="button" data-export-period="custom">Kustom</button>
                </div>
                <div class="admin-export-dates" id="admin-export-dates">01 Okt 2026 - 31 Okt 2026 <span>31 Hari Kerja</span></div>
                <div class="admin-custom-dates" id="admin-custom-dates" hidden>
                    <label class="admin-field">Dari tanggal<input type="date" id="admin-export-start"></label>
                    <label class="admin-field">Sampai tanggal<input type="date" id="admin-export-end"></label>
                </div>
            </fieldset>
            <div class="admin-export-components-title"><strong>Komponen Data yang Disertakan</strong><button type="button" id="admin-export-toggle-all">Pilih Semua</button></div>
            <div class="admin-export-checklist">
                <label><input type="checkbox" checked data-export-component><span><strong>Ringkasan Kehadiran &amp; Persentase</strong><small>Hadir tepat waktu, terlambat, alpa &amp; cuti</small></span><em>Wajib</em></label>
                <label><input type="checkbox" checked data-export-component><span><strong>Detail Keterlambatan &amp; Alasan</strong><small>Log waktu menit keterlambatan &amp; approval</small></span><em>Aktif</em></label>
                <label><input type="checkbox" checked data-export-component><span><strong>Akumulasi Lembur &amp; Kalkulasi SPL</strong><small>Total jam lembur &amp; verifikasi atasan</small></span><em>Aktif</em></label>
            </div>
            <div class="admin-export-preview">
                <span class="admin-export-doc" aria-hidden="true">▤</span>
                <span><strong id="admin-export-filename">Rekap_Presensi_Oktober_2026.pdf</strong><small>Estimasi Ukuran: ~1.4 MB (6 Halaman)</small></span>
                <b aria-label="Siap dicetak">✓</b>
                <small class="admin-export-ready">◎ Siap Cetak PDF</small>
            </div>
            <button class="admin-export-submit" id="admin-export-submit" type="button">⇩ &nbsp;Unduh PDF Sekarang</button>
        </section>
    </div>
    <?php
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($adminTitle, ENT_QUOTES, 'UTF-8') ?> · Admin</title>
    <link rel="stylesheet" href="admin-workspace.css?v=3">
</head>
<body class="admin-workspace admin-insights" data-admin-page="<?= $adminPage ?>">
    <main class="admin-shell admin-insights-shell">
        <?php if ($adminPage === 'logs') { ?>
            <header class="admin-log-header">
                <a href="?page=admin-monitor" aria-label="Kembali ke Monitor">‹</a>
                <div><h1><?= $adminHeading ?></h1></div>
            </header>
            <div class="admin-log-toolbar"><span>◷ Hari ini, 19 Okt 2026 • 08:52 WIB</span><button class="admin-soft-button" id="admin-log-refresh" type="button" aria-label="Muat ulang">↻</button><button class="admin-export-open" type="button" data-open-export>⇩ Ekspor</button></div>
            <section class="admin-log-stats">
                <article><small>Total Tapping</small><strong>240 <span>karyawan</span></strong><p>98% Gate • 2% Geofence</p></article>
                <article><small>Tepat Waktu <b>✓</b></small><strong class="admin-text-green">231 <span>96.2%</span></strong><p class="admin-text-red">● Terlambat: 9 (3.8%)</p></article>
            </section>
            <label class="admin-search"><span aria-hidden="true">⌕</span><input id="admin-log-search" type="search" placeholder="Cari nama, NIP, divisi, atau gate scanner..."></label>
            <nav class="admin-pill-tabs" aria-label="Filter log">
                <button class="active" type="button" data-log-filter="all">Semua (240)</button><button type="button" data-log-filter="ontime">Tepat Waktu (231)</button><button type="button" data-log-filter="late">Terlambat (9)</button>
            </nav>
            <div class="admin-list-title"><h2>Aliran Presensi Masuk</h2><span>● Urutkan: Terkini</span></div>
            <section class="admin-log-list" id="admin-log-list">
                <article class="admin-log-card" data-name="annisa larasati 1092 backend tech lead it engineering barcode scanner lobi hq" data-log-status="ontime">
                    <div class="admin-log-person"><span class="admin-face">AL</span><div><h3>Annisa Larasati <small>#IT-1092</small></h3><p>Backend Tech Lead • IT &amp; Engineering</p></div><span class="admin-status-pill ontime">✓ Tepat Waktu</span></div>
                    <div class="admin-log-details"><span><small>Waktu Scan</small><strong>08:24:12 <i>WIB</i></strong></span><span><small>Jadwal Shift</small><strong>08:30 - 17:30 (Pagi)</strong></span></div>
                    <footer>◉ Radius: 4m (Akurat)　 IP: 192.168.10.42　 iOS HadirKu App</footer>
                </article>
                <article class="admin-log-card" data-name="debay s t pd 3042 senior ui ux designer produk digital mobile checkin wifi" data-log-status="ontime">
                    <div class="admin-log-person"><span class="admin-face face-blue">DS</span><div><h3>Debay S.T. <small>#PD-3042</small></h3><p>Senior UI/UX Designer • Produk Digital</p></div><span class="admin-status-pill ontime">✓ Tepat Waktu</span></div>
                    <div class="admin-log-details"><span><small>Waktu Scan</small><strong>08:28:40 <i>WIB</i></strong></span><span><small>Face Match AI</small><strong class="admin-text-green">◉ 99.1% Valid</strong></span></div>
                    <footer>◉ Radius: 12m　 Office Gateway 02　 Android App v4.2</footer>
                </article>
                <article class="admin-log-card" data-name="rizky firmansyah bk 5521 growth marketing bisnis komersial gate p1 basement" data-log-status="late">
                    <div class="admin-log-person"><span class="admin-face face-warm">RF</span><div><h3>Rizky Firmansyah <small>#BK-5521</small></h3><p>Growth Marketing • Bisnis &amp; Komersial</p></div><span class="admin-status-pill late">⚠ Terlambat +14m</span></div>
                    <div class="admin-log-details"><span><small>Waktu Scan</small><strong class="admin-text-red">08:44:05 <i>WIB</i></strong></span><span><small>Batas Masuk Shift</small><strong>08:30:00 WIB</strong></span></div>
                    <footer>▣ Gate P1 Basement　 Jarak: 8m ke Terminal　 Office-WiFi-B1</footer>
                </article>
                <article class="admin-log-card" data-name="bambang triantoro ops 8812 site supervisor operasional lapangan gudang cikarang barat" data-log-status="ontime">
                    <div class="admin-log-person"><span class="admin-face face-warm">BT</span><div><h3>Bambang Triantoro <small>#OPS-8812</small></h3><p>Site Supervisor • Operasional Lapangan</p></div><span class="admin-status-pill ontime">✓ Tepat Waktu</span></div>
                    <div class="admin-log-details"><span><small>Waktu Scan</small><strong>07:55:18 <i>WIB</i></strong></span><span><small>Lokasi Geofence</small><strong>Gudang Cikarang Barat</strong></span></div>
                    <footer>◉ Geofence Mobile GPS (Akurasi 6m)</footer>
                </article>
                <article class="admin-log-card" data-name="citra santoso hr 4190 talent acquisition human resources macet tol slipi" data-log-status="late">
                    <div class="admin-log-person"><span class="admin-face face-pink">CS</span><div><h3>Citra Santoso <small>#HR-4190</small></h3><p>Talent Acquisition • Human Resources</p></div><span class="admin-status-pill late">⚠ Terlambat +18m</span></div>
                    <div class="admin-log-details"><span><small>Waktu Scan</small><strong class="admin-text-red">08:48:22 <i>WIB</i></strong></span><span><small>Alasan Terlambat</small><strong>Macet Tol Slipi</strong></span></div>
                    <footer>▣ Barcode Scanner Lobi Gate 1　 Radius: 2.1m　 IP: 192.168.10.88</footer>
                </article>
                <article class="admin-log-card" data-name="nathalia claudia cr 7201 client relations pemasaran geofence cabang thamrin" data-log-status="ontime">
                    <div class="admin-log-person"><span class="admin-face face-pink">NC</span><div><h3>Nathalia Claudia <small>#CR-7201</small></h3><p>Client Relations • Pemasaran</p></div><span class="admin-status-pill ontime">✓ Tepat Waktu</span></div>
                    <div class="admin-log-details"><span><small>Waktu Scan</small><strong>08:41:09 <i>WIB</i></strong></span><span><small>Shift Kerja</small><strong>Fleksibel / Kemitraan</strong></span></div>
                    <footer>▦ Geofence Cabang Thamrin (Tower B, Lantai 12)</footer>
                </article>
            </section>
            <p class="admin-empty" id="admin-log-empty" hidden>Tidak ada log yang cocok dengan pencarian.</p>
            <p class="admin-log-count">● Menampilkan <strong id="admin-log-visible">6</strong> dari 240 catatan kedatangan</p>
            <button class="admin-load-more" id="admin-log-more" type="button">◴ &nbsp;Muat Log Sebelumnya</button>
        <?php } elseif ($adminPage === 'lateness') { ?>
            <header class="admin-header"><div><span class="admin-chip">ADMIN</span><h1><?= $adminHeading ?></h1></div><a href="?page=admin-kalender" class="admin-avatar" aria-label="Kelola kalender libur">A</a></header>
            <section class="admin-verification-summary">
                <h2>▣ Pusat Verifikasi Terlambat <span>●</span></h2>
                <div><article><small>◷ Review</small><strong id="admin-late-pending-count">14</strong><span>Menunggu</span></article><article><small class="admin-text-green">◉ Diterima</small><strong>28</strong><span>Toleransi</span></article><article><small class="admin-text-blue">▦ Sync</small><strong>99.2%</strong><span>QR Valid</span></article></div>
            </section>
            <div class="admin-category-heading"><strong>KATEGORI ALASAN</strong><span>Batas Review: 24 Jam</span></div>
            <nav class="admin-pill-tabs admin-reason-tabs" aria-label="Kategori alasan">
                <button class="active" type="button" data-reason-filter="all">Semua <b>14</b></button><button type="button" data-reason-filter="traffic">Macet Lalu Lintas <b>8</b></button><button type="button" data-reason-filter="vehicle">Kendala Kendaraan <b>4</b></button><button type="button" data-reason-filter="other">Lainnya <b>2</b></button>
            </nav>
            <div class="admin-list-title"><h2>Klarifikasi Menunggu Keputusan</h2><span>Realtime Stream</span></div>
            <section class="admin-lateness-list">
                <article class="admin-lateness-card" data-reason="traffic" data-decision-id="late-001">
                    <div class="admin-lateness-person"><span class="admin-face face-warm">DS</span><div><h3>Debay, S.T.</h3><p>Senior UI/UX Designer</p></div><strong class="admin-delay">◴ +18 Menit</strong></div>
                    <div class="admin-reason-meta"><span>▣ Jadwal: 08:30 WIB</span><strong>▦ Presensi: 08:48:22 WIB</strong><p><b>Macet Lalu Lintas</b>　 Via QR Pos Gerbang Barat</p></div>
                    <small class="admin-reason-label">ALASAN KARYAWAN:</small><blockquote>"Kendala kemacetan parah di perempatan Jl. Setiabudi imbas perbaikan gorong-gorong PDAM."</blockquote>
                    <div class="admin-lateness-actions"><button class="admin-late-reject" type="button">× Catat Terlambat</button><button class="admin-late-accept" type="button">✓ Beri Toleransi</button></div>
                </article>
                <article class="admin-lateness-card" data-reason="vehicle" data-decision-id="late-002">
                    <div class="admin-lateness-person"><span class="admin-face face-pink">SN</span><div><h3>Siti Nurbaliza, S.E.</h3><p>Keuangan &amp; Akuntansi</p></div><strong class="admin-delay">◴ +32 Menit</strong></div>
                    <div class="admin-reason-meta"><span>▣ Jadwal: 08:30 WIB</span><strong>▦ Presensi: 09:02:14 WIB</strong><p><b>Kendala Kendaraan</b>　 Lobi Menara Utama Lt.1</p></div>
                    <small class="admin-reason-label">ALASAN KARYAWAN:</small><blockquote>"Ban motor kempes di jalan layang Casablanca. Harus mendorong mencari bengkel."</blockquote>
                    <div class="admin-lateness-actions"><button class="admin-late-reject" type="button">× Catat Terlambat</button><button class="admin-late-accept" type="button">✓ Beri Toleransi</button></div>
                </article>
            </section>
            <p class="admin-empty" id="admin-late-empty" hidden>Tidak ada klarifikasi pada kategori ini.</p>
        <?php } elseif ($adminPage === 'recap') { ?>
            <header class="admin-header"><div><span class="admin-chip">ADMIN</span><h1>Rekap Absensi</h1></div><a href="?page=admin-kalender" class="admin-avatar" aria-label="Kelola kalender libur">A</a></header>
            <nav class="admin-period-tabs" aria-label="Periode rekap"><button type="button" data-recap-period="weekly">Mingguan</button><button class="active" type="button" data-recap-period="monthly">Bulanan</button><button type="button" data-recap-period="yearly">Tahunan</button></nav>
            <label class="admin-month-picker"><span>▦</span><select id="admin-recap-month" aria-label="Pilih bulan"><option value="2026-10">Oktober 2026</option><option value="2026-09">September 2026</option><option value="2026-08">Agustus 2026</option></select></label>
            <section class="admin-recap-metrics"><article><span>✓ <b>+1.2%</b></span><strong>96.4%</strong><small>Rata Kehadiran</small></article><article><span>◷</span><strong>342 Jam</strong><small>Total Lembur</small></article><article><span>◴ <b>-4x</b></span><strong>48 Insiden</strong><small>Keterlambatan</small></article></section>
            <div class="admin-list-title"><h2>Rekap Pegawai <span class="admin-employee-count">3 Karyawan</span></h2></div>
            <label class="admin-search"><span aria-hidden="true">⌕</span><input id="admin-employee-search" type="search" placeholder="Cari nama, NIP, posisi..."></label>
            <section class="admin-employee-list" id="admin-employee-list">
                <article class="admin-employee-card" data-employee-name="bayu pratama s kom divisi teknologi nip 882019">
                    <div class="admin-employee-heading"><span class="admin-face face-warm">BP</span><div><h3>Bayu Pratama, S.Kom</h3><p>Divisi Teknologi • NIP 882019</p></div></div>
                    <div class="admin-employee-metrics"><span>Hadir<strong>22 Hari</strong></span><span>Terlambat<strong>12 mnt</strong></span><span>Lembur<strong>18.5 Jam</strong></span><span>Persentase<strong class="admin-text-green">98.5%</strong></span></div>
                </article>
                <article class="admin-employee-card" data-employee-name="sarah nadhira m ds divisi produk nip 882044">
                    <div class="admin-employee-heading"><span class="admin-face face-pink">SN</span><div><h3>Sarah Nadhira, M.Ds</h3><p>Divisi Produk • NIP 882044</p></div></div>
                    <div class="admin-employee-metrics"><span>Hadir<strong>19 Hari</strong></span><span>Terlambat<strong class="admin-text-red">65 mnt</strong><small>(3x)</small></span><span>Lembur<strong>6.0 Jam</strong></span><span>Izin/Sakit<strong class="admin-text-amber">2 Hari</strong></span></div>
                </article>
                <article class="admin-employee-card" data-employee-name="hendra gunawan s e divisi keuangan nip 882005">
                    <div class="admin-employee-heading"><span class="admin-face face-blue">HG</span><div><h3>Hendra Gunawan, S.E.</h3><p>Divisi Keuangan • NIP 882005</p></div></div>
                    <div class="admin-employee-metrics"><span>Hadir<strong>22 Hari</strong></span><span>Terlambat<strong class="admin-text-green">0 mnt</strong></span><span>Lembur<strong>24.0 Jam</strong></span><span>Persentase<strong class="admin-text-green">100%</strong></span></div>
                </article>
            </section>
            <p class="admin-empty" id="admin-employee-empty" hidden>Karyawan tidak ditemukan.</p>
            <div class="admin-fixed-action"><button class="admin-report-download" type="button" data-open-export>⇩ &nbsp;Unduh Laporan (PDF)</button></div>
        <?php } else { ?>
            <header class="admin-header"><div><span class="admin-chip">ADMIN</span><h1>Monitor</h1></div><a href="?page=admin-kalender" class="admin-avatar" aria-label="Kelola kalender libur">A</a></header>
            <section class="admin-live-shift"><div><span>● MONITORING LANGSUNG</span><h2>Shift Pagi Operasional</h2><p>Gate HQ &amp; Cabang Thamrin Aktif</p></div><div><time id="admin-live-clock">17:59:15 WIB</time><strong>96.8%</strong><small>Kapasitas Hari Ini</small></div></section>
            <section class="admin-monitor-metrics"><article><small>Karyawan Aktif</small><strong>248 <span>orang</span></strong><em>↑ 100% terjadwal</em></article><article><small>Tepat Waktu <b>✓</b></small><strong>231 <span>orang</span></strong><em class="admin-compliance">93.1% Kepatuhan</em></article><article><small>Terlambat <b>◴</b></small><strong>9 <span>orang</span></strong><em class="admin-text-amber">⚠ Perlu tinjauan</em></article><article><small>Lembur <b>▣</b></small><strong>8 <span>orang</span></strong></article></section>
            <section class="admin-quick-review"><div class="admin-list-title"><h2>● Tinjauan Cepat Keterlambatan</h2><span>Antrean 1/4</span></div><div class="admin-quick-person"><span class="admin-face face-warm">BT</span><div><h3>Bambang Triantoro</h3><p>Site Supervisor • Shift Pagi</p></div><strong>+52m</strong></div><blockquote>Alasan: "Kendala lain mogok MRT Lebak Bulus, menyertakan bukti foto tiket transit."</blockquote><div class="admin-lateness-actions"><button class="admin-late-reject" type="button" data-quick-decision="rejected">× Tolak</button><button class="admin-late-accept" type="button" data-quick-decision="approved">◉ Toleransi</button></div></section>
            <div class="admin-list-title"><h2>Log Kedatangan Terkini</h2><a href="?page=admin-log-kedatangan">Lihat Semua ›</a></div>
            <section class="admin-recent-logs">
                <article><span class="admin-face face-pink">AL</span><div><h3>Annisa Larasati</h3><p>▦ Barcode Scanner Lobi HQ</p><small>Radius: 4 meter (Akurat)</small></div><span><strong>08:24 WIB</strong><em class="admin-status-pill ontime">Tepat Waktu</em></span></article>
                <article><span class="admin-face face-blue">DS</span><div><h3>Debay S.T.</h3><p>◉ Valid IP/Radius 12m</p><small>Mobile Check-in (Wifi HQ)</small></div><span><strong>08:28 WIB</strong><em class="admin-status-pill ontime">Tepat Waktu</em></span></article>
                <article><span class="admin-face face-warm">RF</span><div><h3>Rizky Firmansyah</h3><p>▦ Barcode Scanner Lobi HQ</p><small>Batas: 08:00 WIB</small></div><span><strong>08:44 WIB</strong><em class="admin-status-pill late">Terlambat +44m</em></span></article>
                <article><span class="admin-face face-pink">NC</span><div><h3>Nathalia Claudia</h3><p>◉ Geofence Cabang Thamrin</p><small>Face Match: 99.4%</small></div><span><strong>08:41 WIB</strong><em class="admin-status-pill ontime">Tepat Waktu</em></span></article>
            </section>
            <div class="admin-sync-card"><span>☁</span><div><strong>Server Sync: Sinkron</strong><p>Terakhir diperbarui 2 detik lalu</p></div><button type="button" id="admin-sync-refresh" aria-label="Segarkan sinkronisasi">↻</button></div>
        <?php } ?>
    </main>
    <nav class="admin-bottom-nav admin-four-nav" aria-label="Navigasi Admin">
        <?php
        admin_nav_item('monitor', 'Monitor', 'monitor', $activeNav);
        admin_nav_item('recap', 'Rekap', 'recap', $activeNav);
        admin_nav_item('overtime', 'Approval Lembur', 'approval', $activeNav);
        admin_nav_item('lateness', 'Keterlambatan', 'lateness', $activeNav);
        ?>
    </nav>
    <?php admin_export_modal(); ?>
    <script src="admin-workspace.js?v=3"></script>
    <script src="admin-insights.js?v=1"></script>
</body>
</html>
<?php
exit;
