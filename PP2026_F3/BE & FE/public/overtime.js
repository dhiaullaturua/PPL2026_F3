(() => {
    const storageKey = 'attendance-overtime-requests';
    const requestList = document.getElementById('overtime-list');
    const modal = document.getElementById('overtime-modal');
    const form = document.getElementById('overtime-form');
    const startTime = document.getElementById('overtime-start');
    const endTime = document.getElementById('overtime-end');
    const duration = document.getElementById('overtime-duration');
    const recordsCount = document.getElementById('overtime-count');
    const emptyMessage = document.getElementById('overtime-empty');
    const toast = document.getElementById('overtime-toast');
    let activeFilter = 'all';
    let toastTimeout;

    function populateTimeOptions(select, selectedTime) {
        for (let minutes = 0; minutes < 24 * 60; minutes += 30) {
            const hour = String(Math.floor(minutes / 60)).padStart(2, '0');
            const minute = String(minutes % 60).padStart(2, '0');
            const value = `${hour}:${minute}`;
            const option = document.createElement('option');
            option.value = value;
            option.textContent = `${hour}.${minute} WIB`;
            select.append(option);
        }
        select.value = selectedTime;
    }

    populateTimeOptions(startTime, '17:30');
    populateTimeOptions(endTime, '21:00');

    const seedRequests = [
        {
            id: 'sample-overtime-1',
            title: 'Lembur abcde',
            day: 'Jumat',
            date: '2026-10-23',
            start: '18:00',
            end: '21:30',
            duration: '3.5',
            status: 'approved',
            approver: 'Disetujui oleh Hendra Gunawan (Manager IT)',
            rate: 'Rate 1.5x',
        },
        {
            id: 'sample-overtime-2',
            title: 'Lembur abcde',
            day: 'Rabu',
            date: '2026-10-21',
            start: '17:30',
            end: '20:00',
            duration: '2.5',
            status: 'rejected',
            rejection: 'Melebihi kuota lembur mingguan divisi & tanpa approval SPK awal.',
        },
        {
            id: 'sample-overtime-3',
            title: 'Lembur abcde',
            day: 'Minggu',
            date: '2026-10-18',
            start: '19:00',
            end: '22:00',
            duration: '3.0',
            status: 'approved',
            approver: 'Disetujui oleh HR Operations',
            rate: 'Rate 2.0x (Shift Malam)',
        },
    ];

    function loadRequests() {
        try {
            const savedRequests = localStorage.getItem(storageKey);
            if (savedRequests === null) return seedRequests.slice();
            const parsedRequests = JSON.parse(savedRequests);
            const isValid = Array.isArray(parsedRequests) && parsedRequests.every((request) =>
                request !== null
                && typeof request === 'object'
                && typeof request.title === 'string'
                && typeof request.date === 'string'
                && typeof request.start === 'string'
                && typeof request.end === 'string'
                && ['approved', 'rejected', 'pending'].includes(request.status)
                && Number.isFinite(Number(request.duration)),
            );
            if (!isValid) throw new TypeError('Format pengajuan lembur tersimpan tidak valid.');
            return parsedRequests;
        } catch (error) {
            console.error('Tidak dapat membaca data pengajuan lembur dari penyimpanan browser.', error);
            return seedRequests.slice();
        }
    }

    let requests = loadRequests();

    function saveRequests() {
        try {
            localStorage.setItem(storageKey, JSON.stringify(requests));
            return true;
        } catch (error) {
            console.error('Tidak dapat menyimpan pengajuan lembur ke penyimpanan browser.', error);
            showToast('Pengajuan gagal disimpan di perangkat ini.');
            return false;
        }
    }

    function formatRequestDate(value) {
        const [year, month, day] = value.split('-').map(Number);
        return new Intl.DateTimeFormat('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric',
            timeZone: 'UTC',
        }).format(new Date(Date.UTC(year, month - 1, day)));
    }

    function weekdayFor(value) {
        const [year, month, day] = value.split('-').map(Number);
        return new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            timeZone: 'UTC',
        }).format(new Date(Date.UTC(year, month - 1, day)));
    }

    function escapeHtml(value) {
        const element = document.createElement('span');
        element.textContent = value;
        return element.innerHTML;
    }

    function titleFromReason(reason) {
        const firstLine = reason.trim().split(/\r?\n/, 1)[0];
        const firstSentence = firstLine.split(/[.!?;]/, 1)[0].trim();
        const title = firstSentence || firstLine;
        if (title.length <= 42) return `Lembur: ${title}`;

        const shortened = title.slice(0, 42);
        const lastSpace = shortened.lastIndexOf(' ');
        return `Lembur: ${shortened.slice(0, lastSpace > 0 ? lastSpace : 42).trimEnd()}…`;
    }

    function cardMarkup(request) {
        const isRejected = request.status === 'rejected';
        const isPending = request.status === 'pending';
        const statusLabel = isRejected ? 'Tidak Disetujui' : isPending ? 'Menunggu Persetujuan' : 'Disetujui';
        const hours = Number(request.duration);
        const date = formatRequestDate(request.date);
        const day = request.day || weekdayFor(request.date);
        const safeTitle = escapeHtml(request.reason ? titleFromReason(request.reason) : request.title);
        const approver = request.approver ? escapeHtml(request.approver) : '';
        const rate = request.rate ? escapeHtml(request.rate) : '';
        const rejection = request.rejection ? escapeHtml(request.rejection) : '';

        return `
            <article class="overtime-card" data-status="${request.status}">
                <div class="overtime-card-heading">
                    <h2>${safeTitle}</h2>
                    <span class="overtime-status ${request.status}">${statusLabel}</span>
                </div>
                <div class="overtime-meta"><span class="overtime-meta-icon">◷</span><span>${escapeHtml(day)}, ${date} • ${escapeHtml(request.start)} - ${escapeHtml(request.end)} WIB (${hours.toFixed(1)} Jam)</span></div>
                ${isRejected
                    ? `<p class="overtime-rejection"><strong>Alasan Penolakan:</strong> ${rejection}</p>`
                    : `<div class="overtime-card-footer"><span class="overtime-approver">${approver || 'Pengajuan sedang ditinjau oleh atasan'}</span>${rate ? `<span class="overtime-rate">${rate}</span>` : ''}</div>`}
            </article>
        `;
    }

    function renderRequests() {
        recordsCount.textContent = `${requests.length} Pengajuan`;
        requestList.innerHTML = requests.map(cardMarkup).join('');

        let visibleCount = 0;
        requestList.querySelectorAll('.overtime-card').forEach((card) => {
            const matches = activeFilter === 'all' || card.dataset.status === activeFilter;
            card.hidden = !matches;
            if (matches) visibleCount += 1;
        });
        emptyMessage.hidden = visibleCount !== 0;

        document.querySelectorAll('.overtime-filter').forEach((button) => {
            button.classList.toggle('active', button.dataset.filter === activeFilter);
            const count = activeFilterCount(button.dataset.filter);
            button.textContent = `${button.dataset.label} (${count})`;
        });
    }

    function activeFilterCount(filter) {
        return filter === 'all' ? requests.length : requests.filter((request) => request.status === filter).length;
    }

    function showToast(message) {
        toast.textContent = message;
        toast.hidden = false;
        window.clearTimeout(toastTimeout);
        toastTimeout = window.setTimeout(() => {
            toast.hidden = true;
        }, 3000);
    }

    function updateDuration() {
        if (!startTime.value || !endTime.value) {
            duration.textContent = 'Durasi: 0 Jam';
            return;
        }

        const [startHour, startMinute] = startTime.value.split(':').map(Number);
        const [endHour, endMinute] = endTime.value.split(':').map(Number);
        let minutes = endHour * 60 + endMinute - (startHour * 60 + startMinute);
        if (minutes <= 0) minutes += 24 * 60;
        duration.textContent = `Durasi: ${(minutes / 60).toFixed(1)} Jam`;
    }

    function openModal() {
        modal.hidden = false;
        document.body.classList.add('overtime-modal-open');
        document.getElementById('overtime-day').focus();
    }

    function closeModal() {
        modal.hidden = true;
        document.body.classList.remove('overtime-modal-open');
    }

    document.querySelectorAll('.overtime-filter').forEach((button) => {
        button.addEventListener('click', () => {
            activeFilter = button.dataset.filter;
            renderRequests();
        });
    });
    document.getElementById('overtime-open-form').addEventListener('click', openModal);
    document.querySelectorAll('[data-overtime-close]').forEach((button) => button.addEventListener('click', closeModal));
    modal.addEventListener('click', (event) => {
        if (event.target === modal) closeModal();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.hidden) closeModal();
    });
    startTime.addEventListener('change', updateDuration);
    endTime.addEventListener('change', updateDuration);
    document.getElementById('overtime-date').addEventListener('change', (event) => {
        document.getElementById('overtime-day').value = weekdayFor(event.target.value);
    });
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const date = document.getElementById('overtime-date').value;
        const start = startTime.value;
        const end = endTime.value;
        const reason = document.getElementById('overtime-reason').value.trim();

        if (!date || !start || !end || !reason) {
            form.reportValidity();
            return;
        }

        const [startHour, startMinute] = start.split(':').map(Number);
        const [endHour, endMinute] = end.split(':').map(Number);
        let minutes = endHour * 60 + endMinute - (startHour * 60 + startMinute);
        if (minutes === 0) {
            showToast('Jam selesai harus berbeda dengan jam mulai.');
            return;
        }
        if (minutes < 0) minutes += 24 * 60;

        requests.unshift({
            id: `overtime-${Date.now()}`,
            title: titleFromReason(reason),
            day: weekdayFor(date),
            date,
            start,
            end,
            duration: (minutes / 60).toFixed(1),
            status: 'pending',
            reason,
        });
        if (!saveRequests()) {
            requests.shift();
            renderRequests();
            return;
        }
        activeFilter = 'all';
        renderRequests();
        form.reset();
        startTime.value = '17:30';
        endTime.value = '21:00';
        updateDuration();
        closeModal();
        showToast('Permohonan lembur berhasil dikirim.');
    });

    document.getElementById('overtime-date').value = new Intl.DateTimeFormat('en-CA', {
        timeZone: 'Asia/Jakarta',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
    }).format(new Date());
    document.getElementById('overtime-day').value = weekdayFor(document.getElementById('overtime-date').value);
    updateDuration();
    renderRequests();
})();
