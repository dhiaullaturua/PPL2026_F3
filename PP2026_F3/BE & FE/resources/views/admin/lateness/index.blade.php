@extends('layouts.admin')

@section('admin-page', 'lateness')

@section('content')
    <main class="admin-shell admin-insights-shell">
        <header class="admin-header"><div><span class="admin-chip">ADMIN</span><h1>Verifikasi Karyawan</h1></div><a href="{{ route('admin.calendar.index') }}" class="admin-avatar" aria-label="Kelola kalender libur">A</a></header>
        <section class="admin-verification-summary"><h2>▣ Pusat Verifikasi Terlambat <span>●</span></h2><div><article><small>◷ Review</small><strong id="admin-late-pending-count">14</strong><span>Menunggu</span></article><article><small class="admin-text-green">◉ Diterima</small><strong>28</strong><span>Toleransi</span></article><article><small class="admin-text-blue">▦ Sync</small><strong>99.2%</strong><span>QR Valid</span></article></div></section>
        <div class="admin-category-heading"><strong>KATEGORI ALASAN</strong><span>Batas Review: 24 Jam</span></div>
        <nav class="admin-pill-tabs admin-reason-tabs" aria-label="Kategori alasan"><button class="active" type="button" data-reason-filter="all">Semua <b>14</b></button><button type="button" data-reason-filter="traffic">Macet Lalu Lintas <b>8</b></button><button type="button" data-reason-filter="vehicle">Kendala Kendaraan <b>4</b></button><button type="button" data-reason-filter="other">Lainnya <b>2</b></button></nav>
        <div class="admin-list-title"><h2>Klarifikasi Menunggu Keputusan</h2><span>Realtime Stream</span></div>
        <section class="admin-lateness-list">
            <article class="admin-lateness-card" data-reason="traffic" data-decision-id="late-001"><div class="admin-lateness-person"><span class="admin-face face-warm">DS</span><div><h3>Debay, S.T.</h3><p>Senior UI/UX Designer</p></div><strong class="admin-delay">◴ +18 Menit</strong></div><div class="admin-reason-meta"><span>▣ Jadwal: 08:30 WIB</span><strong>▦ Presensi: 08:48:22 WIB</strong><p><b>Macet Lalu Lintas</b>　 Via QR Pos Gerbang Barat</p></div><small class="admin-reason-label">ALASAN KARYAWAN:</small><blockquote>"Kendala kemacetan parah di perempatan Jl. Setiabudi imbas perbaikan gorong-gorong PDAM."</blockquote><div class="admin-lateness-actions"><button class="admin-late-reject" type="button">× Catat Terlambat</button><button class="admin-late-accept" type="button">✓ Beri Toleransi</button></div></article>
            <article class="admin-lateness-card" data-reason="vehicle" data-decision-id="late-002"><div class="admin-lateness-person"><span class="admin-face face-pink">SN</span><div><h3>Siti Nurbaliza, S.E.</h3><p>Keuangan &amp; Akuntansi</p></div><strong class="admin-delay">◴ +32 Menit</strong></div><div class="admin-reason-meta"><span>▣ Jadwal: 08:30 WIB</span><strong>▦ Presensi: 09:02:14 WIB</strong><p><b>Kendala Kendaraan</b>　 Lobi Menara Utama Lt.1</p></div><small class="admin-reason-label">ALASAN KARYAWAN:</small><blockquote>"Ban motor kempes di jalan layang Casablanca. Harus mendorong mencari bengkel."</blockquote><div class="admin-lateness-actions"><button class="admin-late-reject" type="button">× Catat Terlambat</button><button class="admin-late-accept" type="button">✓ Beri Toleransi</button></div></article>
        </section>
        <p class="admin-empty" id="admin-late-empty" hidden>Tidak ada klarifikasi pada kategori ini.</p>
    </main>
    @include('components.admin.bottom-nav', ['active' => 'lateness'])
@endsection
