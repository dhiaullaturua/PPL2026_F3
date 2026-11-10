<?php
$attendancePage = $_GET['page'] ?? '';

if (in_array($attendancePage, ['admin-monitor', 'admin-rekap', 'admin-keterlambatan', 'admin-log-kedatangan'], true)) {
    require __DIR__ . '/admin-pages.php';
}

if (in_array($attendancePage, ['admin-lembur', 'admin-kalender'], true)) {
    $isAdminCalendar = $attendancePage === 'admin-kalender';
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $isAdminCalendar ? 'Kalender Hari Libur' : 'Approval Lembur (SPL)' ?></title>
    <link rel="stylesheet" href="admin-workspace.css?v=2">
</head>
<body class="admin-workspace" data-admin-page="<?= $isAdminCalendar ? 'calendar' : 'overtime' ?>">
    <main class="admin-shell">
        <header class="admin-header">
            <div>
                <span class="admin-chip">ADMIN</span>
                <h1><?= $isAdminCalendar ? 'Kalender Hari Libur' : 'Approval Lembur (SPL)' ?></h1>
            </div>
            <div class="admin-header-links">
                <a href="?page=admin-monitor">Monitor</a>
                <a href="<?= $isAdminCalendar ? '?page=admin-lembur' : '?page=admin-kalender' ?>"><?= $isAdminCalendar ? 'Approval Lembur' : 'Kalender Libur' ?></a>
                <span class="admin-avatar" aria-label="Profil Admin">A</span>
            </div>
        </header>

        <?php if ($isAdminCalendar) { ?>
            <p class="admin-notice" id="admin-calendar-notice" role="status" aria-live="polite"></p>
            <form class="admin-calendar-form" id="admin-work-schedule-form">
                <h2>Atur Jadwal Kerja</h2>
                <p>Jadwal yang disimpan akan ditampilkan pada kalender karyawan di perangkat ini.</p>
                <div class="admin-time-grid">
                    <label class="admin-field" for="admin-work-start">Masuk kerja
                        <input id="admin-work-start" type="time" value="07:00" required>
                    </label>
                    <label class="admin-field" for="admin-work-end">Selesai kerja
                        <input id="admin-work-end" type="time" value="17:00" required>
                    </label>
                    <label class="admin-field" for="admin-break-start">Mulai istirahat
                        <input id="admin-break-start" type="time" value="12:00" required>
                    </label>
                    <label class="admin-field" for="admin-break-end">Selesai istirahat
                        <input id="admin-break-end" type="time" value="13:00" required>
                    </label>
                </div>
                <button class="admin-save-button" type="submit">Simpan Jadwal</button>
            </form>
            <form class="admin-calendar-form" id="admin-holiday-form">
                <h2>Tentukan Hari Libur</h2>
                <p>Tanggal dan keterangan libur yang ditentukan Admin akan muncul pada kalender karyawan.</p>
                <label class="admin-field" for="admin-creator-role">Diinput oleh
                    <select id="admin-creator-role">
                        <option value="COO">COO</option>
                        <option value="Staf Admin" selected>Staf Admin</option>
                    </select>
                </label>
                <label class="admin-field" for="admin-holiday-date">Tanggal libur
                    <input id="admin-holiday-date" type="date" required>
                </label>
                <label class="admin-field" for="admin-holiday-name">Keterangan hari libur
                    <input id="admin-holiday-name" type="text" maxlength="100" placeholder="Contoh: Libur Nasional / Cuti Bersama" required>
                </label>
                <button class="admin-save-button" type="submit">Simpan Hari Libur</button>
            </form>
            <section class="admin-holiday-list">
                <h2>Daftar Hari Libur</h2>
                <div id="admin-holiday-list"></div>
                <p class="admin-empty" id="admin-holiday-empty">Belum ada hari libur yang diinput.</p>
            </section>
        <?php } else { ?>
            <nav class="admin-tabs" aria-label="Status pengajuan lembur">
                <button class="admin-tab active" type="button" data-status="pending">Menunggu <span class="admin-tab-count">14</span></button>
                <button class="admin-tab" type="button" data-status="approved">Disetujui <span class="admin-tab-count">8</span></button>
                <button class="admin-tab" type="button" data-status="rejected">Ditolak <span class="admin-tab-count">2</span></button>
            </nav>
            <div class="admin-bulkbar">
                <label class="admin-check-control">
                    <input id="admin-select-all" type="checkbox">
                    <span>Pilih Semua<small id="admin-selected-count">0 dipilih</small></span>
                </label>
                <div>
                    <button class="admin-primary-button" id="admin-approve-selected" type="button" disabled>✓ Setujui Terpilih</button>
                </div>
            </div>
            <p class="admin-notice" id="admin-overtime-notice" role="status" aria-live="polite"></p>
            <section id="admin-overtime-list" aria-label="Daftar pengajuan lembur">
                <article class="admin-overtime-card" data-request-id="spl-001" data-status="pending">
                    <div class="admin-card-heading">
                        <input class="admin-card-check" type="checkbox" aria-label="Pilih pengajuan Bambang Tria">
                        <span class="admin-person-photo" aria-hidden="true">BT</span>
                        <div class="admin-person-name">Bambang Tria<span class="admin-person-role">Site Supervisor · C</span><span class="admin-overtime-type">◷ SPL Lembur · Hari Kerja</span></div>
                    </div>
                    <div class="admin-job-details">
                        <div class="admin-job-date"><span>▣ Kamis, 24 Okt 2024</span><span class="admin-hours">3.5 Jam</span></div>
                        <div class="admin-job-time"><span>◷ 17:30 - 21:00 WIB　(Kompensasi: 1.5x - 2.0x Upah Jam)</span></div>
                        <p class="admin-task">Tugas: “Penyelesaian inspeksi gate scanner &amp; pengelasan struktur rangka lobi timur sebelum audit esok hari.”</p>
                    </div>
                    <div class="admin-supervisor"><span>Supervisor: <strong>Agus Pratama (Manajer Lapangan)</strong></span><span class="admin-verified">◉ Terverifikasi SPL</span></div>
                    <div class="admin-card-actions">
                        <button class="admin-reject-button" type="button">Tolak Lembur</button>
                        <button class="admin-approve-button" type="button">✓ Setujui Lembur</button>
                    </div>
                </article>
                <article class="admin-overtime-card" data-request-id="spl-002" data-status="pending">
                    <div class="admin-card-heading">
                        <input class="admin-card-check" type="checkbox" aria-label="Pilih pengajuan Annisa">
                        <span class="admin-person-photo" aria-hidden="true">AN</span>
                        <div class="admin-person-name">Annisa<span class="admin-person-role">Backend</span><span class="admin-overtime-type urgent">ϟ SPL Lembur · Urgent Maintenance</span></div>
                    </div>
                    <div class="admin-job-details">
                        <div class="admin-job-date"><span>▣ Jumat, 25 Okt 2024</span><span class="admin-hours">4.0 Jam</span></div>
                        <div class="admin-job-time"><span>◷ 18:00 - 22:00 WIB　(Kompensasi: Flat 2.0x Upah Lembur)</span></div>
                        <p class="admin-task">Tugas: “Migrasi database server presensi kantor pusat dan integrasi webhook log scanner lobi.”</p>
                    </div>
                    <div class="admin-supervisor"><span>Supervisor: <strong>Rudi Hartono (VP Engineering)</strong></span><span class="admin-verified">◉ Terverifikasi SPL</span></div>
                    <div class="admin-card-actions">
                        <button class="admin-reject-button" type="button">Tolak Lembur</button>
                        <button class="admin-approve-button" type="button">✓ Setujui Lembur</button>
                    </div>
                </article>
            </section>
            <p class="admin-empty" id="admin-overtime-empty" hidden>Tidak ada pengajuan pada status ini.</p>
        <?php } ?>
    </main>
    <nav class="admin-bottom-nav admin-four-nav" aria-label="Navigasi Admin">
        <a href="?page=admin-monitor"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="6" height="6"/><rect x="14" y="4" width="6" height="6"/><rect x="4" y="14" width="6" height="6"/><rect x="14" y="14" width="6" height="6"/></svg><span>Monitor</span></a>
        <a href="?page=admin-rekap"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19V5m0 14h16M8 15v-3m4 3V8m4 7v-5"/></svg><span>Rekap</span></a>
        <a href="?page=admin-lembur" class="<?= !$isAdminCalendar ? 'active' : '' ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h10M4 12h7m-7 6h5m4-7 3 3 5-6"/></svg><span>Approval Lembur</span></a>
        <a href="?page=admin-keterlambatan"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8m-8 5h8m-8 5h4"/></svg><span>Keterlambatan</span></a>
    </nav>
    <script src="admin-workspace.js?v=2"></script>
</body>
</html>
<?php
    exit;
}

if ($attendancePage === 'pengumuman-jadwal') {
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pengumuman</title>
    <link rel="stylesheet" href="announcement.css?v=2">
</head>
<body class="announcement-page">
    <main class="announcement-shell">
        <header class="announcement-header">
            <a class="announcement-back" href="?page=notifikasi" aria-label="Kembali ke notifikasi">‹</a>
            <h1>Detail Pengumuman</h1>
            <a class="announcement-avatar" href="?page=profil" aria-label="Profil">D</a>
        </header>

        <div class="announcement-breadcrumb">
            <a href="?page=notifikasi">♧ Pusat Pemberitahuan</a>
            <span>/</span>
            <strong>SE/HRD/2026/X/084</strong>
            <div class="announcement-tools">
                <button id="announcement-bookmark" type="button" aria-label="Simpan pengumuman" aria-pressed="false">♧</button>
                <button id="announcement-share" type="button" aria-label="Bagikan pengumuman">♧</button>
            </div>
        </div>

        <article class="announcement-document">
            <section class="announcement-summary-card">
                <div class="announcement-tags"><span class="announcement-official">✿ SURAT RESMI</span><span class="announcement-department">HR &amp; GA</span><span class="announcement-must-read">! Wajib Dibaca</span></div>
                <div class="announcement-reference"><strong>No: SE/HRD/2026/X/084</strong><span>Versi 1.0</span></div>
                <h2>Penyesuaian Batas Verifikasi Jadwal Kerja, Presensi, dan Pengajuan Lembur Akhir Bulan Oktober 2026</h2>
                <p class="announcement-date">◷ 19 Oktober 2026 • 10:15 WIB</p>
                <div class="announcement-deadline"><span class="deadline-lock">♙</span><span><strong>Lock Payroll: 27 Oktober 2026 (00:00 WIB)</strong><small>Sisa waktu verifikasi berkala: 8 hari kerja</small></span></div>
            </section>

            <section class="announcement-content-card">
                <div class="announcement-recipient"><small>TUJUAN SURAT:</small><strong>Seluruh Karyawan ERP PT Anaheim Nimbus Universal</strong><span>Semua Divisi &amp; Unit Operasional Regional</span></div>
                <div class="announcement-body">
                    <p>Dengan hormat,</p>
                    <p>Sehubungan dengan penutupan siklus periode penggajian (<em>Payroll Cut-off</em>) bulan Oktober 2026, bersama ini Tim People Operations &amp; General Affairs menyampaikan ketentuan batas waktu (<em>deadline</em>) serta prosedur rekonsiliasi data kehadiran untuk menjamin kelancaran perhitungan hak seluruh karyawan secara akurat dan tepat waktu.</p>
                    <h3>Instruksi Pokok &amp; Ketentuan</h3>
                    <section class="announcement-instruction"><span class="instruction-number">1</span><div><h4>Batas Akhir Klarifikasi Kehadiran</h4><p>Maksimal hari <strong>Minggu, 25 Oktober 2026 pukul 17:00 WIB</strong> untuk karyawan yang mengalami kendala sistem, log tidak sinkron, atau koreksi presensi terlambat melalui portal HRIS.</p><strong class="instruction-note">ⓘ Klarifikasi wajib melampirkan bukti presensi manual</strong></div></section>
                    <section class="announcement-instruction"><span class="instruction-number">2</span><div><h4>Pengajuan &amp; Persetujuan Lembur (Overtime)</h4><p>Semua surat perintah lembur (SPL) periode 1–25 Oktober 2026 wajib telah diajukan dan disetujui (Approved) oleh atasan langsung (Manager/Lead) paling lambat <strong>Senin, 26 Oktober 2026 pukul 12:00 WIB.</strong></p><strong class="instruction-warning">⚠ Lembur yang tidak di-approve tepat waktu akan ditransfer ke periode Nov</strong></div></section>
                    <section class="announcement-instruction"><span class="instruction-number">3</span><div><h4>Kunci Data Rekapitulasi (Lock Payroll)</h4><p>Sistem backend HRIS akan melakukan penguncian berkala rekapitulasi data kehadiran otomatis pada <strong class="instruction-deadline">Selasa, 27 Oktober 2026 pukul 00:00 WIB.</strong> Setelah waktu tersebut, tidak ada perubahan yang dapat diproses oleh admin regional.</p></div></section>
                    <p class="announcement-closing">Demikian surat edaran ini disampaikan untuk dipedomani dan dilaksanakan dengan penuh rasa tanggung jawab. Atas dedikasi, kerja sama, dan kedisiplinan rekan-rekan sekalian, kami sampaikan terima kasih.</p>
                </div>

                <section class="announcement-signature">
                    <div class="signature-meta"><span>Jakarta, 19 Oktober 2026</span><strong>E-Signature Authenticated</strong></div>
                    <div class="signature-copy"><small>DITETAPKAN OLEH:</small><strong>Aris Prabowo, S.Psi., M.M.</strong><span>Head of People Operations &amp; HR</span><span>ERP PT Anaheim Nimbus Universal</span></div>
                    <div class="signature-seal"><span>♢</span><strong>VERIFIED OFFICIAL</strong><small>HR DEPT ID</small></div>
                    <div class="signature-hash"><span>SHA-256: 8a7c...3b9e421</span><strong>♙ Tervalidasi Digital</strong></div>
                </section>
            </section>

            <section class="announcement-attachment">
                <div class="attachment-heading"><h3>↪ Lampiran Resmi</h3><span>1 Berkas</span></div>
                <div class="attachment-file"><span class="pdf-icon">PDF</span><span class="attachment-name"><strong>SE-084-Jadwal-Kerja-Oktober-2026.pdf</strong><small>Gunakan cetak / simpan sebagai PDF</small></span><button id="announcement-download" type="button" aria-label="Cetak atau simpan halaman sebagai PDF">↓ Cetak</button></div>
            </section>
            <button class="announcement-acknowledge" id="announcement-acknowledge" type="button">✓ &nbsp;Saya Sudah Membaca &amp; Memahami</button>
            <p class="announcement-feedback" id="announcement-feedback" role="status" aria-live="polite" hidden></p>
        </article>
    </main>
    <script src="announcement.js?v=2"></script>
</body>
</html>
<?php
    exit;
}

if ($attendancePage === 'lembur') {
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lembur Karyawan</title>
    <link rel="stylesheet" href="overtime.css?v=3">
</head>
<body class="overtime-page">
    <main class="overtime-shell">
        <header class="overtime-header">
            <div class="overtime-brand">Debay, S.T.<small>Lembur</small></div>
            <div class="overtime-header-actions">
                <a href="?page=notifikasi" aria-label="Notifikasi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg></a>
                <a class="overtime-avatar" href="?page=profil" aria-label="Profil">D</a>
            </div>
        </header>

        <section class="overtime-prompt">
            <strong>Ada Rencana Lembur?</strong>
            <button class="overtime-apply-button" id="overtime-open-form" type="button">⊕ &nbsp;Ajukan</button>
        </section>

        <div class="overtime-section-heading">
            <h1>Riwayat Lembur</h1>
            <span class="overtime-total" id="overtime-count">3 Pengajuan</span>
        </div>
        <nav class="overtime-filters" aria-label="Filter status pengajuan lembur">
            <button class="overtime-filter active" type="button" data-filter="all" data-label="Semua">Semua (3)</button>
            <button class="overtime-filter" type="button" data-filter="approved" data-label="Disetujui">Disetujui (2)</button>
            <button class="overtime-filter" type="button" data-filter="rejected" data-label="Tidak Disetujui">Tidak Disetujui (1)</button>
        </nav>
        <div class="overtime-list" id="overtime-list"></div>
        <p class="overtime-empty" id="overtime-empty" hidden>Tidak ada pengajuan lembur pada status ini.</p>
    </main>

    <div class="overtime-modal" id="overtime-modal" role="presentation" hidden>
        <form class="overtime-form" id="overtime-form" role="dialog" aria-modal="true" aria-labelledby="overtime-form-title">
            <div class="overtime-form-heading">
                <h2 id="overtime-form-title">Ajukan Permohonan Lembur</h2>
                <button class="overtime-close" type="button" data-overtime-close aria-label="Tutup formulir">×</button>
            </div>
            <div class="overtime-field-grid">
                <label>Hari
                    <select id="overtime-day" required>
                        <option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option>
                    </select>
                </label>
                <label>Tanggal &amp; Tahun
                    <input id="overtime-date" type="date" required>
                </label>
            </div>
            <section class="overtime-time-panel">
                <div class="overtime-time-heading"><span>◷ &nbsp;Waktu Lembur</span><span class="overtime-duration" id="overtime-duration">Durasi: 3.5 Jam</span></div>
                <div class="overtime-time-grid">
                    <label>Jam Mulai (WIB)<select id="overtime-start" required></select></label>
                    <label>Jam Selesai (WIB)<select id="overtime-end" required></select></label>
                </div>
            </section>
            <label class="overtime-reason-label">Keterangan / Alasan
                <textarea id="overtime-reason" maxlength="500" placeholder="Tuliskan alasan pengajuan dan penugasan rekan..." required></textarea>
            </label>
            <div class="overtime-form-actions">
                <button class="overtime-cancel" type="button" data-overtime-close>Batal</button>
                <button class="overtime-submit" type="submit">Kirim Permohonan</button>
            </div>
        </form>
    </div>
    <div class="overtime-toast" id="overtime-toast" role="status" aria-live="polite" hidden></div>

    <nav class="overtime-bottom-nav" aria-label="Navigasi utama">
        <a href="./"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg><span>Beranda</span></a>
        <a href="?page=riwayat"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg><span>Riwayat</span></a>
        <a class="active" href="?page=lembur" aria-current="page"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg><span>Lembur</span></a>
        <a href="?page=profil"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg><span>Profil</span></a>
    </nav>
    <script src="overtime.js?v=3"></script>
</body>
</html>
<?php
    exit;
}

if ($attendancePage === 'riwayat') {
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Presensi Karyawan</title>
    <link rel="stylesheet" href="attendance-history.css?v=2">
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; min-height: 100%; font-family: "Segoe UI", Tahoma, sans-serif; color: #172033; }
        body { min-height: 100vh; background: #f8f7fc; }
        .history-standalone { width: min(100%, 430px); min-height: 100vh; margin: 0 auto; padding: 14px 16px 100px; }
        .history-standalone .page-header { display: flex; align-items: center; justify-content: space-between; min-height: 42px; margin-bottom: 10px; }
        .history-standalone .employee-avatar-small { display: grid; width: 38px; height: 38px; place-items: center; border: 2px solid #d5dcf5; border-radius: 50%; background: #e8ecf7; color: #263658; font-weight: 800; text-decoration: none; }
        .history-standalone + .bottom-nav { position: fixed; z-index: 5; right: 0; bottom: 0; left: 0; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); width: min(100%, 430px); margin: 0 auto; padding: 9px 8px calc(8px + env(safe-area-inset-bottom)); background: rgba(255,255,255,.97); box-shadow: 0 -6px 18px rgba(15,23,42,.05); }
        .history-standalone + .bottom-nav .nav-item { display: flex; min-width: 0; flex-direction: column; align-items: center; gap: 4px; color: #626d82; font-size: .66rem; text-decoration: none; }
        .history-standalone + .bottom-nav .nav-item.active { color: #1749e8; }
        .history-standalone + .bottom-nav .nav-item svg { width: 23px; height: 23px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    </style>
</head>
<body>
    <main class="attendance-history-page history-standalone">
        <header class="page-header">
            <div class="history-brand">Debay, S.T.<small>Riwayat</small></div>
            <div class="history-header-actions">
                <a class="history-icon-link" href="?page=notifikasi" aria-label="Notifikasi">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
                </a>
                <a class="employee-avatar-small" href="?page=profil" aria-label="Profil">D</a>
            </div>
        </header>
        <section class="history-period-card" aria-label="Periode terpilih">
            <span class="history-period-icon" aria-hidden="true">▣</span>
            <div class="history-period-copy">
                <small id="history-period-label">PERIODE PRESENSI</small>
                <strong id="history-period-title"></strong>
                <span id="history-period-range"></span>
            </div>
            <div class="history-period-controls">
                <button id="history-previous" type="button" aria-label="Periode sebelumnya">‹</button>
                <button id="history-next" type="button" aria-label="Periode selanjutnya">›</button>
            </div>
        </section>
        <section class="history-summary-card">
            <div class="history-summary-heading"><h2 id="history-summary-title">Ringkasan Bulan Ini</h2><span class="history-summary-rate" id="history-summary-rate" hidden></span></div>
            <div class="history-metrics" id="history-metrics"></div>
        </section>
        <div class="history-section-heading">
            <h2 id="history-section-title">Catatan Harian</h2>
            <span id="history-record-count"></span>
        </div>
        <nav class="history-filters" id="history-filters" aria-label="Filter riwayat">
            <button class="history-filter active" type="button" data-filter="all" data-label="Semua">Semua</button>
            <button class="history-filter" type="button" data-filter="ontime" data-label="Tepat Waktu">Tepat Waktu</button>
            <button class="history-filter" type="button" data-filter="late" data-label="Terlambat">Terlambat</button>
            <button class="history-filter" type="button" data-filter="overtime" data-label="Lembur">Lembur</button>
        </nav>
        <div class="history-record-list" id="history-records"></div>
        <p class="history-empty" id="history-empty" hidden>Tidak ada catatan pada kategori ini.</p>
        <button class="history-download" id="history-download" type="button">⇩ &nbsp;Unduh Rekap Bulanan (PDF)</button>
    </main>
    <nav class="bottom-nav" aria-label="Navigasi utama">
        <a class="nav-item" href="./"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg><span>Beranda</span></a>
        <a class="nav-item active" href="?page=riwayat" aria-current="page"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg><span>Riwayat</span></a>
        <a class="nav-item" href="?page=lembur"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg><span>Lembur</span></a>
        <a class="nav-item" href="?page=profil"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg><span>Profil</span></a>
    </nav>
    <script src="attendance-history.js?v=2"></script>
</body>
</html>
<?php
    exit;
}

if (in_array($attendancePage, ['profil', 'notifikasi'], true)) {
    $isProfile = $attendancePage === 'profil';
    $pageTitle = $isProfile ? 'Profil' : 'Notifikasi';
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> Karyawan</title>
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; min-height: 100%; font-family: "Segoe UI", Tahoma, sans-serif; color: #172033; }
        body { min-height: 100vh; background: #f8f7fc; }
        a { color: inherit; }
        .page-shell { width: min(100%, 430px); min-height: 100vh; margin: 0 auto; padding: 14px 16px 88px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; min-height: 42px; margin-bottom: 14px; }
        .profile-heading { display: flex; flex-direction: column; gap: 2px; color: #1749e8; line-height: 1.1; }
        .profile-heading strong { font-size: 1.15rem; letter-spacing: -.03em; }
        .profile-heading small { color: #454b5c; font-size: .74rem; font-weight: 600; }
        .profile-header-actions { display: flex; align-items: center; gap: 10px; }
        .icon-link, .profile-avatar-small { position: relative; display: grid; place-items: center; width: 40px; height: 40px; border: 0; border-radius: 50%; background: transparent; text-decoration: none; }
        .icon-link svg { width: 22px; height: 22px; fill: none; stroke: #39445a; stroke-width: 1.9; stroke-linecap: round; stroke-linejoin: round; }
        .icon-link.unread::after { content: ""; position: absolute; top: 5px; right: 5px; width: 9px; height: 9px; border-radius: 50%; background: #df283c; border: 1px solid #fff; }
        .profile-avatar-small { border: 2px solid #d5dcf5; background: #e8ecf7; color: #263658; font-weight: 800; }
        .profile-card, .settings-card, .notification-card { border: 1px solid rgba(222,225,239,.8); border-radius: 16px; background: #fff; box-shadow: 0 3px 10px rgba(25,35,70,.035); }
        .profile-card { padding: 16px; }
        .identity { display: grid; grid-template-columns: 80px 1fr; align-items: center; gap: 16px; }
        .profile-photo { width: 80px; height: 80px; display: grid; place-items: center; border-radius: 13px; background: linear-gradient(145deg,#d7e7e8,#aebfc8 45%,#47556a); color: white; font-size: 1.7rem; font-weight: 700; }
        .employee-type { display: inline-flex; align-items: center; gap: 5px; padding: 3px 8px; border-radius: 999px; background: #81f2c4; color: #063f34; font-size: .65rem; font-weight: 700; }
        .employee-name { margin: 6px 0 1px; font-size: 1.15rem; line-height: 1.15; }
        .employee-role { color: #1749c8; font-size: .82rem; font-weight: 700; }
        .employee-department { margin-top: 2px; color: #50586a; font-size: .75rem; }
        .profile-facts { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 16px; }
        .profile-fact { min-width: 0; display: flex; align-items: center; gap: 9px; padding: 10px; border-radius: 11px; background: #f0f2ff; }
        .fact-icon { flex: 0 0 32px; width: 32px; height: 32px; display: grid; place-items: center; border-radius: 9px; background: #dce4ff; color: #1749c8; font-size: 1rem; }
        .fact-label { display: block; color: #555c6d; font-size: .58rem; font-weight: 700; letter-spacing: .04em; }
        .fact-value { display: block; overflow-wrap: anywhere; font-size: .69rem; font-weight: 750; }
        .fact-value.legal { color: #078256; }
        .section-label { margin: 16px 4px 6px; color: #525b6c; font-size: .69rem; font-weight: 800; letter-spacing: .06em; }
        .settings-card { overflow: hidden; }
        .setting-link, .setting-toggle { display: flex; align-items: center; width: 100%; min-height: 72px; padding: 12px 14px; gap: 11px; border: 0; background: transparent; text-align: left; text-decoration: none; }
        .setting-link + .setting-toggle { border-top: 1px solid #edf0f7; }
        .setting-icon { flex: 0 0 38px; width: 38px; height: 38px; display: grid; place-items: center; border-radius: 11px; background: #e8ecff; color: #1749c8; font-size: 1.05rem; }
        .setting-copy { flex: 1; min-width: 0; }
        .setting-copy strong { display: block; font-size: .88rem; }
        .setting-copy small { display: block; margin-top: 3px; color: #596174; font-size: .68rem; }
        .setting-chevron { color: #4b5563; font-size: 1.35rem; }
        .switch { position: relative; flex: 0 0 48px; width: 48px; height: 28px; border: 0; border-radius: 999px; background: #cbd2e2; cursor: pointer; transition: background .15s ease; }
        .switch::after { content: ""; position: absolute; top: 3px; left: 3px; width: 22px; height: 22px; border-radius: 50%; background: #fff; box-shadow: 0 1px 4px #0002; transition: transform .15s ease; }
        .switch[aria-checked="true"] { background: #214fe0; }
        .switch[aria-checked="true"]::after { transform: translateX(20px); }
        .logout { display: block; width: 100%; margin-top: 28px; padding: 13px; border: 0; border-radius: 12px; background: #fcebed; color: #be123c; font: inherit; font-weight: 700; text-align: center; text-decoration: none; }
        .bottom-nav { position: fixed; z-index: 5; right: 0; bottom: 0; left: 0; display: grid; grid-template-columns: repeat(4,1fr); width: min(100%,430px); margin: 0 auto; padding: 9px 8px 8px; background: rgba(255,255,255,.97); box-shadow: 0 -6px 18px rgba(15,23,42,.05); }
        .nav-item { display: flex; flex-direction: column; align-items: center; gap: 4px; color: #626d82; font-size: .66rem; text-decoration: none; }
        .nav-item.active { color: #1749e8; }
        .nav-item svg { width: 23px; height: 23px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .notifications-header { display: flex; align-items: center; justify-content: space-between; min-height: 42px; }
        .notification-heading { display: flex; align-items: center; gap: 12px; }
        .back-link { width: 32px; color: #172033; font-size: 1.8rem; line-height: 1; text-decoration: none; }
        .notification-heading h1 { margin: 0; font-size: 1.12rem; }
        .mark-all { padding: 6px 0 6px 8px; border: 0; background: transparent; color: #1749c8; font-size: .7rem; font-weight: 700; cursor: pointer; }
        .notice-summary { display: flex; justify-content: space-between; align-items: center; margin: 8px 4px 11px; }
        .notice-summary strong { font-size: .92rem; }
        .new-count { padding: 3px 8px; border-radius: 999px; background: #81f2c4; color: #075540; font-size: .62rem; }
        .filters { display: flex; gap: 5px; overflow-x: auto; margin: 0 0 17px; padding: 0 0 2px; }
        .filter-chip { flex: 0 0 auto; padding: 7px 11px; border: 0; border-radius: 999px; background: #e7eaff; color: #495268; font-size: .67rem; cursor: pointer; }
        .filter-chip.active { background: #214fe0; color: #fff; }
        .filter-chip span { margin-left: 4px; font-weight: 800; }
        .notice-day { display: flex; justify-content: space-between; margin: 15px 4px 7px; color: #747b8c; font-size: .68rem; font-weight: 800; letter-spacing: .04em; }
        .notice-day[hidden] { display: none; }
        .notice-day small { color: #1749c8; font-size: .62rem; letter-spacing: 0; }
        .notification-card { position: relative; display: grid; grid-template-columns: 40px 1fr 12px; gap: 11px; margin-bottom: 7px; padding: 13px 11px; }
        .notification-card[hidden] { display: none; }
        .notification-card.read { opacity: .78; }
        .notice-icon { width: 40px; height: 40px; display: grid; place-items: center; border-radius: 11px; background: #e5eaff; color: #1749c8; font-size: 1.05rem; }
        .notice-icon.success { background: #85f0c6; color: #087854; }
        .notice-icon.warning { background: #ffe0c8; color: #9a4c00; }
        .notice-content { min-width: 0; }
        .notice-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 5px; color: #087854; font-size: .61rem; font-weight: 800; }
        .notice-meta.blue { color: #1749c8; }
        .notice-meta.orange { color: #9a4c00; }
        .notice-status { padding: 3px 7px; border-radius: 999px; background: #81f2c4; color: #075540; font-size: .57rem; }
        .notice-title { margin: 5px 0 4px; font-size: .86rem; line-height: 1.25; }
        .notice-description { margin: 0; color: #50586a; font-size: .69rem; line-height: 1.5; }
        .notice-time { display: block; margin-top: 12px; color: #697386; font-size: .62rem; }
        .notice-dot { width: 9px; height: 9px; margin-top: 3px; border-radius: 50%; background: #1749c8; }
        .notification-card.read .notice-dot { visibility: hidden; }
        .notice-more { position: absolute; right: 8px; bottom: 8px; padding: 2px 5px; border: 0; background: transparent; color: #68738a; font-size: 1rem; cursor: pointer; }
        .notice-action { display: inline-block; margin-top: 8px; padding: 6px 10px; border-radius: 8px; background: #e8ecff; color: #1749c8; font-size: .66rem; font-weight: 700; text-decoration: none; }
        .notice-empty { padding: 24px 10px; color: #697386; font-size: .8rem; text-align: center; }
        @media(max-width:360px) { .page-shell { padding-right: 12px; padding-left: 12px; } .profile-facts { gap: 6px; } .profile-fact { padding: 8px; } .notice-title { font-size: .8rem; } }
    </style>
</head>
<body>
    <main class="page-shell">
        <?php if ($isProfile) { ?>
            <header class="page-header">
                <div class="profile-heading"><strong>Debay, S.T.</strong><small>Profil</small></div>
                <div class="profile-header-actions">
                    <a class="icon-link unread" href="?page=notifikasi" aria-label="Buka notifikasi">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4"/></svg>
                    </a>
                    <div class="profile-avatar-small" aria-label="Foto profil">D</div>
                </div>
            </header>
            <section class="profile-card" aria-label="Informasi karyawan">
                <div class="identity">
                    <div class="profile-photo" aria-hidden="true">D</div>
                    <div>
                        <span class="employee-type">● Karyawan Tetap (Full Time)</span>
                        <h1 class="employee-name">Debay, S.T.</h1>
                        <div class="employee-role">Senior UI/UX Designer</div>
                        <div class="employee-department">Divisi Produk &amp; Desain</div>
                    </div>
                </div>
                <div class="profile-facts">
                    <div class="profile-fact"><span class="fact-icon">▣</span><span><small class="fact-label">NIP PEGAWAI</small><strong class="fact-value">EMP-20220914</strong></span></div>
                    <div class="profile-fact"><span class="fact-icon">⛨</span><span><small class="fact-label">STATUS AKUN</small><strong class="fact-value legal">Aktif &amp; Legal</strong></span></div>
                </div>
            </section>
            <h2 class="section-label">PENGATURAN ABSENSI &amp; KEAMANAN</h2>
            <section class="settings-card">
                <a class="setting-link" href="./#calendar">
                    <span class="setting-icon">▦</span>
                    <span class="setting-copy"><strong>Jadwal Kerja &amp; Kalender Shift</strong><small>Lihat rotasi jadwal &amp; cuti bersama</small></span>
                    <span class="setting-chevron">›</span>
                </a>
                <div class="setting-toggle">
                    <span class="setting-icon">◴</span>
                    <span class="setting-copy"><strong>Pengingat Absen Otomatis</strong><small>15 menit sebelum shift dimulai</small></span>
                    <button class="switch" id="attendance-reminder" type="button" role="switch" aria-checked="true" aria-label="Pengingat absen otomatis"></button>
                </div>
            </section>
            <a class="logout" href="./">⇥ &nbsp;Keluar</a>
        <?php } else { ?>
            <header class="page-header">
                <div class="notifications-header">
                    <div class="notification-heading"><a class="back-link" href="./" aria-label="Kembali ke beranda">‹</a><h1>Notifikasi</h1></div>
                    <div class="profile-header-actions">
                        <button class="mark-all" id="mark-all-read" type="button" aria-label="Tandai semua dibaca">✓✓</button>
                    </div>
                </div>
            </header>
            <div class="notice-summary"><strong>Pusat Pemberitahuan</strong><span class="new-count" id="unread-count"></span></div>
            <nav class="filters" aria-label="Filter notifikasi">
                <button class="filter-chip active" data-filter="all" type="button">Semua <span id="total-count"></span></button>
                <button class="filter-chip" data-filter="announcement" type="button">Pengumuman <span id="announcement-count"></span></button>
                <button class="filter-chip" data-filter="overtime" type="button">Pengajuan Lembur <span id="overtime-count"></span></button>
            </nav>
            <div class="notice-day">HARI INI <small>Terbaru</small></div>
            <section class="notification-card" data-category="announcement" data-id="schedule-announcement">
                <span class="notice-icon">✿</span><div class="notice-content">
                    <div class="notice-meta">PENGUMUMAN HR &amp; GA</div>
                    <h2 class="notice-title">Penyesuaian Batas Verifikasi Jadwal Kerja dan Presensi</h2>
                    <p class="notice-description">Perhatikan batas klarifikasi kehadiran, persetujuan lembur, dan penguncian data payroll bulan Oktober.</p>
                    <small class="notice-time">◷ 19 Okt 2026</small>
                    <a class="notice-action" href="?page=pengumuman-jadwal">Lihat Pengumuman</a>
                </div><span class="notice-dot"></span><button class="notice-more" type="button" aria-label="Tandai sudah dibaca">⋮</button>
            </section>
            <div class="notice-day">MINGGU INI</div>
            <section class="notification-card" data-category="overtime" data-id="overtime-approved">
                <span class="notice-icon">◴</span><div class="notice-content">
                    <div class="notice-meta blue">LEMBUR DISETUJUI</div>
                    <h2 class="notice-title">Lembur Telah Disetujui (2.5 Jam)</h2>
                    <p class="notice-description">Lembur tugas proyek akhir pekan telah diverifikasi dan masuk ke perhitungan payroll bulan berjalan.</p>
                    <small class="notice-time">▣ 19 Okt 2026</small>
                </div><span class="notice-dot"></span><button class="notice-more" type="button" aria-label="Tandai sudah dibaca">⋮</button>
            </section>
            <p class="notice-empty" id="notice-empty" hidden>Tidak ada notifikasi pada kategori ini.</p>
        <?php } ?>
    </main>
    <nav class="bottom-nav" aria-label="Navigasi utama">
        <a class="nav-item" href="./"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg><span>Beranda</span></a>
        <a class="nav-item" href="?page=riwayat"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg><span>Riwayat</span></a>
        <a class="nav-item" href="?page=lembur"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg><span>Lembur</span></a>
        <a class="nav-item <?= $isProfile ? 'active' : '' ?>" href="?page=profil"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg><span>Profil</span></a>
    </nav>
    <?php if ($isProfile) { ?>
    <script>
        const reminderSwitch = document.getElementById('attendance-reminder');
        reminderSwitch.setAttribute('aria-checked', localStorage.getItem('attendance-reminder-enabled') !== 'false');
        reminderSwitch.addEventListener('click', () => {
            const enabled = reminderSwitch.getAttribute('aria-checked') !== 'true';
            reminderSwitch.setAttribute('aria-checked', String(enabled));
            localStorage.setItem('attendance-reminder-enabled', String(enabled));
        });
    </script>
    <?php } else { ?>
    <script>
        const notificationCards = Array.from(document.querySelectorAll('.notification-card'));
        const readIds = new Set(JSON.parse(localStorage.getItem('attendance-read-notifications') || '[]'));
        let activeFilter = 'all';

        function updateNotifications() {
            let visibleCount = 0;
            let unreadCount = 0;
            notificationCards.forEach((card) => {
                const isRead = readIds.has(card.dataset.id);
                card.classList.toggle('read', isRead);
                if (isRead) card.setAttribute('aria-label', 'Notifikasi sudah dibaca');
                const matchesFilter = activeFilter === 'all' || card.dataset.category === activeFilter;
                card.hidden = !matchesFilter;
                if (matchesFilter) visibleCount += 1;
                if (!isRead) unreadCount += 1;
            });
            document.getElementById('unread-count').textContent = `${unreadCount} Baru`;
            document.getElementById('total-count').textContent = notificationCards.length;
            document.getElementById('announcement-count').textContent = notificationCards.filter((card) => card.dataset.category === 'announcement').length;
            document.getElementById('overtime-count').textContent = notificationCards.filter((card) => card.dataset.category === 'overtime').length;
            document.getElementById('notice-empty').hidden = visibleCount !== 0;
            document.querySelectorAll('.notice-day').forEach((heading) => {
                const card = heading.nextElementSibling;
                heading.hidden = !card || card.hidden;
            });
            localStorage.setItem('attendance-read-notifications', JSON.stringify(Array.from(readIds)));
        }

        document.querySelectorAll('.filter-chip').forEach((button) => {
            button.addEventListener('click', () => {
                activeFilter = button.dataset.filter;
                document.querySelectorAll('.filter-chip').forEach((chip) => chip.classList.toggle('active', chip === button));
                updateNotifications();
            });
        });
        document.querySelectorAll('.notice-more').forEach((button) => {
            button.addEventListener('click', () => {
                readIds.add(button.closest('.notification-card').dataset.id);
                updateNotifications();
            });
        });
        document.getElementById('mark-all-read').addEventListener('click', () => {
            notificationCards.forEach((card) => readIds.add(card.dataset.id));
            updateNotifications();
        });
        updateNotifications();
    </script>
    <?php } ?>
</body>
</html>
<?php
    exit;
}

if (in_array($attendancePage, ['presensi-masuk', 'presensi-pulang'], true)) {
    $isCheckout = $attendancePage === 'presensi-pulang';
    $attendanceTitle = $isCheckout ? 'Presensi Pulang' : 'Presensi Masuk';
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($attendanceTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; min-height: 100%; font-family: "Segoe UI", Tahoma, sans-serif; color: #172033; }
        body { min-height: 100vh; background: #f8f7fc; }
        .attendance-shell { width: min(100%, 430px); min-height: 100vh; margin: 0 auto; padding: 14px 16px 90px; }
        .attendance-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .user-badge { display: flex; flex-direction: column; gap: 2px; color: #1749e8; line-height: 1.1; }
        .user-badge strong { font-size: 1.15rem; font-weight: 700; letter-spacing: -0.03em; }
        .user-badge small { color: #454b5c; font-size: 0.74rem; font-weight: 600; }
        .header-actions { display: flex; align-items: center; gap: 12px; }
        .header-icon, .avatar { width: 40px; height: 40px; border: 0; border-radius: 50%; display: grid; place-items: center; }
        .header-icon { position: relative; background: transparent; color: #35405a; }
        .header-icon svg { width: 22px; height: 22px; fill: currentColor; }
        .header-icon::after { content: ""; position: absolute; top: 7px; right: 7px; width: 8px; height: 8px; border-radius: 50%; background: #df283c; }
        .avatar { border: 2px solid #d5dcf5; background: #e8ecf7; color: #38435e; font-weight: 700; }
        .attendance-content { display: flex; flex-direction: column; gap: 16px; }
        .attendance-topbar { display: flex; align-items: center; gap: 10px; }
        .back { width: 40px; height: 40px; border-radius: 50%; display: grid; place-items: center; background: #edf0ff; color: #172033; font-size: 1.7rem; line-height: 1; text-decoration: none; }
        .attendance-title { margin: 0; font-size: 1.2rem; font-weight: 750; }
        .time-panel { padding: 17px 12px 15px; border-radius: 16px; background: #fff; text-align: center; box-shadow: 0 3px 12px rgba(20, 30, 55, .04); }
        .time-label { color: #454b5c; font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
        .time { margin-top: 6px; font-size: 1.95rem; font-weight: 800; line-height: 1.1; letter-spacing: -.03em; }
        .timezone { font-size: .62rem; font-weight: 700; letter-spacing: 0; }
        .date { margin-top: 5px; color: #4b5563; font-size: .82rem; }
        .scanner-card { padding: 16px; border-radius: 17px; background: #fff; box-shadow: 0 4px 14px rgba(15, 23, 42, .06); }
        .scanner { position: relative; width: min(100%, 330px); aspect-ratio: 1; margin: 0 auto; overflow: hidden; border-radius: 13px; background: linear-gradient(145deg, #101827, #111b2d); }
        .scan-trigger { display: block; padding: 0; border: 0; color: inherit; cursor: pointer; }
        .scan-trigger:focus-visible { outline: 3px solid #80a2ff; outline-offset: 3px; }
        .scanner-focus { position: absolute; inset: 30% 28%; display: flex; justify-content: center; border: 1px solid rgba(255,255,255,.12); border-radius: 13px; background: rgba(255,255,255,.025); }
        .qr-icon { position: absolute; top: 20%; width: 34px; height: 34px; color: #f4f6fc; }
        .scan-hint { position: absolute; right: 4px; bottom: 7%; left: 4px; color: rgba(255,255,255,.9); font-size: .65rem; line-height: 1.2; text-align: center; }
        .scan-line { position: absolute; z-index: 2; top: 50%; right: 20%; left: 20%; height: 2px; background: #2459f5; box-shadow: 0 0 12px rgba(36,89,245,.8); }
        .corner { position: absolute; z-index: 3; width: 32px; height: 32px; border-color: #2459f5; border-style: solid; }
        .top-left { top: 18%; left: 18%; border-width: 4px 0 0 4px; border-radius: 9px 0 0; }
        .top-right { top: 18%; right: 18%; border-width: 4px 4px 0 0; border-radius: 0 9px 0 0; }
        .bottom-left { bottom: 18%; left: 18%; border-width: 0 0 4px 4px; border-radius: 0 0 0 9px; }
        .bottom-right { right: 18%; bottom: 18%; border-width: 0 4px 4px 0; border-radius: 0 0 9px; }
        .demo-hint { margin: 10px 0 0; color: #6b7280; font-size: .7rem; text-align: center; }
        .result-overlay { position: fixed; z-index: 20; inset: 0; display: grid; place-items: center; padding: 18px; background: rgba(20, 26, 45, .58); backdrop-filter: blur(5px); }
        .result-overlay[hidden] { display: none; }
        .network-overlay { position: fixed; z-index: 50; inset: 0; display: grid; place-items: center; padding: 18px; background: rgba(20, 26, 45, .58); backdrop-filter: blur(5px); }
        .network-overlay[hidden] { display: none; }
        .network-dialog { position: relative; width: min(100%, 390px); max-height: calc(100vh - 36px); overflow-y: auto; padding: 28px 24px 24px; border-radius: 15px; background: #fff; box-shadow: 0 18px 55px rgba(0,0,0,.22); text-align: center; }
        .network-close { position: absolute; top: 16px; right: 16px; display: grid; width: 36px; height: 36px; place-items: center; border: 0; border-radius: 50%; background: #f1f2ff; color: #4b5263; font-size: 1.4rem; cursor: pointer; }
        .network-icon { display: grid; width: 64px; height: 64px; place-items: center; margin: 0 auto 12px; border-radius: 50%; background: #ffe0dc; color: #c51d25; }
        .network-icon svg { width: 34px; height: 34px; fill: none; stroke: currentColor; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
        .network-icon svg .alert-mark { fill: currentColor; stroke: none; }
        .network-dialog h2 { margin: 0 0 6px; font-size: 1.2rem; }
        .network-description { margin: 0 0 16px; color: #4b5563; font-size: .82rem; line-height: 1.45; }
        .network-info { margin-bottom: 14px; padding: 8px 10px; border-radius: 10px; background: #f1f2ff; text-align: left; }
        .network-info-row { display: flex; justify-content: space-between; gap: 10px; color: #4b5563; font-size: .72rem; line-height: 1.8; }
        .network-info-row strong { color: #1f2937; text-align: right; }
        .network-status-offline { color: #b91c1c !important; }
        .network-warning { margin-bottom: 14px; padding: 10px; border-radius: 9px; background: #fff1e5; color: #854300; font-size: .72rem; line-height: 1.4; text-align: left; }
        .network-retry { display: block; width: 100%; padding: 12px 14px; border: 0; border-radius: 9px; background: #214bd8; color: #fff; font: inherit; font-size: .86rem; font-weight: 700; cursor: pointer; }
        .network-retry:disabled { opacity: .7; cursor: wait; }
        .result-card { width: min(100%, 390px); max-height: calc(100vh - 36px); overflow: auto; padding: 24px; border-radius: 16px; background: linear-gradient(135deg, #d1fae9 0, #fff 38%, #fff 100%); box-shadow: 0 18px 55px rgba(0,0,0,.22); text-align: center; }
        .result-card.late { width: min(100%, 360px); border-radius: 22px; background: #fff; }
        .result-icon { width: 80px; height: 80px; margin: 0 auto 16px; display: grid; place-items: center; border: 11px solid #81f2c4; border-radius: 50%; background: #047857; color: #fff; font-size: 2rem; font-weight: 700; box-shadow: 0 4px 9px rgba(15,23,42,.16); }
        .result-icon.warning { border-color: #ffe0cb; background: #a34b00; color: #fff; }
        .result-card h2 { margin: 0 auto 6px; font-size: 1.3rem; line-height: 1.25; }
        .result-description { margin: 0 auto 14px; color: #4b5563; font-size: .78rem; line-height: 1.5; }
        .result-pills { display: flex; justify-content: center; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }
        .result-pill { padding: 5px 10px; border-radius: 999px; background: #e6eaff; color: #1645bb; font-size: .68rem; font-weight: 700; }
        .result-pill.late-pill { background: #ffe1cc; color: #713500; }
        .result-details { margin: 0 0 18px; padding: 12px 14px; border-radius: 14px; background: #f1f2ff; text-align: left; }
        .result-row { display: flex; justify-content: space-between; gap: 12px; padding: 6px 0; color: #4b5563; font-size: .7rem; }
        .result-row + .result-row { border-top: 1px solid rgba(110,120,165,.12); }
        .result-row strong { color: #1f2937; text-align: right; font-weight: 650; }
        .result-ref { color: #1749c8 !important; font-family: monospace; }
        .result-button { display: block; width: 100%; padding: 12px 14px; border: 0; border-radius: 9px; background: #214bd8; color: #fff; font: inherit; font-size: .85rem; text-decoration: none; cursor: pointer; }
        .result-button[hidden], .late-reason-launch[hidden], .late-reason-overlay[hidden] { display: none; }
        .late-reason-launch { margin-bottom: 8px; }
        .late-reason-overlay { position: fixed; z-index: 40; inset: 0; display: flex; align-items: center; justify-content: center; overflow-y: auto; padding: 10px; background: rgba(20,26,45,.58); backdrop-filter: blur(4px); }
        .late-reason-form { width: min(100%, 390px); max-height: calc(100vh - 20px); overflow-y: auto; padding: 7px 16px 16px; border-radius: 17px; background: #fff; text-align: left; box-shadow: 0 18px 55px rgba(0,0,0,.22); }
        .late-reason-grip { width: 40px; height: 4px; margin: 0 auto 14px; border-radius: 99px; background: #c4c9d9; }
        .late-reason-heading, .late-reason-count { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .late-reason-heading h2 { margin: 0; font-size: 1rem; }
        .late-reason-close { display: grid; width: 32px; height: 32px; place-items: center; border: 0; border-radius: 50%; background: #eef0ff; color: #475067; font-size: 1.15rem; cursor: pointer; }
        .late-reason-intro { margin: 7px 0; color: #51586b; font-size: .68rem; line-height: 1.4; }
        .late-reason-context { display: inline-block; margin-bottom: 11px; padding: 5px 8px; border-radius: 999px; background: #f1f2ff; color: #4b5263; font-size: .63rem; }
        .late-reason-count { margin-bottom: 6px; color: #202a40; font-size: .66rem; font-weight: 700; }
        .late-reason-count strong { color: #d52219; }
        .late-reason-count span { font-size: .61rem; }
        .late-reason-form textarea { width: 100%; min-height: 105px; resize: vertical; padding: 10px; border: 1px solid #e0e4ef; border-radius: 10px; background: #f0f2ff; color: #172033; font: inherit; font-size: .73rem; line-height: 1.5; }
        .late-reason-form textarea::placeholder { color: #7a8192; }
        .late-reason-quick-label { display: block; margin: 10px 0 6px; color: #465067; font-size: .59rem; }
        .late-reason-quick-options { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 10px; }
        .late-reason-quick-options button { padding: 5px 8px; border: 0; border-radius: 999px; background: #e6eaff; color: #283249; font: inherit; font-size: .57rem; cursor: pointer; }
        .late-reason-submit, .late-reason-cancel { width: 100%; min-height: 36px; border: 0; border-radius: 9px; font: inherit; font-size: .73rem; cursor: pointer; }
        .late-reason-submit { background: #7892e9; color: #fff; }
        .late-reason-cancel { margin-top: 5px; background: #e2e7ff; color: #172033; }
        .result-button.secondary { margin-top: 8px; background: #eef1ff; color: #214bd8; }
        .bottom-nav { position: fixed; z-index: 5; right: 0; bottom: 0; left: 0; display: grid; grid-template-columns: repeat(4, 1fr); width: min(100%, 430px); margin: 0 auto; padding: 9px 8px 8px; background: rgba(255,255,255,.96); box-shadow: 0 -6px 18px rgba(15,23,42,.05); }
        .nav-item { display: flex; flex-direction: column; align-items: center; gap: 4px; color: #70809e; font-size: .68rem; text-decoration: none; }
        .nav-item svg { width: 23px; height: 23px; fill: none; stroke: currentColor; stroke-linecap: round; stroke-linejoin: round; stroke-width: 1.8; }
        @media (max-width: 360px) { .attendance-shell { padding-right: 12px; padding-left: 12px; } .scanner-card { padding: 12px; } }
    </style>
</head>
<body>
    <div class="attendance-shell">
        <header class="attendance-header">
            <div class="user-badge">
                <strong>Debay, S.T.</strong>
                <small><?= htmlspecialchars($attendanceTitle, ENT_QUOTES, 'UTF-8') ?></small>
            </div>
            <div class="header-actions">
                <a class="header-icon" href="?page=notifikasi" aria-label="Notifikasi">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a4 4 0 0 1 4 4v1.2c0 1.1.4 2.1 1.1 2.9l1.3 1.6c.9 1.1.2 2.8-1.3 2.8H6.9c-1.5 0-2.2-1.7-1.3-2.8l1.3-1.6A4.7 4.7 0 0 0 8 8.2V7a4 4 0 0 1 4-4Zm0 18a2.7 2.7 0 0 1-2.6-2h5.2A2.7 2.7 0 0 1 12 21Z"/></svg>
                </a>
                <a class="avatar" href="?page=profil" aria-label="Profil user">D</a>
            </div>
        </header>

        <main class="attendance-content">
            <div class="attendance-topbar">
                <a class="back" href="./" aria-label="Kembali ke beranda">←</a>
                <h1 class="attendance-title"><?= htmlspecialchars($attendanceTitle, ENT_QUOTES, 'UTF-8') ?></h1>
            </div>
            <section class="time-panel">
                <div class="time-label"><?= $isCheckout ? 'Jam Pulang Presensi' : 'Jam Masuk Presensi' ?></div>
                <div class="time"><span id="attendance-clock"></span> <span class="timezone">WIB</span></div>
                <div class="date" id="attendance-date"></div>
            </section>
            <section class="scanner-card" aria-label="Pemindai barcode">
                <button class="scanner scan-trigger" id="scan-trigger" type="button" aria-label="Simulasikan pemindaian barcode">
                    <span class="corner top-left"></span>
                    <span class="corner top-right"></span>
                    <span class="corner bottom-left"></span>
                    <span class="corner bottom-right"></span>
                    <div class="scanner-focus">
                        <svg class="qr-icon" viewBox="0 0 40 40" aria-hidden="true">
                            <path fill="currentColor" d="M2 2h12v12H2zm3 3v6h6V5zm21-3h12v12H26zm3 3v6h6V5zM2 26h12v12H2zm3 3v6h6v-6zM18 3h4v4h-4zm0 7h4v4h-4zm-5 7h5v5h-5zm8-1h4v4h-4zm5 5h4v5h-4zm7-3h4v4h-4zm-13 2h4v4h-4zm-6 6h4v4h-4zm8 1h4v4h-4zm6 5h4v4h-4zm7-4h4v8h-4z"/>
                        </svg>
                        <span class="scan-hint">Fokuskan Barcode di Sini</span>
                    </div>
                    <span class="scan-line"></span>
                </button>
                <p class="demo-hint">Ketuk area pemindai untuk melihat hasil presensi.</p>
            </section>
        </main>
    </div>

    <nav class="bottom-nav" aria-label="Navigasi utama">
        <a class="nav-item" href="./"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg><span>Beranda</span></a>
        <a class="nav-item" href="?page=riwayat"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg><span>Riwayat</span></a>
        <a class="nav-item" href="?page=lembur"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg><span>Lembur</span></a>
        <a class="nav-item" href="?page=profil"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg><span>Profil</span></a>
    </nav>
    <div class="result-overlay" id="attendance-result" role="presentation" hidden>
        <section class="result-card" id="attendance-result-card" role="dialog" aria-modal="true" aria-labelledby="result-title" aria-describedby="result-description">
            <div class="result-icon" id="result-icon" aria-hidden="true">✓</div>
            <h2 id="result-title"></h2>
            <p class="result-description" id="result-description"></p>
            <div class="result-pills" id="result-pills"></div>
            <div class="result-details" id="result-details"></div>
            <button class="result-button secondary late-reason-launch" id="late-reason-open" type="button" hidden>Ajukan Alasan Keterlambatan</button>
            <a class="result-button" id="result-home" href="./">⌂ Kembali ke Beranda</a>
            <button class="result-button secondary" id="result-close" type="button" hidden>Kembali ke pemindai</button>
        </section>
    </div>
    <div class="network-overlay" id="network-offline-overlay" hidden>
        <section class="network-dialog" role="dialog" aria-modal="true" aria-labelledby="network-offline-title" aria-describedby="network-offline-description">
            <button class="network-close" id="network-offline-close" type="button" aria-label="Tutup">×</button>
            <div class="network-icon" aria-hidden="true">
                <svg viewBox="0 0 36 36"><path d="M5 13.5a20 20 0 0 1 22.6-1.7M9.5 18a13.5 13.5 0 0 1 14.3-1.1M14 22.5a7 7 0 0 1 5.7-.4M7 7l22 22M18 28h.01"/><circle class="alert-mark" cx="29" cy="7" r="7"/><path d="M29 3.5v4M29 10h.01" stroke="#fff"/></svg>
            </div>
            <h2 id="network-offline-title">Tidak Terhubung Ke Jaringan</h2>
            <p class="network-description" id="network-offline-description">Perangkat Anda kehilangan koneksi internet. Presensi barcode memerlukan jaringan aktif untuk validasi waktu presisi dan sinkronisasi server HR.</p>
            <div class="network-info">
                <div class="network-info-row"><span>◉ Status Jaringan</span><strong class="network-status-offline" id="network-offline-status">Terputus (Offline)</strong></div>
                <div class="network-info-row"><span>◷ Waktu Percobaan</span><strong id="network-offline-time"></strong></div>
            </div>
            <div class="network-warning">⚠ Pastikan data seluler atau Wi-Fi aktif. Data presensi tidak dapat direkam secara offline untuk mencegah manipulasi waktu.</div>
            <button class="network-retry" id="network-retry-button" type="button">↻ Coba Sambungkan Ulang</button>
        </section>
    </div>
    <div class="late-reason-overlay" id="late-reason-modal" role="presentation" hidden>
        <form class="late-reason-form" id="late-reason-form" role="dialog" aria-modal="true" aria-labelledby="late-reason-title">
            <div class="late-reason-grip"></div>
            <div class="late-reason-heading"><h2 id="late-reason-title">◈ Alasan Keterlambatan</h2><button class="late-reason-close" type="button" data-late-reason-close aria-label="Tutup">×</button></div>
            <p class="late-reason-intro">Beri penjelasan singkat mengenai keterlambatan presensi Anda hari ini untuk validasi tim HRD.</p>
            <div class="late-reason-context" id="late-reason-context">● Terlambat — menit • Shift Pagi (07:00 WIB)</div>
            <div class="late-reason-count"><label for="late-reason-input">Tuliskan Alasan Keterlambatan <strong>*</strong></label><span><b id="late-reason-length">0</b> / 250 karakter</span></div>
            <textarea id="late-reason-input" maxlength="250" required placeholder="Contoh: Terjadi kemacetan parah di jalan tol utama / kendala transportasi umum..."></textarea>
            <strong class="late-reason-quick-label">PILIH ALASAN CEPAT</strong>
            <div class="late-reason-quick-options">
                <button type="button" data-late-reason="Macet Lalu Lintas">▥ Macet Lalu Lintas</button>
                <button type="button" data-late-reason="Kendala Kendaraan">▣ Kendala Kendaraan</button>
                <button type="button" data-late-reason="Keperluan Mendesak">✱ Keperluan Mendesak</button>
                <button type="button" data-late-reason="Cuaca Hujan Deras">♧ Cuaca Hujan Deras</button>
            </div>
            <button class="late-reason-submit" type="submit">▷ Kirim Alasan</button>
            <button class="late-reason-cancel" type="button" data-late-reason-close>Batal</button>
        </form>
    </div>
    <script>
        const clock = document.getElementById('attendance-clock');
        const date = document.getElementById('attendance-date');
        const scannerTrigger = document.getElementById('scan-trigger');
        const scannerHint = document.querySelector('.demo-hint');
        const resultOverlay = document.getElementById('attendance-result');
        const resultCard = document.getElementById('attendance-result-card');
        const networkOfflineOverlay = document.getElementById('network-offline-overlay');
        const networkOfflineTime = document.getElementById('network-offline-time');
        const networkOfflineStatus = document.getElementById('network-offline-status');
        const networkRetryButton = document.getElementById('network-retry-button');
        let networkConnectionAvailable = navigator.onLine;
        let attendanceCheckInProgress = false;
        const lateReasonModal = document.getElementById('late-reason-modal');
        const lateReasonInput = document.getElementById('late-reason-input');
        const lateReasonButton = document.getElementById('late-reason-open');
        const isCheckout = <?= $isCheckout ? 'true' : 'false' ?>;
        function getAdminWorkSchedule() {
            const defaults = { workStart: '07:00', workEnd: '17:00', breakStart: '12:00', breakEnd: '13:00' };
            try {
                const schedule = JSON.parse(localStorage.getItem('attendance-admin-work-schedule') || 'null');
                if (!schedule || typeof schedule !== 'object') return defaults;
                const result = Object.fromEntries(Object.entries(defaults).map(([key, fallback]) => [
                    key,
                    typeof schedule[key] === 'string' && /^\d{2}:\d{2}$/.test(schedule[key]) ? schedule[key] : fallback
                ]));
                return result.workStart < result.breakStart &&
                    result.breakStart < result.breakEnd &&
                    result.breakEnd < result.workEnd ? result : defaults;
            } catch (error) {
                console.error('Could not read attendance-admin-work-schedule from local storage.', error);
                return defaults;
            }
        }
        const timeToSeconds = (value) => {
            const [hours, minutes] = value.split(':').map(Number);
            return hours * 3600 + minutes * 60;
        };
        const scheduleTimeLabel = (value) => value.replace(':', '.');
        const formatTime = (value) => new Intl.DateTimeFormat('en-GB', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hourCycle: 'h23',
            timeZone: 'Asia/Jakarta'
        }).format(value);
        const formatDateTime = (value) => `${new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            timeZone: 'Asia/Jakarta'
        }).format(value)} • ${formatTime(value)} WIB`;
        const jakartaParts = (value) => Object.fromEntries(new Intl.DateTimeFormat('en-GB', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hourCycle: 'h23',
            timeZone: 'Asia/Jakarta'
        }).formatToParts(value).map((part) => [part.type, part.value]));

        function updateAttendanceClock() {
            const now = new Date();
            clock.textContent = formatTime(now);
            date.textContent = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            }).format(now);
        }

        function updateScannerAvailability() {
            const parts = jakartaParts(new Date());
            const dateKey = `${parts.year}-${parts.month}-${parts.day}`;
            const storageKey = `attendance-${isCheckout ? 'checkout' : 'checkin'}-${dateKey}`;
            const recorded = localStorage.getItem(storageKey) === 'recorded';
            const nowSeconds = Number(parts.hour) * 3600 + Number(parts.minute) * 60 + Number(parts.second);
            const schedule = getAdminWorkSchedule();
            const workStartSeconds = timeToSeconds(schedule.workStart);
            const workEndSeconds = timeToSeconds(schedule.workEnd);
            const outsideAttendanceWindow = isCheckout
                ? nowSeconds < workEndSeconds
                : nowSeconds < workStartSeconds || nowSeconds >= workEndSeconds;
            const offline = !navigator.onLine || !networkConnectionAvailable;
            scannerTrigger.disabled = recorded || outsideAttendanceWindow || offline;
            scannerHint.textContent = recorded
                ? `Presensi ${isCheckout ? 'pulang' : 'masuk'} sudah dilakukan hari ini.`
                : isCheckout
                    ? nowSeconds < workEndSeconds
                        ? `Presensi pulang dibuka pukul ${scheduleTimeLabel(schedule.workEnd)} WIB.`
                        : `Presensi pulang dibuka pukul ${scheduleTimeLabel(schedule.workEnd)} WIB. ${offline ? 'Presensi memerlukan jaringan internet aktif.' : 'Ketuk area pemindai untuk melakukan absensi.'}`
                    : outsideAttendanceWindow
                        ? nowSeconds < workStartSeconds
                            ? `Presensi masuk dibuka pukul ${scheduleTimeLabel(schedule.workStart)} WIB.`
                            : `Waktu presensi masuk sudah ditutup pukul ${scheduleTimeLabel(schedule.workEnd)} WIB.`
                        : offline ? 'Presensi memerlukan jaringan internet aktif.' : 'Ketuk area pemindai untuk melihat hasil presensi.';
        }

        function updateNetworkOfflineTime() {
            networkOfflineTime.textContent = `${formatTime(new Date())} WIB`;
        }

        function showNetworkOffline() {
            networkConnectionAvailable = false;
            updateNetworkOfflineTime();
            networkOfflineStatus.textContent = 'Terputus (Offline)';
            networkOfflineStatus.classList.add('network-status-offline');
            networkOfflineOverlay.hidden = false;
            updateScannerAvailability();
        }

        async function checkNetworkConnection() {
            if (!navigator.onLine) return false;

            try {
                const response = await fetch(window.location.href, {
                    method: 'HEAD',
                    cache: 'no-store',
                    credentials: 'same-origin'
                });
                return response.ok;
            } catch (error) {
                if (error instanceof TypeError) return false;
                throw error;
            }
        }

        async function retryNetworkConnection() {
            networkRetryButton.disabled = true;
            networkRetryButton.textContent = 'Memeriksa koneksi...';
            networkOfflineStatus.textContent = 'Memeriksa...';
            networkOfflineStatus.classList.remove('network-status-offline');

            try {
                const connected = await checkNetworkConnection();
                networkConnectionAvailable = connected;
                if (connected) {
                    networkOfflineOverlay.hidden = true;
                    networkOfflineStatus.textContent = 'Terhubung (Online)';
                    updateScannerAvailability();
                    scannerTrigger.focus();
                    return;
                }

                networkOfflineStatus.textContent = 'Terputus (Offline)';
                networkOfflineStatus.classList.add('network-status-offline');
                updateNetworkOfflineTime();
            } finally {
                networkRetryButton.disabled = false;
                networkRetryButton.textContent = '↻ Coba Sambungkan Ulang';
            }
        }

        async function showAttendanceResult() {
            if (attendanceCheckInProgress) return;
            attendanceCheckInProgress = true;

            try {
                networkConnectionAvailable = await checkNetworkConnection();
            } catch (error) {
                attendanceCheckInProgress = false;
                updateScannerAvailability();
                throw error;
            }

            if (!networkConnectionAvailable) {
                showNetworkOffline();
                attendanceCheckInProgress = false;
                updateScannerAvailability();
                return;
            }
            const now = new Date();
            const parts = jakartaParts(now);
            const dateKey = `${parts.year}-${parts.month}-${parts.day}`;
            const attendanceStorageKey = `attendance-${isCheckout ? 'checkout' : 'checkin'}-${dateKey}`;
            const nowSeconds = Number(parts.hour) * 3600 + Number(parts.minute) * 60 + Number(parts.second);
            const schedule = getAdminWorkSchedule();
            const workStartSeconds = timeToSeconds(schedule.workStart);
            const workEndSeconds = timeToSeconds(schedule.workEnd);
            const outsideAttendanceWindow = isCheckout
                ? nowSeconds < workEndSeconds
                : nowSeconds < workStartSeconds || nowSeconds >= workEndSeconds;
            if (localStorage.getItem(attendanceStorageKey) === 'recorded') {
                attendanceCheckInProgress = false;
                updateScannerAvailability();
                return;
            }
            if (outsideAttendanceWindow) {
                attendanceCheckInProgress = false;
                updateScannerAvailability();
                return;
            }
            const lateSeconds = nowSeconds - (workStartSeconds + 15 * 60);
            const isLate = !isCheckout && lateSeconds > 0;
            const latenessMinutes = Math.ceil(lateSeconds / 60);
            const reference = `PRS-${parts.year}${parts.month}${parts.day}-${parts.hour}${parts.minute}${parts.second}`;
            const title = document.getElementById('result-title');
            const description = document.getElementById('result-description');
            const icon = document.getElementById('result-icon');
            const pills = document.getElementById('result-pills');
            const details = document.getElementById('result-details');
            const closeButton = document.getElementById('result-close');

            localStorage.setItem(attendanceStorageKey, 'recorded');
            if (!isCheckout && isLate) {
                localStorage.setItem(`attendance-checkin-lateness-${dateKey}`, String(lateSeconds));
            }
            updateScannerAvailability();

            resultCard.classList.toggle('late', isLate);
            icon.classList.toggle('warning', isLate);
            icon.textContent = isLate ? '!' : '✓';
            title.textContent = isLate ? 'Presensi Masuk Tercatat' : `${isCheckout ? 'Presensi Pulang' : 'Presensi Masuk'} Berhasil Dicatat!`;
            description.textContent = isLate
                ? 'Presensi berhasil dicatat, namun melewati batas toleransi masuk kerja.'
                : 'Data kehadiran Anda telah tercatat.';
            pills.innerHTML = isLate
                ? `<span class="result-pill">↪ Presensi Masuk</span><span class="result-pill late-pill">◷ Terlambat ${latenessMinutes} menit</span>`
                : `<span class="result-pill">● ${isCheckout ? 'Presensi Pulang (Clock-Out)' : 'Presensi Masuk (Clock-In)'}</span>`;
            details.innerHTML = isLate
                ? `<div class="result-row"><span>◷ Waktu Masuk</span><strong>${formatDateTime(now)}</strong></div><div class="result-row"><span>▣ Jadwal Shift</span><strong>${scheduleTimeLabel(schedule.workStart)} - ${scheduleTimeLabel(schedule.workEnd)} WIB</strong></div><div class="result-row"><span>◉ Batas Tepat Waktu</span><strong>Maks. ${scheduleTimeLabel(schedule.workStart)} WIB + 15 menit<br>(+${latenessMinutes} menit terlambat)</strong></div><div class="result-row"><span># ID Referensi</span><strong class="result-ref">#${reference}</strong></div>`
                : `<div class="result-row"><span>◷ Waktu &amp; Tanggal</span><strong>${formatDateTime(now)}</strong></div><div class="result-row"><span>ID Referensi</span><strong class="result-ref">#${reference}</strong></div>`;
            lateReasonButton.hidden = !isLate;
            lateReasonButton.textContent = 'Ajukan Alasan Keterlambatan';
            if (isLate) {
                const dateKey = `${parts.year}-${parts.month}-${parts.day}`;
                const savedReason = localStorage.getItem(`attendance-late-reason-${dateKey}`) || '';
                document.getElementById('late-reason-context').textContent = `● Terlambat ${latenessMinutes} Menit • Jam masuk ${scheduleTimeLabel(schedule.workStart)} WIB`;
                lateReasonInput.value = savedReason;
                document.getElementById('late-reason-length').textContent = String(savedReason.length);
                if (savedReason) lateReasonButton.textContent = 'Alasan Keterlambatan Terkirim';
            }
            closeButton.hidden = !isLate;
            resultOverlay.hidden = false;
            closeButton.focus();
            attendanceCheckInProgress = false;
        }

        scannerTrigger.addEventListener('click', showAttendanceResult);
        networkRetryButton.addEventListener('click', retryNetworkConnection);
        document.getElementById('network-offline-close').addEventListener('click', () => {
            networkOfflineOverlay.hidden = true;
            scannerTrigger.focus();
        });
        window.addEventListener('offline', showNetworkOffline);
        window.addEventListener('online', async () => {
            const connected = await checkNetworkConnection();
            networkConnectionAvailable = connected;
            if (connected) networkOfflineOverlay.hidden = true;
            else showNetworkOffline();
            updateScannerAvailability();
        });
        lateReasonButton.addEventListener('click', () => {
            lateReasonModal.hidden = false;
            lateReasonInput.focus();
        });
        document.querySelectorAll('[data-late-reason-close]').forEach((button) => {
            button.addEventListener('click', () => {
                lateReasonModal.hidden = true;
                lateReasonButton.focus();
            });
        });
        lateReasonModal.addEventListener('click', (event) => {
            if (event.target === lateReasonModal) {
                lateReasonModal.hidden = true;
                lateReasonButton.focus();
            }
        });
        lateReasonInput.addEventListener('input', () => {
            document.getElementById('late-reason-length').textContent = String(lateReasonInput.value.length);
        });
        document.querySelectorAll('[data-late-reason]').forEach((button) => {
            button.addEventListener('click', () => {
                const quickReason = button.dataset.lateReason;
                lateReasonInput.value = lateReasonInput.value
                    ? `${lateReasonInput.value.trim()}${lateReasonInput.value.trim().endsWith('.') ? ' ' : '. '}${quickReason}`
                    : quickReason;
                lateReasonInput.value = lateReasonInput.value.slice(0, 250);
                lateReasonInput.dispatchEvent(new Event('input'));
                lateReasonInput.focus();
            });
        });
        document.getElementById('late-reason-form').addEventListener('submit', (event) => {
            event.preventDefault();
            const parts = jakartaParts(new Date());
            const reason = lateReasonInput.value.trim();
            if (!reason) {
                lateReasonInput.reportValidity();
                return;
            }
            const dateKey = `${parts.year}-${parts.month}-${parts.day}`;
            const storageKey = 'attendance-late-requests';
            const savedRequests = JSON.parse(localStorage.getItem(storageKey) || '[]');
            const requestList = Array.isArray(savedRequests) ? savedRequests : [];
            const existing = requestList.find((entry) => entry && entry.dateKey === dateKey && entry.employee === 'Debay, S.T.');
            const recordedLateSeconds = Number(localStorage.getItem(`attendance-checkin-lateness-${dateKey}`) || 0);
            const entry = {
                id: existing ? existing.id : `late-${Date.now()}`,
                employee: 'Debay, S.T.',
                role: 'Senior UI/UX Designer',
                dateKey,
                reason,
                status: 'pending',
                delayMinutes: Math.ceil(recordedLateSeconds / 60),
                recordedAt: new Date().toISOString(),
            };
            if (existing) {
                Object.assign(existing, entry);
            } else {
                requestList.unshift(entry);
            }
            localStorage.setItem(storageKey, JSON.stringify(requestList));
            localStorage.setItem(`attendance-late-reason-${dateKey}`, reason);
            lateReasonModal.hidden = true;
            lateReasonButton.textContent = 'Alasan Keterlambatan Terkirim';
            lateReasonButton.focus();
        });
        document.getElementById('result-close').addEventListener('click', () => {
            resultOverlay.hidden = true;
            lateReasonModal.hidden = true;
            scannerTrigger.focus();
        });
        resultOverlay.addEventListener('click', (event) => {
            if (event.target === resultOverlay) {
                resultOverlay.hidden = true;
                scannerTrigger.focus();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !resultOverlay.hidden) {
                if (!lateReasonModal.hidden) {
                    lateReasonModal.hidden = true;
                    lateReasonButton.focus();
                } else {
                    resultOverlay.hidden = true;
                    scannerTrigger.focus();
                }
            }
        });

        updateAttendanceClock();
        updateScannerAvailability();
        showNetworkOffline();
        window.setInterval(updateAttendanceClock, 1000);
        window.setInterval(updateScannerAvailability, 1000);
        window.setInterval(() => {
            if (!networkOfflineOverlay.hidden) updateNetworkOfflineTime();
        }, 1000);
    </script>
</body>
</html>
<?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debay, S.T. · Dashboard Karyawan</title>
    <style>
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            min-height: 100%;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #eef1f5;
            color: #1f2937;
        }
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 18px 0;
        }
        .app-shell {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .screen {
            width: min(92vw, 430px);
            background: #edf1f5;
            padding: 14px 14px 90px;
        }
        .dashboard-bottom-nav {
            position: fixed;
            z-index: 10;
            right: 0;
            bottom: 0;
            left: 0;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            width: min(100%, 430px);
            margin: 0 auto;
            padding: 9px 8px calc(8px + env(safe-area-inset-bottom));
            border-radius: 16px 16px 0 0;
            background: rgba(255, 255, 255, 0.97);
            box-shadow: 0 -6px 18px rgba(15, 23, 42, 0.05);
        }
        .dashboard-bottom-nav .nav-item {
            display: flex;
            min-width: 0;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: #626d82;
            font-size: 0.66rem;
            text-decoration: none;
        }
        .dashboard-bottom-nav .nav-item.active {
            color: #1749e8;
        }
        .dashboard-bottom-nav .nav-item svg {
            width: 23px;
            height: 23px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 1.8;
        }
        .greeting-bar,
        .clock-card,
        .attendance-row,
        .section-card,
        .summary-card,
        .history-item {
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.72);
            box-shadow: 0 8px 16px rgba(90, 100, 120, 0.06);
        }
        .greeting-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            font-size: 1.02rem;
            font-weight: 700;
            color: #1f2a37;
            margin-bottom: 14px;
        }
        .greeting-bar .wave { font-size: 1.5rem; }
        .clock-card {
            background: linear-gradient(135deg, #0e4ec4 0%, #0e62d9 100%);
            color: #fff;
            padding: 18px 18px 16px;
            min-height: 144px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 12px 24px rgba(22, 84, 182, 0.25);
        }
        .date-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            opacity: 0.96;
            margin-bottom: 10px;
        }
        .calendar-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            font-size: 1rem;
        }
        .time-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            margin-bottom: 8px;
        }
        .time-row .time {
            font-size: clamp(2.2rem, 5vw, 3.1rem);
            letter-spacing: 1px;
            font-weight: 800;
            line-height: 1;
        }
        .time-row .timezone {
            font-size: 0.9rem;
            font-weight: 700;
            opacity: 0.9;
            letter-spacing: 0.04em;
        }
        .status-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .live-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #7fe1b3;
            box-shadow: 0 0 0 4px rgba(127, 225, 179, 0.16);
        }
        .attendance-row {
            display: grid;
            grid-template-columns: 52px 1fr 30px;
            align-items: center;
            padding: 12px 14px 12px 12px;
            background: rgba(255, 255, 255, 0.7);
            margin-top: 14px;
            min-height: 74px;
            color: inherit;
            cursor: pointer;
            text-decoration: none;
        }
        .attendance-row:hover,
        .attendance-row:focus-visible {
            outline: 2px solid #2a69dd;
            outline-offset: 2px;
        }
        .attendance-row.is-locked { opacity: .62; cursor: not-allowed; pointer-events: none; }
        .action-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(180deg, #2a69dd 0%, #285fce 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .action-copy {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 0 10px;
        }
        .action-copy strong {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1d2736;
        }
        .action-copy small {
            font-size: 0.78rem;
            color: #6b7280;
            font-weight: 600;
        }
        .title-line { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .checkin-badge { padding: 4px 9px; border-radius: 999px; background: #dbe7ff; color: #1749c8; font-size: .68rem; font-weight: 700; white-space: nowrap; }
        .checkin-badge[hidden] { display: none; }
        .checkout-badge { padding: 4px 9px; border-radius: 999px; background: #edf2f7; color: #5b6478; font-size: .68rem; font-weight: 700; white-space: nowrap; }
        .checkout-badge[hidden] { display: none; }
        .action-chevron {
            color: #7a8499;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
            justify-self: end;
        }
        .attendance-lock-icon { display: block; width: 18px; height: 18px; }
        .attendance-row.pulang.is-locked .action-chevron {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #edf2f7;
            color: #7a8499;
        }
        .attendance-row.pulang .action-icon {
            background: linear-gradient(180deg, #2a69dd 0%, #285fce 100%);
            color: #fff;
        }
        .attendance-row.pulang.is-locked {
            background: #fff;
            color: #1d2736;
            opacity: 1;
        }
        .attendance-row.pulang.is-locked .action-copy strong,
        .attendance-row.pulang.is-locked .action-copy small { color: #1d2736; }
        .attendance-row.pulang.is-recorded {
            background: rgba(255, 255, 255, 0.7);
            opacity: 0.62;
        }
        .attendance-row.pulang.is-available {
            background: #fff;
            color: #1d2736;
            box-shadow: 0 8px 16px rgba(90, 100, 120, 0.1);
        }
        .attendance-row.pulang.is-available .action-icon { background: linear-gradient(180deg, #2a69dd 0%, #285fce 100%); color: #fff; }
        .attendance-row.pulang.is-available .action-copy strong,
        .attendance-row.pulang.is-available .action-copy small { color: #1d2736; }
        .attendance-row.pulang.is-available .action-chevron { color: #7a8499; }
        .section-card {
            margin-top: 20px;
            padding: 16px 14px 12px;
            background: rgba(255, 255, 255, 0.62);
        }
        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }
        .section-card h2 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 800;
            color: #1d2736;
        }
        .month-switch {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1d5edb;
            font-weight: 700;
            font-size: 0.95rem;
        }
        .month-switch button {
            width: 28px;
            height: 28px;
            border: none;
            background: transparent;
            color: #1d5edb;
            font-size: 1.5rem;
            line-height: 1;
            cursor: pointer;
            padding: 0;
        }
        .month-label {
            white-space: nowrap;
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 8px 8px;
            margin-top: 8px;
        }
        .day-name, .day-cell {
            text-align: center;
            font-size: 0.82rem;
        }
        .day-name {
            color: #6d7687;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .day-cell {
            width: 100%;
            aspect-ratio: 1 / 1;
            padding: 0;
            border: 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #273446;
            font-weight: 600;
            background: transparent;
            position: relative;
            cursor: pointer;
            font-family: inherit;
        }
        .day-cell.muted { color: #a1a9b7; }
        .day-name.sunday,
        .day-cell.holiday { color: #dc2626; }
        .day-cell.attended:not(.holiday) { color: #16834a; }
        .day-cell.holiday:not(.selected) { color: #dc2626; }
        .day-cell.selected {
            background: #1f63df;
            color: #fff;
            box-shadow: 0 8px 12px rgba(31, 99, 223, 0.18);
        }
        .day-cell:not(.muted):not(.selected)::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #d7dbe4;
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
        }
        .day-cell.selected::before { display: none; }
        .day-cell.attended:not(.selected)::before { background: #30c47d; }
        .day-cell.holiday:not(.selected)::before { background: #dc2626; }
        .day-cell.selected.attended::after,
        .day-cell.selected.holiday::after {
            content: "";
            position: absolute;
            bottom: 5px;
            left: 50%;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #d7dbe4;
            transform: translateX(-50%);
        }
        .day-cell.selected.attended::after { background: #7fe1b3; }
        .day-cell.selected.holiday::after { background: #fecaca; }
        .legend {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-top: 14px;
            color: #4b5563;
            font-size: 0.86rem;
            font-weight: 600;
        }
        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }
        .legend-dot.green { background: #30c47d; }
        .legend-dot.red { background: #dc2626; }
        .calendar-date-details { margin-top: 12px; padding: 11px 12px; border-radius: 11px; background: #f0f3fb; color: #30384b; font-size: .72rem; line-height: 1.45; }
        .calendar-date-details > strong { display: block; font-size: .76rem; }
        .calendar-date-note, .calendar-date-schedule { margin: 5px 0 0; }
        .calendar-date-note small, .calendar-date-schedule { color: #697386; }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            margin-top: 18px;
        }
        .summary-card {
            background: rgba(255, 255, 255, 0.72);
            padding: 14px 10px 12px;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .summary-card .label {
            color: #556070;
            font-weight: 700;
            font-size: 0.78rem;
        }
        .summary-card strong {
            font-size: clamp(1.7rem, 3vw, 2.3rem);
            line-height: 1;
            color: #1f2937;
        }
        .summary-value-row {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 8px;
            margin-bottom: 4px;
        }
        .summary-inline-label {
            color: #16834a;
            font-size: .72rem;
            font-weight: 700;
        }
        .summary-inline-detail {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #8a5b00;
            font-size: .68rem;
            font-weight: 700;
        }
        .summary-inline-detail--ontime {
            color: #16834a;
            font-size: .78rem;
        }
        .summary-card .tag-row {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #69758b;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .dot {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
        }
        .dot.green { background: #2ec679; }
        .dot.yellow { background: #f2c230; }
        .dot.blue { background: #58a5ff; }
        .dot.red { background: #ff6b6b; }
        .history { margin-top: 18px; }
        .history-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }
        .history-header h3 {
            margin: 0;
            font-size: 1.02rem;
            font-weight: 800;
            color: #1f2a37;
        }
        .history-header a {
            text-decoration: none;
            color: #3d6fe4;
            font-size: 0.82rem;
            font-weight: 700;
        }
        .history-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .history-item {
            display: grid;
            grid-template-columns: 72px 1fr auto;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.66);
            padding: 12px 12px;
        }
        .day-tag {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 56px;
            border-radius: 12px;
            background: #ebf0fb;
            color: #1d5edb;
            font-weight: 800;
            text-transform: uppercase;
        }
        .day-tag strong {
            font-size: 1.15rem;
            line-height: 1;
        }
        .day-tag span {
            font-size: 0.68rem;
            letter-spacing: 0.04em;
            opacity: 0.8;
            margin-top: 4px;
        }
        .meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }
        .time-line {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #21324d;
            white-space: nowrap;
        }
        .time-line .shift { font-weight: 800; }
        .location {
            color: #677185;
            font-size: 0.78rem;
            font-weight: 600;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .badge {
            border: none;
            padding: 8px 10px;
            border-radius: 10px;
            font-size: 0.74rem;
            font-weight: 800;
            cursor: pointer;
            min-width: 92px;
            text-align: center;
            white-space: nowrap;
        }
        .badge.green {
            background: #dff8eb;
            color: #1f9d60;
        }
        .badge.gray {
            background: #eef2f7;
            color: #61708a;
        }
        @media (max-width: 420px) {
            .screen { width: 100%; }
            .summary-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .history-item { grid-template-columns: 62px 1fr; }
            .badge {
                grid-column: 2;
                justify-self: start;
                margin-top: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <div class="screen">
            <div class="greeting-bar">
                <span id="dashboard-greeting">Selamat Pagi, Debay!</span>
                <span class="dashboard-actions">
                    <a class="dashboard-notification" href="?page=notifikasi" aria-label="Notifikasi">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a4 4 0 0 1 4 4v1.2c0 1.1.4 2.1 1.1 2.9l1.3 1.6c.9 1.1.2 2.8-1.3 2.8H6.9c-1.5 0-2.2-1.7-1.3-2.8l1.3-1.6A4.7 4.7 0 0 0 8 8.2V7a4 4 0 0 1 4-4Zm0 18a2.7 2.7 0 0 1-2.6-2h5.2A2.7 2.7 0 0 1 12 21Z"/></svg>
                    </a>
                    <span class="wave">👋</span>
                </span>
            </div>

            <div class="clock-card">
                <div class="date-row">
                    <span class="calendar-badge">📅</span>
                    <span id="dashboard-date"></span>
                </div>

                <div class="time-row">
                    <span class="time" id="dashboard-time"></span>
                    <span class="timezone">WIB</span>
                </div>

                <div class="status-row">
                    <span class="live-dot"></span>
                    <span id="attendance-deadline-status"></span>
                </div>
            </div>

            <a class="attendance-row attendance-row--checkin" href="?page=presensi-masuk">
                <div class="action-icon">→</div>
                <div class="action-copy">
                    <div class="title-line">
                        <strong>Presensi Masuk</strong>
                        <span class="checkin-badge" hidden>Berhasil Hadir</span>
                    </div>
                    <small class="attendance-status">Tap untuk Melakukan Absensi</small>
                </div>
                <div class="action-chevron">→</div>
            </a>

            <a class="attendance-row pulang attendance-row--checkout is-locked" href="?page=presensi-pulang" aria-disabled="true" tabindex="-1">
                <div class="action-icon">→</div>
                <div class="action-copy">
                    <div class="title-line">
                        <strong>Presensi Pulang</strong>
                        <span class="checkout-badge">Terkunci</span>
                    </div>
                    <small class="attendance-status">Tersedia mulai pukul 17.00 WIB</small>
                </div>
                <div class="action-chevron" aria-hidden="true"><svg class="attendance-lock-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="2"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3"></path></svg></div>
            </a>

            <div class="section-card" id="calendar">
                <div class="calendar-header">
                    <h2>Kalender Kerja &amp; Shift</h2>
                    <div class="month-switch">
                        <button type="button" id="calendar-previous" aria-label="Bulan sebelumnya">‹</button>
                        <span class="month-label" id="calendar-month"></span>
                        <button type="button" id="calendar-next" aria-label="Bulan selanjutnya">›</button>
                    </div>
                </div>

                <div class="calendar-grid" id="calendar-grid" aria-label="Tanggal pada kalender"></div>

                <div class="legend">
                    <span class="legend-item"><span class="legend-dot green"></span> Hadir</span>
                    <span class="legend-item"><span class="legend-dot red"></span> Hari Libur</span>
                </div>
                <div class="calendar-date-details" id="calendar-date-details" aria-live="polite"></div>
            </div>

            <div class="summary-grid">
                <div class="summary-card">
                    <div class="label">Tepat Waktu</div>
                    <div class="summary-value-row">
                        <strong>21</strong>
                        <span class="summary-inline-detail summary-inline-detail--ontime">Hari</span>
                    </div>
                    <div class="tag-row"><span class="dot green"></span> Bulan ini</div>
                </div>

                <div class="summary-card">
                    <div class="label">Terlambat</div>
                    <div class="summary-value-row">
                        <strong id="late-attendance-count">1</strong>
                        <span class="summary-inline-detail" id="late-attendance-duration">Belum tercatat</span>
                    </div>
                    <div class="tag-row"><span class="dot yellow"></span> Durasi total bulan ini</div>
                </div>

                <div class="summary-card">
                    <div class="label">Lembur</div>
                    <strong>4.5</strong>
                    <div class="tag-row"><span class="dot blue"></span> Jam</div>
                </div>

                <div class="summary-card">
                    <div class="label">Total</div>
                    <strong>4.5</strong>
                    <div class="tag-row"><span class="dot red"></span> Jam</div>
                </div>
            </div>

            <div class="history">
                <div class="history-header">
                    <h3>Riwayat Pekerja</h3>
                    <a href="?page=riwayat">Lihat Semua</a>
                </div>

                <div class="history-list">
                    <div class="history-item">
                        <div class="day-tag">
                            <strong>23</strong>
                            <span>RAB</span>
                        </div>
                        <div class="meta">
                            <div class="time-line">
                                <span class="shift">08:24 – 17:35</span>
                                <span>WIB</span>
                            </div>
                            <div class="location">Kantor Pusat HQ</div>
                        </div>
                        <button class="badge green" type="button">Tepat Waktu</button>
                    </div>

                    <div class="history-item">
                        <div class="day-tag">
                            <strong>21</strong>
                            <span>SEN</span>
                        </div>
                        <div class="meta">
                            <div class="time-line">
                                <span class="shift">08:29 – 17:40</span>
                                <span>WIB</span>
                            </div>
                            <div class="location">Kantor Pusat HQ</div>
                        </div>
                        <button class="badge green" type="button">Tepat Waktu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="bottom-nav dashboard-bottom-nav" aria-label="Navigasi utama">
        <a class="nav-item active" href="./"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg></span><span class="nav-label">Beranda</span></a>
        <a class="nav-item" href="?page=riwayat"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg></span><span class="nav-label">Riwayat</span></a>
        <a class="nav-item" href="?page=lembur"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg></span><span class="nav-label">Lembur</span></a>
        <a class="nav-item" href="?page=profil"><span class="nav-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg></span><span class="nav-label">Profil</span></a>
    </nav>
    <script>
        const dashboardDate = document.getElementById('dashboard-date');
        const dashboardTime = document.getElementById('dashboard-time');
        const dashboardGreeting = document.getElementById('dashboard-greeting');
        const attendanceDeadlineStatus = document.getElementById('attendance-deadline-status');
        const checkinBadge = document.querySelector('.checkin-badge');
        const jakartaClockFormatter = new Intl.DateTimeFormat('en-GB', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hourCycle: 'h23',
            timeZone: 'Asia/Jakarta'
        });
        const jakartaDateFormatter = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            timeZone: 'Asia/Jakarta'
        });
        const calendarMonth = document.getElementById('calendar-month');
        const calendarGrid = document.getElementById('calendar-grid');
        const calendarDayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        const todayInJakarta = new Intl.DateTimeFormat('en-CA', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            timeZone: 'Asia/Jakarta'
        }).formatToParts(new Date());
        const todayParts = Object.fromEntries(todayInJakarta.map((part) => [part.type, part.value]));
        let visibleCalendarYear = Number(todayParts.year);
        let visibleCalendarMonth = Number(todayParts.month) - 1;
        let selectedCalendarDate = `${todayParts.year}-${todayParts.month}-${todayParts.day}`;
        const calendarDateDetails = document.getElementById('calendar-date-details');

        function readAdminHoliday(dateKey) {
            try {
                const holidays = JSON.parse(localStorage.getItem('attendance-admin-holidays') || '[]');
                if (!Array.isArray(holidays)) {
                    console.error('Expected attendance-admin-holidays in local storage to contain an array.');
                    return null;
                }
                return holidays.find((entry) => entry && entry.date === dateKey && typeof entry.name === 'string') || null;
            } catch (error) {
                console.error('Could not read attendance-admin-holidays from local storage.', error);
                return null;
            }
        }

        function readAdminSchedule() {
            const defaults = { workStart: '07:00', workEnd: '17:00', breakStart: '12:00', breakEnd: '13:00' };
            try {
                const schedule = JSON.parse(localStorage.getItem('attendance-admin-work-schedule') || 'null');
                if (!schedule || typeof schedule !== 'object') return defaults;
                return Object.fromEntries(Object.entries(defaults).map(([key, fallback]) => [
                    key,
                    typeof schedule[key] === 'string' && /^\d{2}:\d{2}$/.test(schedule[key]) ? schedule[key] : fallback
                ]));
            } catch (error) {
                console.error('Could not read attendance-admin-work-schedule from local storage.', error);
                return defaults;
            }
        }

        function escapeCalendarText(value) {
            return String(value).replace(/[&<>"']/g, (character) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;',
            })[character]);
        }

        function formatLatenessDuration(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            const parts = [];

            if (hours) parts.push(`${hours} jam`);
            if (minutes) parts.push(`${minutes} menit`);
            if (seconds || parts.length === 0) parts.push(`${seconds} detik`);

            return parts.join(' ');
        }

        function updateAttendanceSummary() {
            const monthPrefix = `attendance-checkin-lateness-${todayParts.year}-${todayParts.month}-`;
            const lateSeconds = Object.keys(localStorage)
                .filter((key) => key.startsWith(monthPrefix))
                .map((key) => Number(localStorage.getItem(key)))
                .filter((seconds) => Number.isFinite(seconds) && seconds > 0);

            if (lateSeconds.length === 0) return;

            document.getElementById('late-attendance-count').textContent = String(lateSeconds.length);
            document.getElementById('late-attendance-duration').textContent = formatLatenessDuration(
                lateSeconds.reduce((total, seconds) => total + seconds, 0)
            );
        }

        function renderCalendar() {
            const monthStart = new Date(Date.UTC(visibleCalendarYear, visibleCalendarMonth, 1));
            const monthEnd = new Date(Date.UTC(visibleCalendarYear, visibleCalendarMonth + 1, 0));
            const leadingDays = (monthStart.getUTCDay() + 6) % 7;
            const cellCount = Math.ceil((leadingDays + monthEnd.getUTCDate()) / 7) * 7;

            calendarMonth.textContent = new Intl.DateTimeFormat('id-ID', {
                month: 'long',
                year: 'numeric',
                timeZone: 'UTC'
            }).format(monthStart);

            const cells = calendarDayNames
                .map((name, index) => `<div class="day-name${index === 6 ? ' sunday' : ''}">${name}</div>`)
                .join('');
            const dates = Array.from({ length: cellCount }, (_, index) => {
                const date = new Date(Date.UTC(visibleCalendarYear, visibleCalendarMonth, index - leadingDays + 1));
                const isCurrentMonth = date.getUTCMonth() === visibleCalendarMonth;
                const dateKey = date.toISOString().slice(0, 10);
                const holiday = readAdminHoliday(dateKey);
                const holidayName = holiday?.name;
                const safeHolidayName = holidayName ? escapeCalendarText(holidayName) : '';
                const isHoliday = Boolean(holidayName);
                const isAttended = isCurrentMonth && localStorage.getItem(`attendance-checkin-${dateKey}`) === 'recorded';
                const classes = ['day-cell'];

                if (!isCurrentMonth) classes.push('muted');
                if (isCurrentMonth && isHoliday) classes.push('holiday');
                if (isAttended) classes.push('attended');
                if (dateKey === selectedCalendarDate) classes.push('selected');

                const status = isHoliday ? safeHolidayName : isAttended ? 'Hadir' : '';
                const label = `${date.getUTCDate()} ${new Intl.DateTimeFormat('id-ID', { month: 'long', timeZone: 'UTC' }).format(date)} ${date.getUTCFullYear()}${status ? `, ${status}` : ''}`;

                return `<button type="button" class="${classes.join(' ')}" data-calendar-date="${dateKey}" aria-label="${label}" aria-pressed="${dateKey === selectedCalendarDate}"${status ? ` title="${status}"` : ''}>${date.getUTCDate()}</button>`;
            }).join('');

            calendarGrid.innerHTML = cells + dates;
            renderCalendarDateDetails();
        }

        function renderCalendarDateDetails() {
            const date = new Date(`${selectedCalendarDate}T00:00:00Z`);
            const holiday = readAdminHoliday(selectedCalendarDate);
            const attended = localStorage.getItem(`attendance-checkin-${selectedCalendarDate}`) === 'recorded';
            const schedule = readAdminSchedule();
            const dateLabel = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                timeZone: 'UTC'
            }).format(date);
            const status = holiday ? 'Hari Libur' : attended ? 'Hadir' : 'Jadwal Kerja';
            const note = holiday
                ? `<p class="calendar-date-note"><strong>Keterangan Admin:</strong> ${escapeCalendarText(holiday.name)}${holiday.createdBy ? ` <small>· Ditentukan oleh ${escapeCalendarText(holiday.createdBy)}</small>` : ''}</p>`
                : '<p class="calendar-date-note">Tidak ada keterangan hari libur dari Admin.</p>';

            calendarDateDetails.innerHTML = `
                <strong>${escapeCalendarText(dateLabel)} · ${status}</strong>
                ${note}
                <p class="calendar-date-schedule">Kerja ${schedule.workStart}–${schedule.workEnd} WIB · Istirahat ${schedule.breakStart}–${schedule.breakEnd} WIB</p>
            `;
        }

        calendarGrid.addEventListener('click', (event) => {
            const day = event.target.closest('[data-calendar-date]');
            if (!day) return;
            selectedCalendarDate = day.dataset.calendarDate;
            const [year, month] = selectedCalendarDate.split('-').map(Number);
            visibleCalendarYear = year;
            visibleCalendarMonth = month - 1;
            renderCalendar();
        });

        window.addEventListener('storage', (event) => {
            if (event.key === 'attendance-admin-holidays' ||
                event.key === 'attendance-admin-work-schedule' ||
                event.key?.startsWith('attendance-checkin-')) {
                renderCalendar();
            }
        });

        function updateDashboardClock() {
            const now = new Date();
            const parts = jakartaClockFormatter.formatToParts(now);
            const value = (type) => Number(parts.find((part) => part.type === type).value);
            const hour = value('hour');
            const minute = value('minute');
            const second = value('second');
            const currentSeconds = hour * 3600 + minute * 60 + second;
            const schedule = readAdminSchedule();
            const workStartSeconds = timeToSeconds(schedule.workStart);
            const workEndSeconds = timeToSeconds(schedule.workEnd);
            const onTimeUntilSeconds = workStartSeconds + 15 * 60;

            dashboardDate.textContent = jakartaDateFormatter.format(now);
            dashboardTime.textContent = jakartaClockFormatter.format(now);
            dashboardGreeting.textContent = `${hour >= 4 && hour < 11 ? 'Selamat Pagi' : hour < 15 ? 'Selamat Siang' : hour < 18 ? 'Selamat Sore' : 'Selamat Malam'}, Debay!`;
            attendanceDeadlineStatus.textContent = currentSeconds < workStartSeconds
                ? `Presensi masuk dibuka pukul ${schedule.workStart} WIB`
                : currentSeconds <= onTimeUntilSeconds
                    ? `Batas tepat waktu hingga pukul ${formatSecondsAsTime(onTimeUntilSeconds)} WIB`
                    : currentSeconds < workEndSeconds
                        ? `Lewat batas tepat waktu; presensi masuk ditutup pukul ${schedule.workEnd} WIB`
                        : `Presensi masuk ditutup pukul ${schedule.workEnd} WIB`;
        }

        function timeToSeconds(value) {
            const [hours, minutes] = value.split(':').map(Number);
            return hours * 3600 + minutes * 60;
        }

        function formatSecondsAsTime(totalSeconds) {
            const hours = String(Math.floor(totalSeconds / 3600) % 24).padStart(2, '0');
            const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            return `${hours}.${minutes}`;
        }

        (function () {
            const checkin = document.querySelector('.attendance-row--checkin');
            const checkout = document.querySelector('.attendance-row--checkout');
            const checkinStatus = checkin.querySelector('.attendance-status');
            const checkinBadge = checkin.querySelector('.checkin-badge');
            const checkoutStatus = checkout.querySelector('.attendance-status');
            const checkoutBadge = checkout.querySelector('.checkout-badge');
            const checkoutIndicator = checkout.querySelector('.action-chevron');
            const lockIcon = '<svg class="attendance-lock-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="2"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3"></path></svg>';

            function getJakartaDateKey() {
                const parts = new Intl.DateTimeFormat('en-CA', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    timeZone: 'Asia/Jakarta'
                }).formatToParts(new Date());
                const value = (type) => parts.find((part) => part.type === type).value;

                return `${value('year')}-${value('month')}-${value('day')}`;
            }

            function getJakartaSeconds() {
                const parts = new Intl.DateTimeFormat('en-GB', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hourCycle: 'h23',
                    timeZone: 'Asia/Jakarta'
                }).formatToParts(new Date());
                const value = (type) => Number(parts.find((part) => part.type === type).value);

                return value('hour') * 3600 + value('minute') * 60 + value('second');
            }

            function updateAttendanceActions() {
                const now = getJakartaSeconds();
                const dateKey = getJakartaDateKey();
                const schedule = readAdminSchedule();
                const workStartSeconds = timeToSeconds(schedule.workStart);
                const workEndSeconds = timeToSeconds(schedule.workEnd);
                const checkinRecorded = localStorage.getItem(`attendance-checkin-${dateKey}`) === 'recorded';
                const checkoutRecorded = localStorage.getItem(`attendance-checkout-${dateKey}`) === 'recorded';
                const checkinAvailable = now >= workStartSeconds && now < workEndSeconds;
                const canCheckout = now >= workEndSeconds && !checkoutRecorded;
                const canCheckin = checkinAvailable && !checkinRecorded;

                checkin.classList.toggle('is-locked', !canCheckin);
                checkin.setAttribute('aria-disabled', String(!canCheckin));
                if (checkinRecorded) {
                    checkin.setAttribute('tabindex', '-1');
                    checkinBadge.hidden = false;
                    checkinStatus.textContent = 'Presensi masuk sudah dilakukan hari ini';
                } else if (!checkinAvailable) {
                    checkin.setAttribute('tabindex', '-1');
                    checkinBadge.hidden = true;
                    checkinStatus.textContent = now < workStartSeconds
                        ? `Presensi masuk dibuka pukul ${schedule.workStart}`
                        : `Presensi masuk ditutup pukul ${schedule.workEnd}`;
                } else {
                    checkin.removeAttribute('tabindex');
                    checkinBadge.hidden = true;
                    checkinStatus.textContent = now <= workStartSeconds + 15 * 60
                        ? `Tepat waktu sampai ${formatSecondsAsTime(workStartSeconds + 15 * 60)}; presensi ditutup ${schedule.workEnd}`
                        : `Status terlambat; presensi ditutup ${schedule.workEnd}`;
                }

                checkout.classList.toggle('is-locked', !canCheckout);
                checkout.classList.toggle('is-recorded', checkoutRecorded);
                checkout.classList.toggle('is-available', canCheckout);
                checkout.setAttribute('aria-disabled', String(!canCheckout));
                if (canCheckout) {
                    checkout.removeAttribute('tabindex');
                    checkoutBadge.hidden = true;
                    checkoutStatus.textContent = 'Absensi sudah bisa dibuka';
                    checkoutIndicator.textContent = '→';
                } else if (checkoutRecorded) {
                    checkout.setAttribute('tabindex', '-1');
                    checkoutBadge.hidden = false;
                    checkoutBadge.textContent = 'Berhasil Pulang';
                    checkoutStatus.textContent = 'Presensi pulang sudah dilakukan hari ini';
                    checkoutIndicator.innerHTML = lockIcon;
                } else {
                    checkout.setAttribute('tabindex', '-1');
                    checkoutBadge.hidden = false;
                    checkoutBadge.textContent = 'Terkunci';
                    checkoutStatus.textContent = `Tersedia mulai pukul ${schedule.workEnd} WIB`;
                    checkoutIndicator.innerHTML = lockIcon;
                }
            }

            checkin.addEventListener('click', function (event) {
                if (checkin.getAttribute('aria-disabled') === 'true') event.preventDefault();
            });
            checkout.addEventListener('click', function (event) {
                if (checkout.getAttribute('aria-disabled') === 'true') {
                    event.preventDefault();
                }
            });

            updateAttendanceActions();
            updateDashboardClock();
            window.setInterval(updateDashboardClock, 1000);
            window.setInterval(updateAttendanceActions, 1000);
        })();
        document.getElementById('calendar-previous').addEventListener('click', () => {
            visibleCalendarMonth -= 1;
            if (visibleCalendarMonth < 0) {
                visibleCalendarMonth = 11;
                visibleCalendarYear -= 1;
            }
            renderCalendar();
        });
        document.getElementById('calendar-next').addEventListener('click', () => {
            visibleCalendarMonth += 1;
            if (visibleCalendarMonth > 11) {
                visibleCalendarMonth = 0;
                visibleCalendarYear += 1;
            }
            renderCalendar();
        });
        renderCalendar();
        updateAttendanceSummary();
    </script>
</body>
</html>
