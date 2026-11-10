@extends('layouts.karyawan')

@section('body-class', 'overtime-page')

@section('content')
    <main class="overtime-shell">
        <header class="overtime-header">
            <div class="overtime-brand">Debay, S.T.<small>Lembur</small></div>
            <div class="overtime-header-actions">
                <a href="{{ route('karyawan.notifications') }}" aria-label="Notifikasi"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg></a>
                <a class="overtime-avatar" href="{{ route('karyawan.profile') }}" aria-label="Profil">D</a>
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

    <nav class="employee-bottom-nav overtime-bottom-nav" aria-label="Navigasi utama">
        <a href="{{ route('karyawan.dashboard') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg><span>Beranda</span></a>
        <a href="{{ route('karyawan.attendance.history') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg><span>Riwayat</span></a>
        <a class="active" href="{{ route('karyawan.overtime.index') }}" aria-current="page"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg><span>Lembur</span></a>
        <a href="{{ route('karyawan.profile') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg><span>Profil</span></a>
    </nav>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('overtime.css') }}?v=3">
@endpush

@push('scripts')
    <script src="{{ asset('overtime.js') }}?v=3" defer></script>
@endpush
