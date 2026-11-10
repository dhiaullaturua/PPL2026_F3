@extends('layouts.admin')

@section('admin-page', 'recap')

@section('content')
    <main class="admin-shell admin-insights-shell">
        <header class="admin-header"><div><span class="admin-chip">ADMIN</span><h1>Rekap Absensi</h1></div><a href="{{ route('admin.calendar.index') }}" class="admin-avatar" aria-label="Kelola kalender libur">A</a></header>
        <nav class="admin-period-tabs" aria-label="Periode rekap"><button type="button" data-recap-period="weekly">Mingguan</button><button class="active" type="button" data-recap-period="monthly">Bulanan</button><button type="button" data-recap-period="yearly">Tahunan</button></nav>
        <label class="admin-month-picker"><span>▦</span><select id="admin-recap-month" aria-label="Pilih bulan"><option value="2026-10">Oktober 2026</option><option value="2026-09">September 2026</option><option value="2026-08">Agustus 2026</option></select></label>
        <section class="admin-recap-metrics"><article><span>✓ <b>+1.2%</b></span><strong>96.4%</strong><small>Rata Kehadiran</small></article><article><span>◷</span><strong>342 Jam</strong><small>Total Lembur</small></article><article><span>◴ <b>-4x</b></span><strong>48 Insiden</strong><small>Keterlambatan</small></article></section>
        <div class="admin-list-title"><h2>Rekap Pegawai <span class="admin-employee-count">3 Karyawan</span></h2></div>
        <label class="admin-search"><span aria-hidden="true">⌕</span><input id="admin-employee-search" type="search" placeholder="Cari nama, NIP, posisi..."></label>
        <section class="admin-employee-list" id="admin-employee-list">
            <article class="admin-employee-card" data-employee-name="bayu pratama s kom divisi teknologi nip 882019"><div class="admin-employee-heading"><span class="admin-face face-warm">BP</span><div><h3>Bayu Pratama, S.Kom</h3><p>Divisi Teknologi • NIP 882019</p></div></div><div class="admin-employee-metrics"><span>Hadir<strong>22 Hari</strong></span><span>Terlambat<strong>12 mnt</strong></span><span>Lembur<strong>18.5 Jam</strong></span><span>Persentase<strong class="admin-text-green">98.5%</strong></span></div></article>
            <article class="admin-employee-card" data-employee-name="sarah nadhira m ds divisi produk nip 882044"><div class="admin-employee-heading"><span class="admin-face face-pink">SN</span><div><h3>Sarah Nadhira, M.Ds</h3><p>Divisi Produk • NIP 882044</p></div></div><div class="admin-employee-metrics"><span>Hadir<strong>19 Hari</strong></span><span>Terlambat<strong class="admin-text-red">65 mnt</strong><small>(3x)</small></span><span>Lembur<strong>6.0 Jam</strong></span><span>Izin/Sakit<strong class="admin-text-amber">2 Hari</strong></span></div></article>
            <article class="admin-employee-card" data-employee-name="hendra gunawan s e divisi keuangan nip 882005"><div class="admin-employee-heading"><span class="admin-face face-blue">HG</span><div><h3>Hendra Gunawan, S.E.</h3><p>Divisi Keuangan • NIP 882005</p></div></div><div class="admin-employee-metrics"><span>Hadir<strong>22 Hari</strong></span><span>Terlambat<strong class="admin-text-green">0 mnt</strong></span><span>Lembur<strong>24.0 Jam</strong></span><span>Persentase<strong class="admin-text-green">100%</strong></span></div></article>
        </section>
        <p class="admin-empty" id="admin-employee-empty" hidden>Karyawan tidak ditemukan.</p>
        <div class="admin-fixed-action"><button class="admin-report-download" type="button" data-open-export>⇩ &nbsp;Unduh Laporan (PDF)</button></div>
    </main>
    @include('components.admin.export-modal')
    @include('components.admin.bottom-nav', ['active' => 'recap'])
@endsection
