(() => {
    const periodTitle = document.getElementById('history-period-title');
    const periodRange = document.getElementById('history-period-range');
    const periodLabel = document.getElementById('history-period-label');
    const metrics = document.getElementById('history-metrics');
    const summaryTitle = document.getElementById('history-summary-title');
    const sectionTitle = document.getElementById('history-section-title');
    const sectionHeading = document.querySelector('.history-section-heading');
    const recordCount = document.getElementById('history-record-count');
    const filters = document.getElementById('history-filters');
    const recordsContainer = document.getElementById('history-records');
    const emptyMessage = document.getElementById('history-empty');
    const downloadButton = document.getElementById('history-download');
    let activeFilter = 'all';
    let activeRecords = [];

    const monthFormatter = new Intl.DateTimeFormat('id-ID', { month: 'long', timeZone: 'UTC' });
    const shortMonthFormatter = new Intl.DateTimeFormat('id-ID', { month: 'short', timeZone: 'UTC' });
    const weekdayFormatter = new Intl.DateTimeFormat('id-ID', { weekday: 'long', timeZone: 'UTC' });
    const todayParts = Object.fromEntries(
        new Intl.DateTimeFormat('en-US', {
            day: 'numeric',
            month: 'numeric',
            year: 'numeric',
            timeZone: 'Asia/Jakarta',
        }).formatToParts(new Date()).map(({ type, value }) => [type, value]),
    );
    let selectedDate = new Date(Date.UTC(
        Number(todayParts.year),
        Number(todayParts.month) - 1,
        Number(todayParts.day),
    ));

    function getMonthlyRecords() {
        const year = selectedDate.getUTCFullYear();
        const month = selectedDate.getUTCMonth();
        const daysInMonth = new Date(Date.UTC(year, month + 1, 0)).getUTCDate();
        const dates = [];
        for (let day = 1; day <= daysInMonth; day += 1) {
            const date = new Date(Date.UTC(year, month, day));
            if (date.getUTCDay() !== 0 && date.getUTCDay() !== 6) dates.push(date);
        }

        return dates.slice(-20).reverse().map((date, index) => {
            if (index === 0) return { date, category: 'ontime', time: '08:15 - 17:30 WIB', duration: '9 Jam 15 Mnt' };
            if (index === 1) return { date, category: 'late', time: '08:42 - 17:35 WIB', duration: '8 Jam 53 Mnt', note: 'Kendala kemacetan parah di Jl. Setiabudi' };
            if (index === 2) return { date, category: 'overtime', time: '08:20 - 21:00 WIB', duration: '12 Jam 40 Mnt', note: 'Penyelesaian Pengerjaan Kantor.' };
            return { date, category: 'ontime', time: '08:05 - 17:00 WIB', duration: '8 Jam 55 Mnt' };
        });
    }

    function getRecords() {
        return getMonthlyRecords();
    }

    function renderMetrics() {
        const items = [
            ['✓', 'Total Hadir', '18', 'Hari', 'green wide'],
            ['◉', 'Terlambat', '1', 'Hari', 'orange'],
            ['◴', 'Lembur', '1', 'Hari · 3.5 Jam', 'blue'],
        ];

        metrics.innerHTML = items.map(([icon, label, value, unit, color]) => `
            <div class="history-metric ${color}">
                <span class="history-metric-icon" aria-hidden="true">${icon}</span>
                <span class="history-metric-copy"><small>${label}</small><strong>${value} <span>${unit}</span></strong></span>
            </div>
        `).join('');
    }

    function renderPeriod() {
        const year = selectedDate.getUTCFullYear();
        periodLabel.textContent = 'PERIODE PRESENSI';
        sectionHeading.hidden = false;
        periodTitle.textContent = `${monthFormatter.format(selectedDate)} ${year}`;
        periodRange.textContent = '';
        summaryTitle.textContent = 'Ringkasan Bulan Ini';
        sectionTitle.textContent = 'Catatan Harian';
        downloadButton.textContent = '⇩　Unduh Rekap Bulanan (PDF)';

        renderMetrics();
        renderRecords();
    }

    function recordMarkup(record) {
        const category = record.category;
        const status = category === 'late' ? 'Terlambat 12 Mnt' : category === 'overtime' ? 'Lembur 3.5 Jam' : 'Tepat Waktu';
        const symbol = category === 'late' ? '◉' : category === 'overtime' ? '◷' : '✓';
        const date = record.date;
        return `
            <article class="history-record-card" data-category="${category}">
                <div class="history-record-heading">
                    <strong class="history-record-date"><span class="record-symbol ${category}">${symbol}</span>${weekdayFormatter.format(date)}, ${date.getUTCDate()} ${shortMonthFormatter.format(date)} ${date.getUTCFullYear()}</strong>
                    <span class="history-status ${category}">${status}</span>
                </div>
                <div class="history-record-work">
                    <span><small>Jam Kerja</small><strong>${record.time}</strong></span>
                    <span class="history-duration">${record.duration}</span>
                </div>
                ${record.note ? `<p class="history-record-note"><strong>${category === 'late' ? 'Alasan Keterlambatan' : 'Keterangan Lembur'}</strong>${record.note}</p>` : ''}
            </article>
        `;
    }

    function renderRecords() {
        activeRecords = getRecords();
        filters.hidden = false;
        recordsContainer.hidden = false;
        recordCount.textContent = `${activeRecords.length} Aktivitas Tercatat`;
        recordsContainer.innerHTML = activeRecords.map(recordMarkup).join('');
        updateFilterButtons();
    }

    function updateFilterButtons() {
        const counts = activeRecords.reduce((result, record) => {
            result[record.category] += 1;
            return result;
        }, { ontime: 0, late: 0, overtime: 0 });

        filters.querySelectorAll('.history-filter').forEach((button) => {
            const filter = button.dataset.filter;
            const count = filter === 'all' ? activeRecords.length : counts[filter];
            const label = button.dataset.label;
            button.textContent = `${label} (${count})`;
            button.classList.toggle('active', filter === activeFilter);
        });
        let visibleCount = 0;
        recordsContainer.querySelectorAll('.history-record-card').forEach((card) => {
            const visible = activeFilter === 'all' || card.dataset.category === activeFilter;
            card.hidden = !visible;
            if (visible) visibleCount += 1;
        });
        emptyMessage.hidden = visibleCount > 0;
    }

    filters.querySelectorAll('.history-filter').forEach((button) => {
        button.addEventListener('click', () => {
            activeFilter = button.dataset.filter;
            updateFilterButtons();
        });
    });

    document.getElementById('history-previous').addEventListener('click', () => {
        selectedDate.setUTCMonth(selectedDate.getUTCMonth() - 1);
        renderPeriod();
    });
    document.getElementById('history-next').addEventListener('click', () => {
        selectedDate.setUTCMonth(selectedDate.getUTCMonth() + 1);
        renderPeriod();
    });
    downloadButton.addEventListener('click', () => window.print());

    renderPeriod();
})();
