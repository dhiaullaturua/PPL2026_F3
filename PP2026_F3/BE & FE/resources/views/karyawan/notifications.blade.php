@extends('layouts.karyawan')

@section('body-class', 'employee-page')

@section('content')
    <main class="employee-page-shell notifications-page">
        <header class="employee-page-header notifications-header">
            <div class="notifications-title">
                <a class="notifications-back" href="{{ route('karyawan.dashboard') }}" aria-label="Kembali ke beranda">‹</a>
                <h1>Notifikasi</h1>
            </div>
            <div class="employee-page-actions">
                <button class="mark-notifications-read" id="mark-all-read" type="button" aria-label="Tandai semua sudah dibaca">✓✓</button>
            </div>
        </header>

        <div class="notification-summary">
            <strong>Pusat Pemberitahuan</strong>
            <span class="notification-new-count" id="unread-count"></span>
        </div>
        <nav class="notification-filters" aria-label="Filter notifikasi">
            <button class="notification-filter active" data-filter="all" type="button">Semua <span id="total-count">2</span></button>
            <button class="notification-filter" data-filter="announcement" type="button">Pengumuman <span id="announcement-count">1</span></button>
            <button class="notification-filter" data-filter="overtime" type="button">Pengajuan Lembur <span id="overtime-count">1</span></button>
        </nav>

        <div class="notification-day">HARI INI <small>Terbaru</small></div>
        <section class="employee-notification" data-category="announcement" data-id="schedule-announcement">
            <span class="notification-icon">✿</span>
            <div class="notification-content">
                <div class="notification-meta">PENGUMUMAN HR &amp; GA</div>
                <h2>Penyesuaian Batas Verifikasi Jadwal Kerja dan Presensi</h2>
                <p>Perhatikan batas klarifikasi kehadiran, persetujuan lembur, dan penguncian data payroll bulan Oktober.</p>
                <small>◷ 19 Okt 2026</small>
                <a class="notification-action" href="{{ route('karyawan.announcements.schedule') }}">Lihat Pengumuman</a>
            </div>
            <span class="notification-unread-dot"></span>
            <button class="notification-more" type="button" aria-label="Tandai sudah dibaca">⋮</button>
        </section>

        <div class="notification-day">MINGGU INI</div>
        <section class="employee-notification" data-category="overtime" data-id="overtime-approved">
            <span class="notification-icon">◴</span>
            <div class="notification-content">
                <div class="notification-meta blue">LEMBUR DISETUJUI</div>
                <h2>Lembur Telah Disetujui (2.5 Jam)</h2>
                <p>Lembur tugas proyek akhir pekan telah diverifikasi dan masuk ke perhitungan payroll bulan berjalan.</p>
                <small>▣ 19 Okt 2026</small>
            </div>
            <span class="notification-unread-dot"></span>
            <button class="notification-more" type="button" aria-label="Tandai sudah dibaca">⋮</button>
        </section>
        <p class="notification-empty" id="notification-empty" hidden>Tidak ada notifikasi pada kategori ini.</p>
    </main>

    <nav class="employee-bottom-nav" aria-label="Navigasi utama">
        <a href="{{ route('karyawan.dashboard') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg><span>Beranda</span></a>
        <a href="{{ route('karyawan.attendance.history') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg><span>Riwayat</span></a>
        <a href="{{ route('karyawan.overtime.index') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg><span>Lembur</span></a>
        <a href="{{ route('karyawan.profile') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg><span>Profil</span></a>
    </nav>

    <script>
        const notificationCards = Array.from(document.querySelectorAll('.employee-notification'));
        const readNotificationIds = new Set(JSON.parse(localStorage.getItem('attendance-read-notifications') || '[]'));
        let activeNotificationFilter = 'all';

        function updateNotifications() {
            let visibleCount = 0;
            let unreadCount = 0;

            notificationCards.forEach((card) => {
                const isRead = readNotificationIds.has(card.dataset.id);
                const matchesFilter = activeNotificationFilter === 'all' || card.dataset.category === activeNotificationFilter;
                card.classList.toggle('read', isRead);
                card.hidden = !matchesFilter;
                if (matchesFilter) visibleCount += 1;
                if (!isRead) unreadCount += 1;
            });

            document.getElementById('unread-count').textContent = `${unreadCount} Baru`;
            document.getElementById('total-count').textContent = notificationCards.length;
            document.getElementById('announcement-count').textContent = notificationCards.filter((card) => card.dataset.category === 'announcement').length;
            document.getElementById('overtime-count').textContent = notificationCards.filter((card) => card.dataset.category === 'overtime').length;
            document.getElementById('notification-empty').hidden = visibleCount !== 0;
            document.querySelectorAll('.notification-day').forEach((heading) => {
                const card = heading.nextElementSibling;
                heading.hidden = !card || card.hidden;
            });
            localStorage.setItem('attendance-read-notifications', JSON.stringify(Array.from(readNotificationIds)));
        }

        document.querySelectorAll('.notification-filter').forEach((button) => {
            button.addEventListener('click', () => {
                activeNotificationFilter = button.dataset.filter;
                document.querySelectorAll('.notification-filter').forEach((filter) => filter.classList.toggle('active', filter === button));
                updateNotifications();
            });
        });
        document.querySelectorAll('.notification-more').forEach((button) => {
            button.addEventListener('click', () => {
                readNotificationIds.add(button.closest('.employee-notification').dataset.id);
                updateNotifications();
            });
        });
        document.getElementById('mark-all-read').addEventListener('click', () => {
            notificationCards.forEach((card) => readNotificationIds.add(card.dataset.id));
            updateNotifications();
        });
        updateNotifications();
    </script>
@endsection
