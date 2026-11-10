@extends('layouts.admin')

@section('admin-page', 'calendar')

@section('content')
    <main class="admin-shell">
        <header class="admin-header">
            <div><span class="admin-chip">ADMIN</span><h1>Kalender Hari Libur</h1></div>
            <div class="admin-header-links"><a href="{{ route('admin.monitor') }}">Monitor</a><a href="{{ route('admin.overtime.approval') }}">Approval Lembur</a><span class="admin-avatar">A</span></div>
        </header>
        <p class="admin-notice" id="admin-calendar-notice" role="status" aria-live="polite"></p>
        <form class="admin-calendar-form" id="admin-work-schedule-form">
            <h2>Atur Jadwal Kerja</h2>
            <p>Jadwal yang disimpan akan ditampilkan pada kalender karyawan di perangkat ini.</p>
            <div class="admin-time-grid">
                <label class="admin-field" for="admin-work-start">Masuk kerja<input id="admin-work-start" type="time" value="07:00" required></label>
                <label class="admin-field" for="admin-work-end">Selesai kerja<input id="admin-work-end" type="time" value="17:00" required></label>
                <label class="admin-field" for="admin-break-start">Mulai istirahat<input id="admin-break-start" type="time" value="12:00" required></label>
                <label class="admin-field" for="admin-break-end">Selesai istirahat<input id="admin-break-end" type="time" value="13:00" required></label>
            </div>
            <button class="admin-save-button" type="submit">Simpan Jadwal</button>
        </form>
        <form class="admin-calendar-form" id="admin-holiday-form">
            <h2>Tentukan Hari Libur</h2>
            <p>Tanggal dan keterangan libur yang ditentukan Admin akan muncul pada kalender karyawan.</p>
            <label class="admin-field" for="admin-creator-role">Diinput oleh<select id="admin-creator-role"><option value="COO">COO</option><option value="Staf Admin" selected>Staf Admin</option></select></label>
            <label class="admin-field" for="admin-holiday-date">Tanggal libur<input id="admin-holiday-date" type="date" required></label>
            <label class="admin-field" for="admin-holiday-name">Keterangan hari libur<input id="admin-holiday-name" type="text" maxlength="100" placeholder="Contoh: Libur Nasional / Cuti Bersama" required></label>
            <button class="admin-save-button" type="submit">Simpan Hari Libur</button>
        </form>
        <section class="admin-holiday-list"><h2>Daftar Hari Libur</h2><div id="admin-holiday-list"></div><p class="admin-empty" id="admin-holiday-empty">Belum ada hari libur yang diinput.</p></section>
    </main>
    @include('components.admin.bottom-nav', ['active' => ''])
@endsection