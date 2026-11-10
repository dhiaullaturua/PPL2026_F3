(() => {
    const page = document.body.dataset.adminPage;

    function readStoredObject(key) {
        try {
            const value = JSON.parse(localStorage.getItem(key) || '{}');
            if (value && typeof value === 'object' && !Array.isArray(value)) return value;
            console.error(`Expected ${key} in local storage to contain an object.`);
            return {};
        } catch (error) {
            console.error(`Could not read ${key} from local storage.`, error);
            return {};
        }
    }

    function writeStoredObject(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
            return true;
        } catch (error) {
            console.error(`Could not save ${key} to local storage.`, error);
            return false;
        }
    }

    if (page === 'monitor') {
        const clock = document.getElementById('admin-live-clock');
        const refreshClock = () => {
            clock.textContent = `${new Intl.DateTimeFormat('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta',
            }).format(new Date())} WIB`;
        };
        refreshClock();
        window.setInterval(refreshClock, 1000);

        document.querySelectorAll('[data-quick-decision]').forEach((button) => {
            button.addEventListener('click', () => {
                const decisions = readStoredObject('attendance-admin-monitor-decisions');
                decisions['late-quick-001'] = button.dataset.quickDecision;
                if (!writeStoredObject('attendance-admin-monitor-decisions', decisions)) return;
                document.querySelector('.admin-quick-review').innerHTML = `
                    <p class="admin-decision-notice">Pengajuan Bambang Triantoro ${button.dataset.quickDecision === 'approved' ? 'diberi toleransi' : 'dicatat terlambat'}.</p>
                    <a href="?page=admin-keterlambatan">Lihat antrean verifikasi keterlambatan</a>
                `;
            });
        });

        document.getElementById('admin-sync-refresh').addEventListener('click', (event) => {
            const button = event.currentTarget;
            button.disabled = true;
            button.textContent = '✓';
            button.closest('.admin-sync-card').querySelector('p').textContent = 'Sinkronisasi diperbarui sekarang';
            window.setTimeout(() => {
                button.disabled = false;
                button.textContent = '↻';
            }, 900);
        });
    }

    if (page === 'recap') {
        const search = document.getElementById('admin-employee-search');
        const cards = Array.from(document.querySelectorAll('.admin-employee-card'));
        const empty = document.getElementById('admin-employee-empty');
        const tabs = Array.from(document.querySelectorAll('[data-recap-period]'));
        const monthPicker = document.getElementById('admin-recap-month');

        function filterEmployees() {
            const query = search.value.trim().toLocaleLowerCase('id-ID');
            let visible = 0;
            cards.forEach((card) => {
                const matches = card.dataset.employeeName.includes(query);
                card.hidden = !matches;
                visible += Number(matches);
            });
            empty.hidden = visible > 0;
        }

        function updatePeriod() {
            const period = tabs.find((tab) => tab.classList.contains('active')).dataset.recapPeriod;
            monthPicker.disabled = period !== 'monthly';
            const titles = {
                weekly: 'Rekap Pegawai · Mingguan',
                monthly: 'Rekap Pegawai',
                yearly: 'Rekap Pegawai · Tahunan',
            };
            document.querySelector('.admin-list-title h2').childNodes[0].textContent = `${titles[period]} `;
        }

        tabs.forEach((tab) => tab.addEventListener('click', () => {
            tabs.forEach((item) => item.classList.toggle('active', item === tab));
            updatePeriod();
        }));
        search.addEventListener('input', filterEmployees);
        monthPicker.addEventListener('change', () => {
            const selected = monthPicker.options[monthPicker.selectedIndex].textContent;
            document.querySelector('.admin-month-picker select').setAttribute('aria-label', `Pilih bulan, ${selected}`);
        });
        updatePeriod();
    }

    if (page === 'lateness') {
        const cards = Array.from(document.querySelectorAll('.admin-lateness-card'));
        const filters = Array.from(document.querySelectorAll('[data-reason-filter]'));
        const empty = document.getElementById('admin-late-empty');
        const decisions = readStoredObject('attendance-admin-lateness-decisions');

        function renderCards(filter = 'all') {
            let visibleCount = 0;
            cards.forEach((card) => {
                const resolved = Object.hasOwn(decisions, card.dataset.decisionId);
                const visible = !resolved && (filter === 'all' || card.dataset.reason === filter);
                card.hidden = !visible;
                visibleCount += Number(visible);
            });
            empty.hidden = visibleCount > 0;
            document.getElementById('admin-late-pending-count').textContent = String(
                Math.max(0, 14 - Object.keys(decisions).filter((id) => id.startsWith('late-')).length),
            );
        }

        filters.forEach((button) => {
            button.addEventListener('click', () => {
                filters.forEach((item) => item.classList.toggle('active', item === button));
                renderCards(button.dataset.reasonFilter);
            });
        });

        cards.forEach((card) => {
            card.querySelector('.admin-late-reject').addEventListener('click', () => decide(card, 'rejected'));
            card.querySelector('.admin-late-accept').addEventListener('click', () => decide(card, 'approved'));
        });

        function decide(card, decision) {
            decisions[card.dataset.decisionId] = decision;
            if (!writeStoredObject('attendance-admin-lateness-decisions', decisions)) return;
            card.hidden = true;
            renderCards(filters.find((button) => button.classList.contains('active')).dataset.reasonFilter);
        }

        renderCards();
    }

    if (page === 'logs') {
        const dateLabel = document.querySelector('.admin-log-toolbar > span');
        const search = document.getElementById('admin-log-search');
        const cards = Array.from(document.querySelectorAll('.admin-log-card'));
        const filters = Array.from(document.querySelectorAll('[data-log-filter]'));
        const empty = document.getElementById('admin-log-empty');
        let activeFilter = 'all';
        let loadedCount = cards.length;
        dateLabel.textContent = `◷ Hari ini, ${new Intl.DateTimeFormat('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric',
            timeZone: 'Asia/Jakarta',
        }).format(new Date())} • ${new Intl.DateTimeFormat('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            timeZone: 'Asia/Jakarta',
        }).format(new Date())} WIB`;

        function filterLogs() {
            const query = search.value.trim().toLocaleLowerCase('id-ID');
            let visible = 0;
            cards.forEach((card) => {
                const matches = card.dataset.name.includes(query)
                    && (activeFilter === 'all' || card.dataset.logStatus === activeFilter);
                card.hidden = !matches;
                visible += Number(matches);
            });
            empty.hidden = visible > 0;
            document.getElementById('admin-log-visible').textContent = String(visible);
        }

        search.addEventListener('input', filterLogs);
        filters.forEach((button) => {
            button.addEventListener('click', () => {
                activeFilter = button.dataset.logFilter;
                filters.forEach((item) => item.classList.toggle('active', item === button));
                filterLogs();
            });
        });
        document.getElementById('admin-log-more').addEventListener('click', (event) => {
            event.currentTarget.textContent = `Data demo hanya menyediakan ${loadedCount} log terbaru.`;
            event.currentTarget.disabled = true;
        });
        document.getElementById('admin-log-refresh').addEventListener('click', (event) => {
            event.currentTarget.textContent = '✓';
            window.setTimeout(() => {
                event.currentTarget.textContent = '↻';
            }, 900);
        });
        filterLogs();
    }

    const modal = document.getElementById('admin-export-modal');
    if (!modal) return;

    const closeButton = modal.querySelector('.admin-modal-close');
    const dateSummary = document.getElementById('admin-export-dates');
    const customDates = document.getElementById('admin-custom-dates');
    const periodButtons = Array.from(modal.querySelectorAll('[data-export-period]'));
    const componentChecks = Array.from(modal.querySelectorAll('[data-export-component]'));
    const toggleAll = document.getElementById('admin-export-toggle-all');
    const submit = document.getElementById('admin-export-submit');
    let focusBeforeOpen;

    function openModal() {
        focusBeforeOpen = document.activeElement;
        modal.hidden = false;
        closeButton.focus();
    }

    function closeModal() {
        modal.hidden = true;
        if (focusBeforeOpen instanceof HTMLElement) focusBeforeOpen.focus();
    }

    document.querySelectorAll('[data-open-export]').forEach((button) => {
        button.addEventListener('click', openModal);
    });
    closeButton.addEventListener('click', closeModal);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) closeModal();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.hidden) closeModal();
    });

    function setPeriod(period) {
        periodButtons.forEach((button) => button.classList.toggle('active', button.dataset.exportPeriod === period));
        customDates.hidden = period !== 'custom';
        if (period === 'custom') {
            dateSummary.textContent = 'Pilih rentang tanggal kustom';
            updateSubmitState();
            return;
        }
        const date = new Date();
        if (period === 'previous') date.setMonth(date.getMonth() - 1);
        const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        const formatter = new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        const workDays = Array.from({ length: lastDay.getDate() }, (_, index) => {
            const weekday = new Date(date.getFullYear(), date.getMonth(), index + 1).getDay();
            const day = new Date(date.getFullYear(), date.getMonth(), index + 1);
            return weekday !== 0 && weekday !== 6 && !isFixedPublicHoliday(day);
        }).filter(Boolean).length;
        dateSummary.innerHTML = `${formatter.format(firstDay)} - ${formatter.format(lastDay)} <span>${workDays} Hari Kerja</span>`;
        updateFilename(firstDay);
        updateSubmitState();
    }

    function updateFilename(date) {
        const month = new Intl.DateTimeFormat('id-ID', { month: 'long' }).format(date);
        document.getElementById('admin-export-filename').textContent = `Rekap_Presensi_${month}_${date.getFullYear()}.pdf`;
    }

    function updateCustomRange() {
        const startValue = document.getElementById('admin-export-start').value;
        const endValue = document.getElementById('admin-export-end').value;
        const startInput = document.getElementById('admin-export-start');
        const endInput = document.getElementById('admin-export-end');
        endInput.min = startValue;
        startInput.max = endValue;
        if (!startValue || !endValue || startValue > endValue) {
            dateSummary.textContent = 'Pilih rentang tanggal yang valid';
            updateSubmitState();
            return;
        }
        const formatter = new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric', timeZone: 'UTC' });
        const start = new Date(`${startValue}T00:00:00Z`);
        const end = new Date(`${endValue}T00:00:00Z`);
        const days = Array.from({ length: Math.floor((end - start) / 86400000) + 1 }, (_, index) => {
            const date = new Date(start.getTime() + index * 86400000);
            const weekday = date.getUTCDay();
            return weekday !== 0 && weekday !== 6 && !isFixedPublicHoliday(date);
        }).filter(Boolean).length;
        dateSummary.innerHTML = `${formatter.format(start)} - ${formatter.format(end)} <span>${days} Hari Kerja</span>`;
        updateFilename(start);
        updateSubmitState();
    }

    function updateSubmitState() {
        const mandatoryIncluded = componentChecks[0].checked;
        const period = periodButtons.find((button) => button.classList.contains('active')).dataset.exportPeriod;
        const validCustomRange = period !== 'custom'
            || (document.getElementById('admin-export-start').value
                && document.getElementById('admin-export-end').value
                && document.getElementById('admin-export-start').value <= document.getElementById('admin-export-end').value);
        submit.disabled = !mandatoryIncluded || !validCustomRange;
    }

    function isFixedPublicHoliday(date) {
        const fixedHolidays = new Set([
            '01-01', '05-01', '06-01', '08-17', '12-25',
        ]);
        const monthDay = `${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        return fixedHolidays.has(monthDay);
    }

    periodButtons.forEach((button) => button.addEventListener('click', () => setPeriod(button.dataset.exportPeriod)));
    componentChecks.forEach((checkbox) => checkbox.addEventListener('change', updateSubmitState));
    document.getElementById('admin-export-start').addEventListener('change', updateCustomRange);
    document.getElementById('admin-export-end').addEventListener('change', updateCustomRange);
    toggleAll.addEventListener('click', () => {
        const shouldCheck = componentChecks.some((checkbox) => !checkbox.checked);
        componentChecks.forEach((checkbox, index) => {
            if (index > 0) checkbox.checked = shouldCheck;
        });
        toggleAll.textContent = shouldCheck ? 'Hapus Pilihan' : 'Pilih Semua';
        updateSubmitState();
    });
    submit.addEventListener('click', () => {
        window.addEventListener('afterprint', closeModal, { once: true });
        window.print();
    });
    setPeriod('current');
})();
