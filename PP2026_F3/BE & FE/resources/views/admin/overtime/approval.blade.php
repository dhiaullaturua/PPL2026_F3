@extends('layouts.admin')

@section('admin-page', 'overtime')

@section('content')
    <main class="admin-shell">
        <header class="admin-header">
            <div><span class="admin-chip">ADMIN</span><h1>Approval Lembur (SPL)</h1></div>
            <div class="admin-header-links"><a href="{{ route('admin.monitor') }}">Monitor</a><a href="{{ route('admin.calendar.index') }}">Kalender Libur</a><span class="admin-avatar">A</span></div>
        </header>
        <nav class="admin-tabs" aria-label="Status pengajuan lembur">
            <button class="admin-tab active" type="button" data-status="pending">Menunggu <span class="admin-tab-count">14</span></button>
            <button class="admin-tab" type="button" data-status="approved">Disetujui <span class="admin-tab-count">8</span></button>
            <button class="admin-tab" type="button" data-status="rejected">Ditolak <span class="admin-tab-count">2</span></button>
        </nav>
        <div class="admin-bulkbar">
            <label class="admin-check-control"><input id="admin-select-all" type="checkbox"><span>Pilih Semua<small id="admin-selected-count">0 dipilih</small></span></label>
            <button class="admin-primary-button" id="admin-approve-selected" type="button" disabled>✓ Setujui Terpilih</button>
        </div>
        <p class="admin-notice" id="admin-overtime-notice" role="status" aria-live="polite"></p>
        <section aria-label="Daftar pengajuan lembur">
            <article class="admin-overtime-card" data-request-id="spl-001" data-status="pending">
                <div class="admin-card-heading"><input class="admin-card-check" type="checkbox" aria-label="Pilih pengajuan Bambang Tria"><span class="admin-person-photo" aria-hidden="true">BT</span><div class="admin-person-name">Bambang Tria<span class="admin-person-role">Site Supervisor · C</span><span class="admin-overtime-type">◷ SPL Lembur · Hari Kerja</span></div></div>
                <div class="admin-job-details"><div class="admin-job-date"><span>▣ Kamis, 24 Okt 2024</span><span class="admin-hours">3.5 Jam</span></div><div class="admin-job-time"><span>◷ 17:30 - 21:00 WIB　(Kompensasi: 1.5x - 2.0x Upah Jam)</span></div><p class="admin-task">Tugas: “Penyelesaian inspeksi gate scanner &amp; pengelasan struktur rangka lobi timur sebelum audit esok hari.”</p></div>
                <div class="admin-supervisor"><span>Supervisor: <strong>Agus Pratama (Manajer Lapangan)</strong></span><span class="admin-verified">◉ Terverifikasi SPL</span></div>
                <div class="admin-card-actions"><button class="admin-reject-button" type="button">Tolak Lembur</button><button class="admin-approve-button" type="button">✓ Setujui Lembur</button></div>
            </article>
            <article class="admin-overtime-card" data-request-id="spl-002" data-status="pending">
                <div class="admin-card-heading"><input class="admin-card-check" type="checkbox" aria-label="Pilih pengajuan Annisa"><span class="admin-person-photo" aria-hidden="true">AN</span><div class="admin-person-name">Annisa<span class="admin-person-role">Backend</span><span class="admin-overtime-type urgent">ϟ SPL Lembur · Urgent Maintenance</span></div></div>
                <div class="admin-job-details"><div class="admin-job-date"><span>▣ Jumat, 25 Okt 2024</span><span class="admin-hours">4.0 Jam</span></div><div class="admin-job-time"><span>◷ 18:00 - 22:00 WIB　(Kompensasi: Flat 2.0x Upah Lembur)</span></div><p class="admin-task">Tugas: “Migrasi database server presensi kantor pusat dan integrasi webhook log scanner lobi.”</p></div>
                <div class="admin-supervisor"><span>Supervisor: <strong>Rudi Hartono (VP Engineering)</strong></span><span class="admin-verified">◉ Terverifikasi SPL</span></div>
                <div class="admin-card-actions"><button class="admin-reject-button" type="button">Tolak Lembur</button><button class="admin-approve-button" type="button">✓ Setujui Lembur</button></div>
            </article>
        </section>
        <p class="admin-empty" id="admin-overtime-empty" hidden>Tidak ada pengajuan pada status ini.</p>
    </main>
    @include('components.admin.bottom-nav', ['active' => 'overtime'])
@endsection