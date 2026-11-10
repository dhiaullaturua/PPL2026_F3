@extends('layouts.karyawan')

@section('body-class', 'employee-page')

@section('content')
    <main class="employee-page-shell attendance-history-page">
        <header class="employee-page-header">
            <div class="history-brand">Debay, S.T.<small>Riwayat</small></div>
            <div class="history-header-actions">
                <a class="history-icon-link" href="{{ route('karyawan.notifications') }}" aria-label="Notifikasi">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
                </a>
                <a class="employee-avatar-small" href="{{ route('karyawan.profile') }}" aria-label="Profil">D</a>
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

    <nav class="employee-bottom-nav" aria-label="Navigasi utama">
        <a href="{{ route('karyawan.dashboard') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg><span>Beranda</span></a>
        <a class="active" href="{{ route('karyawan.attendance.history') }}" aria-current="page"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg><span>Riwayat</span></a>
        <a href="{{ route('karyawan.overtime.index') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg><span>Lembur</span></a>
        <a href="{{ route('karyawan.profile') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg><span>Profil</span></a>
    </nav>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('attendance-history.css') }}?v=2">
@endpush

@push('scripts')
    <script src="{{ asset('attendance-history.js') }}?v=2" defer></script>
@endpush
