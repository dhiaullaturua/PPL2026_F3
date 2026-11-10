@extends('layouts.karyawan')

@section('body-class', 'announcement-page')

@section('content')
    <main class="announcement-shell">
        <header class="announcement-header">
            <a class="announcement-back" href="{{ route('karyawan.notifications') }}" aria-label="Kembali ke notifikasi">‹</a>
            <h1>Detail Pengumuman</h1>
            <a class="announcement-avatar" href="{{ route('karyawan.profile') }}" aria-label="Profil">D</a>
        </header>

        <div class="announcement-breadcrumb">
            <a href="{{ route('karyawan.notifications') }}">♧ Pusat Pemberitahuan</a>
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
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('announcement.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('announcement.js') }}" defer></script>
@endpush
