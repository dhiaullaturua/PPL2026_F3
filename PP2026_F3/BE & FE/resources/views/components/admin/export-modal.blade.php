<div class="admin-modal-backdrop" id="admin-export-modal" hidden>
    <section class="admin-export-modal" role="dialog" aria-modal="true" aria-labelledby="admin-export-title">
        <header class="admin-export-heading">
            <span class="admin-export-file" aria-hidden="true">PDF</span>
            <div><h2 id="admin-export-title">Ekspor Rekapitulasi Presensi</h2><p>● Format Dokumen Resmi (.PDF)</p></div>
            <button class="admin-modal-close" type="button" aria-label="Tutup">×</button>
        </header>
        <fieldset class="admin-export-period">
            <legend>Periode Laporan</legend>
            <div class="admin-export-period-tabs">
                <button type="button" class="active" data-export-period="current">Bulan Ini</button>
                <button type="button" data-export-period="previous">Bulan Lalu</button>
                <button type="button" data-export-period="custom">Kustom</button>
            </div>
            <div class="admin-export-dates" id="admin-export-dates"></div>
            <div class="admin-custom-dates" id="admin-custom-dates" hidden>
                <label class="admin-field">Dari tanggal<input type="date" id="admin-export-start"></label>
                <label class="admin-field">Sampai tanggal<input type="date" id="admin-export-end"></label>
            </div>
        </fieldset>
        <div class="admin-export-components-title"><strong>Komponen Data yang Disertakan</strong><button type="button" id="admin-export-toggle-all">Pilih Semua</button></div>
        <div class="admin-export-checklist">
            <label><input type="checkbox" checked data-export-component><span><strong>Ringkasan Kehadiran &amp; Persentase</strong><small>Hadir tepat waktu, terlambat, alpa &amp; cuti</small></span><em>Wajib</em></label>
            <label><input type="checkbox" checked data-export-component><span><strong>Detail Keterlambatan &amp; Alasan</strong><small>Log waktu menit keterlambatan &amp; approval</small></span><em>Aktif</em></label>
            <label><input type="checkbox" checked data-export-component><span><strong>Akumulasi Lembur &amp; Kalkulasi SPL</strong><small>Total jam lembur &amp; verifikasi atasan</small></span><em>Aktif</em></label>
        </div>
        <div class="admin-export-preview">
            <span class="admin-export-doc" aria-hidden="true">▤</span>
            <span><strong id="admin-export-filename">Rekap_Presensi.pdf</strong><small>Estimasi ukuran dokumen • siap dicetak</small></span>
            <b aria-label="Siap dicetak">✓</b>
            <small class="admin-export-ready">◎ Siap Cetak PDF</small>
        </div>
        <button class="admin-export-submit" id="admin-export-submit" type="button">⇩ &nbsp;Unduh PDF Sekarang</button>
    </section>
</div>
