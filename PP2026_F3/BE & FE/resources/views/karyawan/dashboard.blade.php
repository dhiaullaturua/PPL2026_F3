@extends('layouts.karyawan')

@section('content')
    <div class="app-shell">
        <div class="screen">
            <div class="greeting-bar">
                <span id="dashboard-greeting">Selamat Pagi, Debay!</span>
                <span class="dashboard-actions">
                    <a class="dashboard-notification" href="{{ route('karyawan.notifications') }}" aria-label="Notifikasi">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a4 4 0 0 1 4 4v1.2c0 1.1.4 2.1 1.1 2.9l1.3 1.6c.9 1.1.2 2.8-1.3 2.8H6.9c-1.5 0-2.2-1.7-1.3-2.8l1.3-1.6A4.7 4.7 0 0 0 8 8.2V7a4 4 0 0 1 4-4Zm0 18a2.7 2.7 0 0 1-2.6-2h5.2A2.7 2.7 0 0 1 12 21Z"/></svg>
                    </a>
                    <span class="wave">👋</span>
                </span>
            </div>

            <div class="clock-card">
                <div class="date-row">
                    <span class="calendar-badge">📅</span>
                    <span id="dashboard-date"></span>
                </div>

                <div class="time-row">
                    <span class="time" id="dashboard-time"></span>
                    <span class="timezone">WIB</span>
                </div>

                <div class="status-row">
                    <span class="live-dot"></span>
                    <span id="attendance-deadline-status"></span>
                </div>
            </div>

            <a class="attendance-row attendance-row--checkin" data-type="checkin" href="{{ route('karyawan.attendance.checkin') }}">
                <div class="action-icon">→</div>
                <div class="action-copy">
                    <div class="title-line">
                        <strong>Presensi Masuk</strong>
                        <span class="status-tag checkin-badge" hidden>Berhasil Hadir</span>
                    </div>
                    <small class="attendance-status">Tap untuk Melakukan Absensi</small>
                </div>
                <div class="action-chevron">→</div>
            </a>

            <a class="attendance-row pulang attendance-row--checkout is-locked" data-type="checkout" href="{{ route('karyawan.attendance.checkout') }}" aria-disabled="true" tabindex="-1">
                <div class="action-icon">→</div>
                <div class="action-copy">
                    <div class="title-line">
                        <strong>Presensi Pulang</strong>
                        <span class="status-tag locked checkout-badge">Terkunci</span>
                    </div>
                    <small class="attendance-status">Tersedia mulai pukul 17.00 WIB</small>
                </div>
                <div class="action-chevron" aria-hidden="true"><svg class="attendance-lock-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="2"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3"></path></svg></div>
            </a>

            <div class="section-card" id="calendar">
                <div class="calendar-header">
                    <h2>Kalender Kerja &amp; Shift</h2>
                    <div class="month-switch">
                        <button type="button" id="calendar-previous" aria-label="Bulan sebelumnya">‹</button>
                        <span class="month-label" id="calendar-month"></span>
                        <button type="button" id="calendar-next" aria-label="Bulan selanjutnya">›</button>
                    </div>
                </div>

                <div class="calendar-grid" id="calendar-grid" aria-label="Tanggal pada kalender"></div>

                <div class="legend">
                    <span class="legend-item"><span class="legend-dot green"></span> Hadir</span>
                    <span class="legend-item"><span class="legend-dot red"></span> Libur / tanggal penting</span>
                </div>
                <div class="calendar-date-details" id="calendar-date-details" aria-live="polite"></div>
            </div>

            <div class="summary-grid">
                <div class="summary-card">
                    <div class="label">Tepat Waktu</div>
                    <div class="summary-value-row">
                        <strong>21</strong>
                        <span class="summary-inline-detail summary-inline-detail--ontime">Hari</span>
                    </div>
                    <div class="tag-row"><span class="dot green"></span> Total tepat waktu bulan ini</div>
                </div>

                <div class="summary-card">
                    <div class="label">Terlambat</div>
                    <div class="summary-value-row">
                        <strong id="late-attendance-count">1</strong>
                        <span class="summary-inline-detail" id="late-attendance-duration">Belum tercatat</span>
                    </div>
                    <div class="tag-row"><span class="dot yellow"></span> Durasi total bulan ini</div>
                </div>

                <div class="summary-card summary-card--overtime">
                    <div class="label">Lembur</div>
                    <div class="summary-value-row">
                        <strong>4.5</strong>
                        <span class="summary-inline-detail summary-inline-detail--overtime">Jam</span>
                    </div>
                    <div class="tag-row"><span class="dot blue"></span> Total jam bulan ini</div>
                </div>
            </div>

            <div class="history">
                <div class="history-header">
                    <h3>Riwayat Pekerja</h3>
                    <a href="{{ route('karyawan.attendance.history') }}">Lihat Semua</a>
                </div>

                <div class="history-list">
                    <div class="history-item">
                        <div class="day-tag">
                            <strong>23</strong>
                            <span>RAB</span>
                        </div>
                        <div class="meta">
                            <div class="time-line">
                                <span class="shift">08:24 – 17:35</span>
                                <span>WIB</span>
                            </div>
                        </div>
                        <button class="badge green" type="button">Tepat Waktu</button>
                    </div>

                    <div class="history-item">
                        <div class="day-tag">
                            <strong>21</strong>
                            <span>SEN</span>
                        </div>
                        <div class="meta">
                            <div class="time-line">
                                <span class="shift">08:29 – 17:40</span>
                                <span>WIB</span>
                            </div>
                        </div>
                        <button class="badge green" type="button">Tepat Waktu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="employee-bottom-nav dashboard-bottom-nav" aria-label="Navigasi utama">
        <a class="active" href="{{ route('karyawan.dashboard') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10 12 3l9 7v10h-7v-6h-4v6H3z"/></svg><span>Beranda</span></a>
        <a href="{{ route('karyawan.attendance.history') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 2.6-6.4M3 4v5h5m4-2v5l4 2"/></svg><span>Riwayat</span></a>
        <a href="{{ route('karyawan.overtime.index') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18m-13 5 2 2 4-4"/></svg><span>Lembur</span></a>
        <a href="{{ route('karyawan.profile') }}"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg><span>Profil</span></a>
    </nav>

    <script>
        const dashboardDate = document.getElementById('dashboard-date');
        const dashboardTime = document.getElementById('dashboard-time');
        const dashboardGreeting = document.getElementById('dashboard-greeting');
        const attendanceDeadlineStatus = document.getElementById('attendance-deadline-status');
        const jakartaClockFormatter = new Intl.DateTimeFormat('en-GB', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hourCycle: 'h23',
            timeZone: 'Asia/Jakarta'
        });
        const jakartaDateFormatter = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            timeZone: 'Asia/Jakarta'
        });
        const calendarMonth = document.getElementById('calendar-month');
        const calendarGrid = document.getElementById('calendar-grid');
        const calendarDayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        const todayInJakarta = new Intl.DateTimeFormat('en-CA', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            timeZone: 'Asia/Jakarta'
        }).formatToParts(new Date());
        const todayParts = Object.fromEntries(todayInJakarta.map((part) => [part.type, part.value]));
        let visibleCalendarYear = Number(todayParts.year);
        let visibleCalendarMonth = Number(todayParts.month) - 1;
        let selectedCalendarDate = `${todayParts.year}-${todayParts.month}-${todayParts.day}`;
        const calendarDateDetails = document.getElementById('calendar-date-details');
        const indonesiaHolidayDates = {
            '2026-01-01': { name: 'Tahun Baru Masehi', dayOff: true },
            '2026-01-16': { name: 'Isra Mikraj Nabi Muhammad SAW', dayOff: true },
            '2026-02-17': { name: 'Tahun Baru Imlek', dayOff: true },
            '2026-03-19': { name: 'Hari Suci Nyepi', dayOff: true },
            '2026-03-20': { name: 'Cuti Bersama Idulfitri', dayOff: true },
            '2026-03-21': { name: 'Idulfitri 1447 H', dayOff: true },
            '2026-03-22': { name: 'Idulfitri 1447 H', dayOff: true },
            '2026-03-23': { name: 'Cuti Bersama Idulfitri', dayOff: true },
            '2026-03-24': { name: 'Cuti Bersama Idulfitri', dayOff: true },
            '2026-04-03': { name: 'Wafat Yesus Kristus', dayOff: true },
            '2026-04-05': { name: 'Kebangkitan Yesus Kristus', dayOff: true },
            '2026-04-21': { name: 'Hari Kartini', dayOff: false },
            '2026-05-01': { name: 'Hari Buruh Internasional', dayOff: true },
            '2026-05-14': { name: 'Kenaikan Yesus Kristus', dayOff: true },
            '2026-05-27': { name: 'Iduladha 1447 H', dayOff: true },
            '2026-05-31': { name: 'Hari Raya Waisak', dayOff: true },
            '2026-06-01': { name: 'Hari Lahir Pancasila', dayOff: true },
            '2026-06-17': { name: 'Tahun Baru Islam 1448 H', dayOff: true },
            '2026-08-17': { name: 'Hari Kemerdekaan Republik Indonesia', dayOff: true },
            '2026-08-25': { name: 'Maulid Nabi Muhammad SAW', dayOff: true },
            '2026-12-25': { name: 'Hari Raya Natal', dayOff: true }
        };

        function indonesiaDateEvent(dateKey) {
            const fixedDateEvents = {
                '01-01': { name: 'Tahun Baru Masehi', dayOff: true },
                '04-21': { name: 'Hari Kartini', dayOff: false },
                '05-01': { name: 'Hari Buruh Internasional', dayOff: true },
                '05-20': { name: 'Hari Kebangkitan Nasional', dayOff: false },
                '06-01': { name: 'Hari Lahir Pancasila', dayOff: true },
                '08-17': { name: 'Hari Kemerdekaan Republik Indonesia', dayOff: true },
                '10-01': { name: 'Hari Kesaktian Pancasila', dayOff: false },
                '11-10': { name: 'Hari Pahlawan', dayOff: false }
            };
            return indonesiaHolidayDates[dateKey] ||
                (fixedDateEvents[dateKey.slice(5)] && { ...fixedDateEvents[dateKey.slice(5)] })
                || null;
        }

        function readAdminHoliday(dateKey) {
            try {
                const holidays = JSON.parse(localStorage.getItem('attendance-admin-holidays') || '[]');
                if (!Array.isArray(holidays)) {
                    console.error('Expected attendance-admin-holidays in local storage to contain an array.');
                    return null;
                }
                return holidays.find((entry) => entry && entry.date === dateKey && typeof entry.name === 'string') || null;
            } catch (error) {
                console.error('Could not read attendance-admin-holidays from local storage.', error);
                return null;
            }
        }

        function readAdminSchedule(dateKey) {
            const weekdayKeys = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            const defaults = {
                workStart: '08:00',
                workEnd: '17:00',
                breakStart: '12:00',
                breakEnd: '13:00'
            };
            const date = new Date(`${dateKey}T00:00:00Z`);
            const dayKey = weekdayKeys[date.getUTCDay()];
            const defaultDay = date.getUTCDay() === 0 || date.getUTCDay() === 6
                ? { ...defaults, pattern: 'holiday' }
                : dayKey === 'monday'
                    ? { ...defaults, workStart: '09:00', breakStart: '15:00', breakEnd: '16:00', pattern: 'work' }
                    : { ...defaults, pattern: 'work' };
            if (date.getUTCDay() === 0 || date.getUTCDay() === 6) return defaultDay;
            try {
                const saved = JSON.parse(localStorage.getItem('attendance-admin-work-schedule') || 'null');
                if (!saved || typeof saved !== 'object') return defaultDay;
                const entry = saved.days && saved.days[dayKey]
                    ? saved.days[dayKey]
                    : saved.workStart && date.getUTCDay() !== 0 && date.getUTCDay() !== 6
                        ? { ...saved, pattern: 'work' }
                        : null;
                if (!entry || typeof entry !== 'object') return defaultDay;
                const result = {
                    pattern: entry.pattern === 'holiday' ? 'holiday' : 'work',
                    workStart: typeof entry.workStart === 'string' && /^\d{2}:\d{2}$/.test(entry.workStart) ? entry.workStart : defaults.workStart,
                    workEnd: typeof entry.workEnd === 'string' && /^\d{2}:\d{2}$/.test(entry.workEnd) ? entry.workEnd : defaults.workEnd,
                    breakStart: typeof entry.breakStart === 'string' && /^\d{2}:\d{2}$/.test(entry.breakStart) ? entry.breakStart : defaults.breakStart,
                    breakEnd: typeof entry.breakEnd === 'string' && /^\d{2}:\d{2}$/.test(entry.breakEnd) ? entry.breakEnd : defaults.breakEnd
                };
                return result.pattern === 'holiday' ||
                    result.workStart < result.breakStart &&
                    result.breakStart < result.breakEnd &&
                    result.breakEnd < result.workEnd ? result : defaultDay;
            } catch (error) {
                console.error('Could not read attendance-admin-work-schedule from local storage.', error);
                return defaultDay;
            }
        }

        function escapeCalendarText(value) {
            return String(value).replace(/[&<>"']/g, (character) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;',
            })[character]);
        }

        function formatLatenessDuration(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            const parts = [];

            if (hours) parts.push(`${hours} jam`);
            if (minutes) parts.push(`${minutes} menit`);
            if (seconds || parts.length === 0) parts.push(`${seconds} detik`);

            return parts.join(' ');
        }

        function updateAttendanceSummary() {
            const monthPrefix = `attendance-checkin-lateness-${todayParts.year}-${todayParts.month}-`;
            const lateSeconds = Object.keys(localStorage)
                .filter((key) => key.startsWith(monthPrefix))
                .map((key) => Number(localStorage.getItem(key)))
                .filter((seconds) => Number.isFinite(seconds) && seconds > 0);

            if (lateSeconds.length === 0) return;

            document.getElementById('late-attendance-count').textContent = String(lateSeconds.length);
            document.getElementById('late-attendance-duration').textContent = formatLatenessDuration(
                lateSeconds.reduce((total, seconds) => total + seconds, 0)
            );
        }

        function renderCalendar() {
            const monthStart = new Date(Date.UTC(visibleCalendarYear, visibleCalendarMonth, 1));
            const monthEnd = new Date(Date.UTC(visibleCalendarYear, visibleCalendarMonth + 1, 0));
            const leadingDays = (monthStart.getUTCDay() + 6) % 7;
            const cellCount = Math.ceil((leadingDays + monthEnd.getUTCDate()) / 7) * 7;

            calendarMonth.textContent = new Intl.DateTimeFormat('id-ID', {
                month: 'long',
                year: 'numeric',
                timeZone: 'UTC'
            }).format(monthStart);

            const cells = calendarDayNames
                .map((name, index) => `<div class="day-name${index >= 5 ? ' weekend' : ''}">${name}</div>`)
                .join('');
            const dates = Array.from({ length: cellCount }, (_, index) => {
                const date = new Date(Date.UTC(visibleCalendarYear, visibleCalendarMonth, index - leadingDays + 1));
                const isCurrentMonth = date.getUTCMonth() === visibleCalendarMonth;
                const dateKey = date.toISOString().slice(0, 10);
                const holiday = readAdminHoliday(dateKey);
                const dateEvent = indonesiaDateEvent(dateKey);
                const holidayName = holiday?.name || dateEvent?.name;
                const weekday = date.getUTCDay();
                const isWeekend = weekday === 0 || weekday === 6;
                const isHoliday = Boolean(holiday) || isWeekend || Boolean(dateEvent?.dayOff) || readAdminSchedule(dateKey).pattern === 'holiday';
                const isAttended = isCurrentMonth && localStorage.getItem(`attendance-checkin-${dateKey}`) === 'recorded';
                const classes = ['day-cell'];

                if (!isCurrentMonth) classes.push('muted');
                if (isCurrentMonth && isHoliday) classes.push('holiday');
                else if (isCurrentMonth && dateEvent) classes.push('national-event');
                if (isAttended) classes.push('attended');
                if (dateKey === selectedCalendarDate) classes.push('selected');

                const status = holidayName || (isHoliday ? 'Hari Libur' : isAttended ? 'Hadir' : '');
                const safeStatus = escapeCalendarText(status);
                const label = `${date.getUTCDate()} ${new Intl.DateTimeFormat('id-ID', { month: 'long', timeZone: 'UTC' }).format(date)} ${date.getUTCFullYear()}${status ? `, ${safeStatus}` : ''}`;

                return `<button type="button" class="${classes.join(' ')}" data-calendar-date="${dateKey}" aria-label="${label}" aria-pressed="${dateKey === selectedCalendarDate}"${status ? ` title="${safeStatus}"` : ''}>${date.getUTCDate()}</button>`;
            }).join('');

            calendarGrid.innerHTML = cells + dates;
            renderCalendarDateDetails();
        }

        function renderCalendarDateDetails() {
            const date = new Date(`${selectedCalendarDate}T00:00:00Z`);
            const holiday = readAdminHoliday(selectedCalendarDate);
            const dateEvent = indonesiaDateEvent(selectedCalendarDate);
            const attended = localStorage.getItem(`attendance-checkin-${selectedCalendarDate}`) === 'recorded';
            const schedule = readAdminSchedule(selectedCalendarDate);
            const weekday = date.getUTCDay();
            const isWeekend = weekday === 0 || weekday === 6;
            const dateLabel = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                timeZone: 'UTC'
            }).format(date);
            const isHoliday = Boolean(holiday) || isWeekend || Boolean(dateEvent?.dayOff) || schedule.pattern === 'holiday';
            const status = isHoliday ? 'Hari Libur' : attended ? 'Hadir' : 'Jadwal Kerja';
            const note = holiday
                ? `<p class="calendar-date-note"><strong>Keterangan Admin:</strong> ${escapeCalendarText(holiday.name)}${holiday.createdBy ? ` <small>· Ditentukan oleh ${escapeCalendarText(holiday.createdBy)}</small>` : ''}</p>`
                : dateEvent
                    ? `<p class="calendar-date-note"><strong>Tanggal penting:</strong> ${escapeCalendarText(dateEvent.name)}${dateEvent.dayOff ? '' : ' · Bukan hari libur nasional'}</p>`
                    : isWeekend || schedule.pattern === 'holiday'
                    ? '<p class="calendar-date-note">Sabtu dan Minggu merupakan hari libur.</p>'
                    : '<p class="calendar-date-note">Tidak ada keterangan hari libur dari Admin.</p>';

            const scheduleDetails = !isHoliday && schedule.pattern === 'work' ? `
                <dl class="calendar-date-schedule">
                    <div><dt>Masuk kerja</dt><dd>${escapeCalendarText(schedule.workStart)} WIB</dd></div>
                    <div><dt>Mulai istirahat</dt><dd>${escapeCalendarText(schedule.breakStart)} WIB</dd></div>
                    <div><dt>Selesai istirahat</dt><dd>${escapeCalendarText(schedule.breakEnd)} WIB</dd></div>
                    <div><dt>Jam pulang</dt><dd>${escapeCalendarText(schedule.workEnd)} WIB</dd></div>
                </dl>
            ` : '';

            calendarDateDetails.innerHTML = `
                <strong>${escapeCalendarText(dateLabel)} · ${status}</strong>
                ${note}
                ${scheduleDetails}
            `;
        }

        calendarGrid.addEventListener('click', (event) => {
            const day = event.target.closest('[data-calendar-date]');
            if (!day) return;
            selectedCalendarDate = day.dataset.calendarDate;
            const [year, month] = selectedCalendarDate.split('-').map(Number);
            visibleCalendarYear = year;
            visibleCalendarMonth = month - 1;
            renderCalendar();
        });

        window.addEventListener('storage', (event) => {
            if (event.key === 'attendance-admin-holidays' ||
                event.key === 'attendance-admin-work-schedule' ||
                (event.key && event.key.startsWith('attendance-checkin-'))) {
                renderCalendar();
            }
        });

        function updateDashboardClock() {
            const now = new Date();
            const parts = jakartaClockFormatter.formatToParts(now);
            const value = (type) => Number(parts.find((part) => part.type === type).value);
            const hour = value('hour');
            const minute = value('minute');
            const second = value('second');
            const currentSeconds = hour * 3600 + minute * 60 + second;
            const todayDateKey = `${todayParts.year}-${todayParts.month}-${todayParts.day}`;
            const schedule = readAdminSchedule(todayDateKey);
            const workStartSeconds = timeToSeconds(schedule.workStart);
            const workEndSeconds = timeToSeconds(schedule.workEnd);
            const onTimeUntilSeconds = workStartSeconds + 15 * 60;
            const isWorkday = schedule.pattern === 'work' && !readAdminHoliday(todayDateKey);

            dashboardDate.textContent = jakartaDateFormatter.format(now);
            dashboardTime.textContent = jakartaClockFormatter.format(now);
            dashboardGreeting.textContent = `${hour >= 4 && hour < 11 ? 'Selamat Pagi' : hour < 15 ? 'Selamat Siang' : hour < 18 ? 'Selamat Sore' : 'Selamat Malam'}, Debay!`;
            attendanceDeadlineStatus.textContent = !isWorkday
                ? 'Hari ini jadwal libur'
                : currentSeconds < workStartSeconds
                ? `Presensi masuk dibuka pukul ${schedule.workStart} WIB`
                : currentSeconds <= onTimeUntilSeconds
                    ? `Batas tepat waktu hingga pukul ${formatSecondsAsTime(onTimeUntilSeconds)} WIB`
                    : currentSeconds < workEndSeconds
                        ? `Lewat batas tepat waktu; presensi masuk ditutup pukul ${schedule.workEnd} WIB`
                        : `Presensi masuk ditutup pukul ${schedule.workEnd} WIB`;
        }

        function timeToSeconds(value) {
            const [hours, minutes] = value.split(':').map(Number);
            return hours * 3600 + minutes * 60;
        }

        function formatSecondsAsTime(totalSeconds) {
            const hours = String(Math.floor(totalSeconds / 3600) % 24).padStart(2, '0');
            const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            return `${hours}.${minutes}`;
        }

        (function () {
            const checkin = document.querySelector('.attendance-row--checkin');
            const checkout = document.querySelector('.attendance-row--checkout');
            const checkinBadge = checkin.querySelector('.checkin-badge');
            const checkinStatus = checkin.querySelector('.attendance-status');
            const checkoutStatus = checkout.querySelector('.attendance-status');
            const checkoutTag = checkout.querySelector('.status-tag');
            const checkoutIndicator = checkout.querySelector('.action-chevron');
            const lockIcon = '<svg class="attendance-lock-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="11" rx="2"></rect><path d="M8 10V7a4 4 0 0 1 8 0v3"></path></svg>';

            function getJakartaDateKey() {
                const parts = new Intl.DateTimeFormat('en-CA', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    timeZone: 'Asia/Jakarta'
                }).formatToParts(new Date());
                const value = (type) => parts.find((part) => part.type === type).value;

                return `${value('year')}-${value('month')}-${value('day')}`;
            }

            function updateCheckinBadge() {
                const recorded = localStorage.getItem(`attendance-checkin-${getJakartaDateKey()}`) === 'recorded';
                const now = getJakartaSeconds();
                const schedule = readAdminSchedule(getJakartaDateKey());
                const workStartSeconds = timeToSeconds(schedule.workStart);
                const workEndSeconds = timeToSeconds(schedule.workEnd);
                const onTimeUntilSeconds = workStartSeconds + 15 * 60;
                const isWorkday = schedule.pattern === 'work' && !readAdminHoliday(getJakartaDateKey());
                const checkinAvailable = isWorkday && now >= workStartSeconds && now < workEndSeconds;
                const canCheckin = checkinAvailable && !recorded;

                checkin.classList.toggle('is-locked', !canCheckin);
                checkin.setAttribute('aria-disabled', String(!canCheckin));
                checkinBadge.hidden = !recorded;
                if (recorded) {
                    checkinStatus.textContent = 'Presensi masuk sudah dilakukan hari ini';
                    checkin.setAttribute('tabindex', '-1');
                } else if (!checkinAvailable) {
                    checkinStatus.textContent = !isWorkday
                        ? 'Hari ini jadwal libur'
                        : now < workStartSeconds
                            ? `Presensi masuk dibuka pukul ${schedule.workStart}`
                            : `Presensi masuk ditutup pukul ${schedule.workEnd}`;
                    checkin.setAttribute('tabindex', '-1');
                } else {
                    checkinStatus.textContent = now <= onTimeUntilSeconds
                        ? `Tepat waktu sampai ${formatSecondsAsTime(onTimeUntilSeconds)}; presensi ditutup ${schedule.workEnd}`
                        : `Status terlambat; presensi ditutup ${schedule.workEnd}`;
                    checkin.removeAttribute('tabindex');
                }
            }

            function getJakartaSeconds() {
                const parts = new Intl.DateTimeFormat('en-GB', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hourCycle: 'h23',
                    timeZone: 'Asia/Jakarta'
                }).formatToParts(new Date());
                const value = (type) => Number(parts.find((part) => part.type === type).value);

                return value('hour') * 3600 + value('minute') * 60 + value('second');
            }

            function updateAttendanceActions() {
                const now = getJakartaSeconds();
                const dateKey = getJakartaDateKey();
                const schedule = readAdminSchedule(dateKey);
                const workEnd = timeToSeconds(schedule.workEnd);
                const isWorkday = schedule.pattern === 'work' && !readAdminHoliday(dateKey);
                const checkoutRecorded = localStorage.getItem(`attendance-checkout-${dateKey}`) === 'recorded';
                const canCheckout = isWorkday && now >= workEnd && !checkoutRecorded;

                checkout.classList.toggle('is-locked', !canCheckout);
                checkout.classList.toggle('is-recorded', checkoutRecorded);
                checkout.classList.toggle('is-available', canCheckout);
                checkout.setAttribute('aria-disabled', String(!canCheckout));
                if (canCheckout) {
                    checkout.removeAttribute('tabindex');
                    checkoutTag.hidden = true;
                    checkoutTag.textContent = 'Bisa Absen';
                    checkoutTag.classList.remove('locked');
                    checkoutStatus.textContent = 'Absensi sudah bisa dibuka';
                    checkoutIndicator.textContent = '→';
                } else if (checkoutRecorded) {
                    checkout.setAttribute('tabindex', '-1');
                    checkoutTag.hidden = false;
                    checkoutTag.textContent = 'Berhasil Pulang';
                    checkoutTag.classList.add('locked');
                    checkoutStatus.textContent = 'Presensi pulang sudah dilakukan hari ini';
                    checkoutIndicator.innerHTML = lockIcon;
                } else {
                    checkout.setAttribute('tabindex', '-1');
                    checkoutTag.hidden = false;
                    checkoutTag.textContent = 'Terkunci';
                    checkoutTag.classList.add('locked');
                    checkoutStatus.textContent = !isWorkday
                        ? 'Hari ini jadwal libur'
                        : `Tersedia mulai pukul ${schedule.workEnd} WIB`;
                    checkoutIndicator.innerHTML = lockIcon;
                }
            }

            checkin.addEventListener('click', function (event) {
                if (checkin.getAttribute('aria-disabled') === 'true') event.preventDefault();
            });
            checkout.addEventListener('click', function (event) {
                if (checkout.getAttribute('aria-disabled') === 'true') {
                    event.preventDefault();
                }
            });

            updateAttendanceActions();
            updateCheckinBadge();
            updateDashboardClock();
            window.setInterval(updateDashboardClock, 1000);
            window.setInterval(updateAttendanceActions, 1000);
            window.setInterval(updateCheckinBadge, 1000);
        })();
        document.getElementById('calendar-previous').addEventListener('click', () => {
            visibleCalendarMonth -= 1;
            if (visibleCalendarMonth < 0) {
                visibleCalendarMonth = 11;
                visibleCalendarYear -= 1;
            }
            renderCalendar();
        });
        document.getElementById('calendar-next').addEventListener('click', () => {
            visibleCalendarMonth += 1;
            if (visibleCalendarMonth > 11) {
                visibleCalendarMonth = 0;
                visibleCalendarYear += 1;
            }
            renderCalendar();
        });
        renderCalendar();
        updateAttendanceSummary();
    </script>
@endsection