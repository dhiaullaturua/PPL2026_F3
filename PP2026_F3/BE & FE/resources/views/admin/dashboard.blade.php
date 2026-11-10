@extends('layouts.admin')

@section('content')
    <main class="admin-shell">
        <header class="admin-header">
            <div><span class="admin-chip">ADMIN</span><h1>Dashboard Admin</h1></div>
            <span class="admin-avatar" aria-label="Profil Admin">A</span>
        </header>
        <a class="admin-card-link" href="{{ route('admin.overtime.approval') }}">
            <strong>Approval Lembur (SPL)</strong>
            <span>Periksa dan proses pengajuan lembur karyawan.</span>
        </a>
        <a class="admin-card-link" href="{{ route('admin.calendar.index') }}">
            <strong>Kalender Hari Libur</strong>
            <span>COO atau Staf Admin dapat memasukkan hari libur yang tampil di kalender karyawan.</span>
        </a>
    </main>
@endsection