@extends('layouts.karyawan')

@section('body-class', 'employee-page')

@section('content')
    <main class="employee-page-shell">
        <header class="employee-page-header">
            <div class="employee-page-brand"><strong>Debay, S.T.</strong><small>Profil</small></div>
            <div class="employee-page-actions">
                <a class="employee-icon-link has-notice" href="{{ route('karyawan.notifications') }}" aria-label="Buka notifikasi">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a4 4 0 0 1 4 4v1.2c0 1.1.4 2.1 1.1 2.9l1.3 1.6c.9 1.1.2 2.8-1.3 2.8H6.9c-1.5 0-2.2-1.7-1.3-2.8l1.3-1.6A4.7 4.7 0 0 0 8 8.2V7a4 4 0 0 1 4-4Zm0 18a2.7 2.7 0 0 1-2.6-2h5.2A2.7 2.7 0 0 1 12 21Z"/></svg>
                </a>
                <span class="employee-avatar-small" aria-label="Foto profil">D</span>
            </div>
        </header>

        <section class="employee-profile-card" aria-label="Informasi karyawan">
            <div class="employee-identity">
                <div class="employee-photo" aria-hidden="true">D</div>
                <div>
                    <span class="employee-contract">● Karyawan Tetap (Full Time)</span>
                    <h1>Debay, S.T.</h1>
                    <strong class="employee-position">Senior UI/UX Designer</strong>
                    <p>Divisi Produk &amp; Desain</p>
                </div>
            </div>
            <div class="employee-details">
                <div class="employee-detail">
                    <span class="employee-detail-icon">▣</span>
                    <span><small>NIP PEGAWAI</small><strong>EMP-20220914</strong></span>
                </div>
                <div class="employee-detail">
                    <span class="employee-detail-icon">⛨</span>
                    <span><small>STATUS AKUN</small><strong class="account-active">Aktif &amp; Legal</strong></span>
                </div>
            </div>
        </section>

        <h2 class="employee-section-label">PENGATURAN ABSENSI &amp; KEAMANAN</h2>
        <section class="employee-settings">
            <a class="employee-setting-row" href="{{ route('karyawan.dashboard') }}#calendar">
                <span class="employee-setting-icon">▦</span>
                <span class="employee-setting-copy"><strong>Jadwal Kerja &amp; Kalender Shift</strong><small>Lihat rotasi jadwal &amp; cuti bersama</small></span>
                <span class="employee-chevron">›</span>
            </a>
            <div class="employee-setting-row">
                <span class="employee-setting-icon">◴</span>
                <span class="employee-setting-copy"><strong>Pengingat Absen Otomatis</strong><small>15 menit sebelum shift dimulai</small></span>
                <button class="employee-switch" id="attendance-reminder" type="button" role="switch" aria-checked="true" aria-label="Pengingat absen otomatis"></button>
            </div>
        </section>
        <a class="employee-logout" href="{{ route('karyawan.dashboard') }}">⇥ &nbsp; Keluar</a>
    </main>

    <nav class="employee-bottom-nav" aria-label="Navigasi utama">
        <a href="{{ route('karyawan.dashboard') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg><span>Beranda</span></a>
        <a href="{{ route('karyawan.attendance.history') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg><span>Riwayat</span></a>
        <a href="{{ route('karyawan.overtime.index') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg><span>Lembur</span></a>
        <a class="active" href="{{ route('karyawan.profile') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg><span>Profil</span></a>
    </nav>

    <script>
        const attendanceReminder = document.getElementById('attendance-reminder');
        attendanceReminder.setAttribute('aria-checked', localStorage.getItem('attendance-reminder-enabled') !== 'false');
        attendanceReminder.addEventListener('click', () => {
            const enabled = attendanceReminder.getAttribute('aria-checked') !== 'true';
            attendanceReminder.setAttribute('aria-checked', String(enabled));
            localStorage.setItem('attendance-reminder-enabled', String(enabled));
        });
    </script>
@endsection
