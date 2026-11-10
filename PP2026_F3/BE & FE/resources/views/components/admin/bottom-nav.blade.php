@props(['active' => 'monitor'])

<nav class="admin-bottom-nav admin-four-nav" aria-label="Navigasi Admin">
    <a href="{{ route('admin.monitor') }}" @class(['active' => $active === 'monitor']) @if($active === 'monitor') aria-current="page" @endif>
        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="6" height="6"/><rect x="14" y="4" width="6" height="6"/><rect x="4" y="14" width="6" height="6"/><rect x="14" y="14" width="6" height="6"/></svg><span>Monitor</span>
    </a>
    <a href="{{ route('admin.recap') }}" @class(['active' => $active === 'recap']) @if($active === 'recap') aria-current="page" @endif>
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19V5m0 14h16M8 15v-3m4 3V8m4 7v-5"/></svg><span>Rekap</span>
    </a>
    <a href="{{ route('admin.overtime.approval') }}" @class(['active' => $active === 'overtime']) @if($active === 'overtime') aria-current="page" @endif>
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h10M4 12h7m-7 6h5m4-7 3 3 5-6"/></svg><span>Approval Lembur</span>
    </a>
    <a href="{{ route('admin.lateness.index') }}" @class(['active' => $active === 'lateness']) @if($active === 'lateness') aria-current="page" @endif>
        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8m-8 5h8m-8 5h4"/></svg><span>Keterlambatan</span>
    </a>
</nav>
