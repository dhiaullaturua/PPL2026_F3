@extends('layouts.karyawan')

@section('body-class', 'attendance-page')

@section('content')
    <div class="attendance-checkin-shell">
        <header class="attendance-header">
            <div class="user-badge">
                <strong>Debay, S.T.</strong>
                <small>{{ $mode === 'checkout' ? 'Presensi Pulang' : 'Presensi Masuk' }}</small>
            </div>

            <div class="header-actions">
                <button type="button" class="header-icon" aria-label="Notifikasi">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 3a4 4 0 0 1 4 4v1.2c0 1.1.4 2.1 1.1 2.9l1.3 1.6c.9 1.1.2 2.8-1.3 2.8H6.9c-1.5 0-2.2-1.7-1.3-2.8l1.3-1.6A4.7 4.7 0 0 0 8 8.2V7a4 4 0 0 1 4-4Zm0 18a2.7 2.7 0 0 1-2.6-2h5.2A2.7 2.7 0 0 1 12 21Z"/>
                    </svg>
                </button>

                <div class="avatar-pill" aria-label="Profil user">
                    <div class="avatar-circle">D</div>
                </div>
            </div>
        </header>

        <main class="attendance-content">
            <div class="attendance-topbar">
                <a class="back-btn" href="{{ route('karyawan.dashboard') }}" aria-label="Kembali">←</a>
                <h1 class="attendance-title">{{ $mode === 'checkout' ? 'Presensi Pulang' : 'Presensi Masuk' }}</h1>
            </div>

            <div class="attendance-time-panel">
                <div class="attendance-label">{{ $mode === 'checkout' ? 'Jam Pulang Presensi' : 'Jam Masuk Presensi' }}</div>
                <div class="attendance-time"><span class="attendance-clock"></span> <span class="timezone">WIB</span></div>
                <div class="attendance-date"></div>
            </div>

            <div class="qr-panel">
                <button class="scanner-frame scan-trigger" id="scan-trigger" type="button" aria-label="Simulasikan pemindaian barcode">
                    <span class="scanner-corner top-left"></span>
                    <span class="scanner-corner top-right"></span>
                    <span class="scanner-corner bottom-left"></span>
                    <span class="scanner-corner bottom-right"></span>

                    <div class="scanner-inner">
                        <div class="qr-matrix" aria-hidden="true">
                            <span class="qr-square filled"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>

                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>

                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>

                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>

                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>

                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>

                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>

                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>

                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                            <span class="qr-square"></span>
                            <span class="qr-square filled"></span>
                        </div>
                        <div class="scan-text">Fokuskan Barcode di Sini</div>
                    </div>
                </button>
                <p class="demo-hint">Ketuk area pemindai untuk melihat hasil presensi.</p>
            </div>
        </main>

        <nav class="bottom-nav" aria-label="Navigasi utama">
            <button type="button" class="nav-item active">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 10.5 12 4l8 6.5V19a1 1 0 0 1-1 1h-4v-7H9v7H5a1 1 0 0 1-1-1v-8.5Z"/>
                    </svg>
                </span>
                <span class="nav-label">Beranda</span>
            </button>

            <a href="{{ route('karyawan.attendance.history') }}" class="nav-item">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2.5a9.5 9.5 0 0 1 9.5 9.5 9.5 9.5 0 1 1-19 0 9.5 9.5 0 0 1 9.5-9.5Zm1 4.5h-2v5.5h5.2v-2H13V7Z"/>
                    </svg>
                </span>
                <span class="nav-label">Riwayat</span>
            </a>

            <a href="{{ route('karyawan.overtime.index') }}" class="nav-item">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M7 2.5h2v2h6v-2h2v2h2.5A2.5 2.5 0 0 1 22 7v11.5A2.5 2.5 0 0 1 19.5 21h-15A2.5 2.5 0 0 1 2 18.5V7a2.5 2.5 0 0 1 2.5-2.5H7v-2Zm12.5 7.5h-15v9h15v-9ZM7 12h3v3H7v-3Zm5 0h5v2h-5v-2Z"/>
                    </svg>
                </span>
                <span class="nav-label">Lembur</span>
            </a>

            <button type="button" class="nav-item">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 12.2a3.6 3.6 0 1 0 0-7.2 3.6 3.6 0 0 0 0 7.2Zm-6 7.3c.4-2.9 3.1-5 6-5s5.6 2.1 6 5H6Z"/>
                    </svg>
                </span>
                <span class="nav-label">Profil</span>
            </button>
        </nav>
    </div>

    <div class="result-overlay" id="attendance-result" role="presentation" hidden>
        <section class="result-card" id="attendance-result-card" role="dialog" aria-modal="true" aria-labelledby="result-title" aria-describedby="result-description">
            <div class="result-icon" id="result-icon" aria-hidden="true">✓</div>
            <h2 id="result-title"></h2>
            <p class="result-description" id="result-description"></p>
            <div class="result-pills" id="result-pills"></div>
            <div class="result-details" id="result-details"></div>
            <button class="result-button secondary late-reason-launch" id="late-reason-open" type="button" hidden>Ajukan Alasan Keterlambatan</button>
            <a class="result-button" href="{{ route('karyawan.dashboard') }}">⌂ Kembali ke Beranda</a>
            <button class="result-button secondary" id="result-close" type="button" hidden>Kembali ke pemindai</button>
        </section>
    </div>
    <div class="network-overlay" id="network-offline-overlay" hidden>
        <section class="network-dialog" role="dialog" aria-modal="true" aria-labelledby="network-offline-title" aria-describedby="network-offline-description">
            <button class="network-close" id="network-offline-close" type="button" aria-label="Tutup">×</button>
            <div class="network-icon" aria-hidden="true">
                <svg viewBox="0 0 36 36"><path d="M5 13.5a20 20 0 0 1 22.6-1.7M9.5 18a13.5 13.5 0 0 1 14.3-1.1M14 22.5a7 7 0 0 1 5.7-.4M7 7l22 22M18 28h.01"/><circle class="alert-mark" cx="29" cy="7" r="7"/><path d="M29 3.5v4M29 10h.01" stroke="#fff"/></svg>
            </div>
            <h2 id="network-offline-title">Tidak Terhubung Ke Jaringan</h2>
            <p class="network-description" id="network-offline-description">Perangkat Anda kehilangan koneksi internet. Presensi barcode memerlukan jaringan aktif untuk validasi waktu presisi dan sinkronisasi server HR.</p>
            <div class="network-info">
                <div class="network-info-row"><span>◉ Status Jaringan</span><strong class="network-status-offline" id="network-offline-status">Terputus (Offline)</strong></div>
                <div class="network-info-row"><span>◷ Waktu Percobaan</span><strong id="network-offline-time"></strong></div>
            </div>
            <div class="network-warning">⚠ Pastikan data seluler atau Wi-Fi aktif. Data presensi tidak dapat direkam secara offline untuk mencegah manipulasi waktu.</div>
            <button class="network-retry" id="network-retry-button" type="button">↻ Coba Sambungkan Ulang</button>
        </section>
    </div>
    <div class="late-reason-overlay" id="late-reason-modal" role="presentation" hidden>
        <form class="late-reason-form" id="late-reason-form" role="dialog" aria-modal="true" aria-labelledby="late-reason-title">
            <div class="late-reason-grip"></div>
            <div class="late-reason-heading">
                <h2 id="late-reason-title">◈ Alasan Keterlambatan</h2>
                <button class="late-reason-close" type="button" data-late-reason-close aria-label="Tutup">×</button>
            </div>
            <p class="late-reason-intro">Beri penjelasan singkat mengenai keterlambatan presensi Anda hari ini untuk validasi tim HRD.</p>
            <div class="late-reason-context" id="late-reason-context">● Terlambat — menit &nbsp;•&nbsp; Shift Pagi (07:00 WIB)</div>
            <div class="late-reason-count"><label for="late-reason-input">Tuliskan Alasan Keterlambatan <strong>*</strong></label><span><b id="late-reason-length">0</b> / 250 karakter</span></div>
            <textarea id="late-reason-input" maxlength="250" required placeholder="Contoh: Terjadi kemacetan parah di jalan tol utama / kendala transportasi umum..."></textarea>
            <strong class="late-reason-quick-label">PILIH ALASAN CEPAT</strong>
            <div class="late-reason-quick-options">
                <button type="button" data-late-reason="Macet Lalu Lintas">▥ Macet Lalu Lintas</button>
                <button type="button" data-late-reason="Kendala Kendaraan">▣ Kendala Kendaraan</button>
                <button type="button" data-late-reason="Keperluan Mendesak">✱ Keperluan Mendesak</button>
                <button type="button" data-late-reason="Cuaca Hujan Deras">♧ Cuaca Hujan Deras</button>
            </div>
            <button class="late-reason-submit" type="submit">▷ Kirim Alasan</button>
            <button class="late-reason-cancel" type="button" data-late-reason-close>Batal</button>
        </form>
    </div>
    <script>
        const attendanceClock = document.querySelector('.attendance-clock');
        const attendanceDate = document.querySelector('.attendance-date');
        const scannerTrigger = document.getElementById('scan-trigger');
        const scannerHint = document.querySelector('.demo-hint');
        const resultOverlay = document.getElementById('attendance-result');
        const resultCard = document.getElementById('attendance-result-card');
        const networkOfflineOverlay = document.getElementById('network-offline-overlay');
        const networkOfflineTime = document.getElementById('network-offline-time');
        const networkOfflineStatus = document.getElementById('network-offline-status');
        const networkRetryButton = document.getElementById('network-retry-button');
        let networkConnectionAvailable = navigator.onLine;
        let attendanceCheckInProgress = false;
        const lateReasonModal = document.getElementById('late-reason-modal');
        const lateReasonInput = document.getElementById('late-reason-input');
        const lateReasonButton = document.getElementById('late-reason-open');
        const isCheckout = @json($mode === 'checkout');
        const indonesiaDate = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            timeZone: 'Asia/Jakarta'
        });

        function formatAttendanceTime(value) {
            return new Intl.DateTimeFormat('en-GB', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hourCycle: 'h23',
                timeZone: 'Asia/Jakarta'
            }).format(value);
        }

        function formatAttendanceDateTime(value) {
            const date = new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                timeZone: 'Asia/Jakarta'
            }).format(value);

            return `${date} • ${formatAttendanceTime(value)} WIB`;
        }

        function getJakartaParts(value) {
            return Object.fromEntries(new Intl.DateTimeFormat('en-GB', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hourCycle: 'h23',
                timeZone: 'Asia/Jakarta'
            }).formatToParts(value).map((part) => [part.type, part.value]));
        }

        function getJakartaDateKey(parts) {
            return `${parts.year}-${parts.month}-${parts.day}`;
        }

        function getAdminWorkSchedule() {
            const defaults = { workStart: '07:00', workEnd: '17:00', breakStart: '12:00', breakEnd: '13:00' };
            try {
                const schedule = JSON.parse(localStorage.getItem('attendance-admin-work-schedule') || 'null');
                if (!schedule || typeof schedule !== 'object') return defaults;
                const result = Object.fromEntries(Object.entries(defaults).map(([key, fallback]) => [
                    key,
                    typeof schedule[key] === 'string' && /^\d{2}:\d{2}$/.test(schedule[key]) ? schedule[key] : fallback
                ]));
                return result.workStart < result.breakStart &&
                    result.breakStart < result.breakEnd &&
                    result.breakEnd < result.workEnd ? result : defaults;
            } catch (error) {
                console.error('Could not read attendance-admin-work-schedule from local storage.', error);
                return defaults;
            }
        }

        function timeToSeconds(value) {
            const [hours, minutes] = value.split(':').map(Number);
            return hours * 3600 + minutes * 60;
        }

        function scheduleTimeLabel(value) {
            return value.replace(':', '.');
        }

        function updateAttendanceTime() {
            const now = new Date();
            attendanceClock.textContent = formatAttendanceTime(now);
            attendanceDate.textContent = indonesiaDate.format(now);
        }

        function updateScannerAvailability() {
            const parts = getJakartaParts(new Date());
            const storageKey = `attendance-${isCheckout ? 'checkout' : 'checkin'}-${getJakartaDateKey(parts)}`;
            const recorded = localStorage.getItem(storageKey) === 'recorded';
            const nowSeconds = Number(parts.hour) * 3600 + Number(parts.minute) * 60 + Number(parts.second);
            const schedule = getAdminWorkSchedule();
            const workStartSeconds = timeToSeconds(schedule.workStart);
            const workEndSeconds = timeToSeconds(schedule.workEnd);
            const outsideAttendanceWindow = isCheckout
                ? nowSeconds < workEndSeconds
                : nowSeconds < workStartSeconds || nowSeconds >= workEndSeconds;
            const offline = !navigator.onLine || !networkConnectionAvailable;
            scannerTrigger.disabled = recorded || outsideAttendanceWindow || offline;
            scannerHint.textContent = recorded
                ? `Presensi ${isCheckout ? 'pulang' : 'masuk'} sudah dilakukan hari ini.`
                : isCheckout
                    ? nowSeconds < workEndSeconds
                        ? `Presensi pulang dibuka pukul ${scheduleTimeLabel(schedule.workEnd)} WIB.`
                        : `Presensi pulang dibuka pukul ${scheduleTimeLabel(schedule.workEnd)} WIB. ${offline ? 'Presensi memerlukan jaringan internet aktif.' : 'Ketuk area pemindai untuk melakukan absensi.'}`
                    : outsideAttendanceWindow
                        ? nowSeconds < workStartSeconds
                            ? `Presensi masuk dibuka pukul ${scheduleTimeLabel(schedule.workStart)} WIB.`
                            : `Waktu presensi masuk sudah ditutup pukul ${scheduleTimeLabel(schedule.workEnd)} WIB.`
                        : offline ? 'Presensi memerlukan jaringan internet aktif.' : 'Ketuk area pemindai untuk melihat hasil presensi.';
        }

        function updateNetworkOfflineTime() {
            networkOfflineTime.textContent = `${formatAttendanceTime(new Date())} WIB`;
        }

        function showNetworkOffline() {
            networkConnectionAvailable = false;
            updateNetworkOfflineTime();
            networkOfflineStatus.textContent = 'Terputus (Offline)';
            networkOfflineStatus.classList.add('network-status-offline');
            networkOfflineOverlay.hidden = false;
            updateScannerAvailability();
        }

        async function checkNetworkConnection() {
            if (!navigator.onLine) return false;

            try {
                const response = await fetch(window.location.href, {
                    method: 'HEAD',
                    cache: 'no-store',
                    credentials: 'same-origin'
                });
                return response.ok;
            } catch (error) {
                if (error instanceof TypeError) return false;
                throw error;
            }
        }

        async function retryNetworkConnection() {
            networkRetryButton.disabled = true;
            networkRetryButton.textContent = 'Memeriksa koneksi...';
            networkOfflineStatus.textContent = 'Memeriksa...';
            networkOfflineStatus.classList.remove('network-status-offline');

            try {
                const connected = await checkNetworkConnection();
                networkConnectionAvailable = connected;
                if (connected) {
                    networkOfflineOverlay.hidden = true;
                    networkOfflineStatus.textContent = 'Terhubung (Online)';
                    updateScannerAvailability();
                    scannerTrigger.focus();
                    return;
                }

                networkOfflineStatus.textContent = 'Terputus (Offline)';
                networkOfflineStatus.classList.add('network-status-offline');
                updateNetworkOfflineTime();
            } finally {
                networkRetryButton.disabled = false;
                networkRetryButton.textContent = '↻ Coba Sambungkan Ulang';
            }
        }

        async function showAttendanceResult() {
            if (attendanceCheckInProgress) return;
            attendanceCheckInProgress = true;

            try {
                networkConnectionAvailable = await checkNetworkConnection();
            } catch (error) {
                attendanceCheckInProgress = false;
                updateScannerAvailability();
                throw error;
            }

            if (!networkConnectionAvailable) {
                showNetworkOffline();
                attendanceCheckInProgress = false;
                updateScannerAvailability();
                return;
            }
            const now = new Date();
            const parts = getJakartaParts(now);
            const attendanceStorageKey = `attendance-${isCheckout ? 'checkout' : 'checkin'}-${getJakartaDateKey(parts)}`;
            const nowSeconds = Number(parts.hour) * 3600 + Number(parts.minute) * 60 + Number(parts.second);
            const schedule = getAdminWorkSchedule();
            const workStartSeconds = timeToSeconds(schedule.workStart);
            const workEndSeconds = timeToSeconds(schedule.workEnd);
            const outsideAttendanceWindow = isCheckout
                ? nowSeconds < workEndSeconds
                : nowSeconds < workStartSeconds || nowSeconds >= workEndSeconds;
            if (localStorage.getItem(attendanceStorageKey) === 'recorded') {
                attendanceCheckInProgress = false;
                updateScannerAvailability();
                return;
            }
            if (outsideAttendanceWindow) {
                attendanceCheckInProgress = false;
                updateScannerAvailability();
                return;
            }
            const lateSeconds = nowSeconds - (workStartSeconds + 15 * 60);
            const isLate = !isCheckout && lateSeconds > 0;
            const latenessMinutes = Math.ceil(lateSeconds / 60);
            const reference = `PRS-${parts.year}${parts.month}${parts.day}-${parts.hour}${parts.minute}${parts.second}`;
            const title = document.getElementById('result-title');
            const description = document.getElementById('result-description');
            const icon = document.getElementById('result-icon');
            const pills = document.getElementById('result-pills');
            const details = document.getElementById('result-details');
            const closeButton = document.getElementById('result-close');

            localStorage.setItem(attendanceStorageKey, 'recorded');
            if (!isCheckout && isLate) {
                localStorage.setItem(`attendance-checkin-lateness-${getJakartaDateKey(parts)}`, String(lateSeconds));
            }
            updateScannerAvailability();

            resultCard.classList.toggle('late', isLate);
            icon.classList.toggle('warning', isLate);
            icon.textContent = isLate ? '!' : '✓';
            title.textContent = isLate ? 'Presensi Masuk Tercatat' : `${isCheckout ? 'Presensi Pulang' : 'Presensi Masuk'} Berhasil Dicatat!`;
            description.textContent = isLate
                ? 'Presensi berhasil dicatat, namun melewati batas toleransi masuk kerja.'
                : 'Data kehadiran Anda telah tercatat.';
            pills.innerHTML = isLate
                ? `<span class="result-pill">↪ Presensi Masuk</span><span class="result-pill late-pill">◷ Terlambat ${latenessMinutes} Menit</span>`
                : `<span class="result-pill">● ${isCheckout ? 'Presensi Pulang (Clock-Out)' : 'Presensi Masuk (Clock-In)'}</span>`;
            details.innerHTML = isLate
                ? `<div class="result-row"><span>◷ Waktu Masuk</span><strong>${formatAttendanceDateTime(now)}</strong></div><div class="result-row"><span>▣ Jadwal Shift</span><strong>${scheduleTimeLabel(schedule.workStart)} - ${scheduleTimeLabel(schedule.workEnd)} WIB</strong></div><div class="result-row"><span>◉ Batas Tepat Waktu</span><strong>Maks. ${scheduleTimeLabel(schedule.workStart)} WIB + 15 menit<br>(+${latenessMinutes} menit terlambat)</strong></div><div class="result-row"><span># ID Referensi</span><strong class="result-ref">#${reference}</strong></div>`
                : `<div class="result-row"><span>◷ Waktu &amp; Tanggal</span><strong>${formatAttendanceDateTime(now)}</strong></div><div class="result-row"><span>ID Referensi</span><strong class="result-ref">#${reference}</strong></div>`;
            lateReasonButton.hidden = !isLate;
            lateReasonButton.textContent = 'Ajukan Alasan Keterlambatan';
            if (isLate) {
                document.getElementById('late-reason-context').textContent = `● Terlambat ${latenessMinutes} Menit • Jam masuk ${scheduleTimeLabel(schedule.workStart)} WIB`;
                const savedReason = localStorage.getItem(`attendance-late-reason-${getJakartaDateKey(parts)}`) || '';
                lateReasonInput.value = savedReason;
                document.getElementById('late-reason-length').textContent = String(lateReasonInput.value.length);
                if (savedReason) lateReasonButton.textContent = 'Alasan Keterlambatan Terkirim';
            }
            closeButton.hidden = !isLate;
            resultOverlay.hidden = false;
            closeButton.focus();
            attendanceCheckInProgress = false;
        }

        scannerTrigger.addEventListener('click', showAttendanceResult);
        networkRetryButton.addEventListener('click', retryNetworkConnection);
        document.getElementById('network-offline-close').addEventListener('click', () => {
            networkOfflineOverlay.hidden = true;
            scannerTrigger.focus();
        });
        window.addEventListener('offline', showNetworkOffline);
        window.addEventListener('online', async () => {
            const connected = await checkNetworkConnection();
            networkConnectionAvailable = connected;
            if (connected) networkOfflineOverlay.hidden = true;
            else showNetworkOffline();
            updateScannerAvailability();
        });
        lateReasonButton.addEventListener('click', () => {
            lateReasonModal.hidden = false;
            lateReasonInput.focus();
        });
        document.querySelectorAll('[data-late-reason-close]').forEach((button) => {
            button.addEventListener('click', () => {
                lateReasonModal.hidden = true;
                lateReasonButton.focus();
            });
        });
        lateReasonModal.addEventListener('click', (event) => {
            if (event.target === lateReasonModal) {
                lateReasonModal.hidden = true;
                lateReasonButton.focus();
            }
        });
        lateReasonInput.addEventListener('input', () => {
            document.getElementById('late-reason-length').textContent = String(lateReasonInput.value.length);
        });
        document.querySelectorAll('[data-late-reason]').forEach((button) => {
            button.addEventListener('click', () => {
                const quickReason = button.dataset.lateReason;
                lateReasonInput.value = lateReasonInput.value
                    ? `${lateReasonInput.value.trim()}${lateReasonInput.value.trim().endsWith('.') ? ' ' : '. '}${quickReason}`
                    : quickReason;
                lateReasonInput.value = lateReasonInput.value.slice(0, 250);
                lateReasonInput.dispatchEvent(new Event('input'));
                lateReasonInput.focus();
            });
        });
        document.getElementById('late-reason-form').addEventListener('submit', (event) => {
            event.preventDefault();
            const parts = getJakartaParts(new Date());
            const reason = lateReasonInput.value.trim();
            if (!reason) {
                lateReasonInput.reportValidity();
                return;
            }
            localStorage.setItem(`attendance-late-reason-${getJakartaDateKey(parts)}`, reason);
            lateReasonModal.hidden = true;
            lateReasonButton.textContent = 'Alasan Keterlambatan Terkirim';
            lateReasonButton.focus();
        });
        document.getElementById('result-close').addEventListener('click', () => {
            resultOverlay.hidden = true;
            lateReasonModal.hidden = true;
            scannerTrigger.focus();
        });
        resultOverlay.addEventListener('click', (event) => {
            if (event.target === resultOverlay) {
                resultOverlay.hidden = true;
                scannerTrigger.focus();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !resultOverlay.hidden) {
                if (!lateReasonModal.hidden) {
                    lateReasonModal.hidden = true;
                    lateReasonButton.focus();
                } else {
                    resultOverlay.hidden = true;
                    scannerTrigger.focus();
                }
            }
        });

        updateAttendanceTime();
        updateScannerAvailability();
        showNetworkOffline();
        window.setInterval(updateAttendanceTime, 1000);
        window.setInterval(updateScannerAvailability, 1000);
        window.setInterval(() => {
            if (!networkOfflineOverlay.hidden) updateNetworkOfflineTime();
        }, 1000);
    </script>
@endsection
