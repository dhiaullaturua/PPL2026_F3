(() => {
    const readStorageKey = 'attendance-read-notifications';
    const bookmarkStorageKey = 'attendance-bookmarked-announcements';
    const announcementId = 'hr-schedule';
    const bookmarkButton = document.getElementById('announcement-bookmark');
    const acknowledgeButton = document.getElementById('announcement-acknowledge');
    const feedback = document.getElementById('announcement-feedback');

    function readList(key) {
        const storedValue = localStorage.getItem(key);
        if (storedValue === null) return [];
        const value = JSON.parse(storedValue);
        if (!Array.isArray(value) || !value.every((entry) => typeof entry === 'string')) {
            throw new TypeError(`Format penyimpanan ${key} tidak valid.`);
        }
        return value;
    }

    function showFeedback(message) {
        feedback.textContent = message;
        feedback.hidden = false;
    }

    function updateBookmarkButton(isBookmarked) {
        bookmarkButton.setAttribute('aria-pressed', String(isBookmarked));
        bookmarkButton.setAttribute('aria-label', isBookmarked ? 'Hapus dari pengumuman tersimpan' : 'Simpan pengumuman');
        bookmarkButton.textContent = isBookmarked ? '▣' : '♧';
    }

    function updateAcknowledgeButton(isRead) {
        acknowledgeButton.setAttribute('aria-pressed', String(isRead));
        acknowledgeButton.textContent = isRead
            ? '✓ Sudah Dibaca & Dipahami'
            : '✓ Saya Sudah Membaca & Memahami';
    }

    let bookmarkedAnnouncements;
    try {
        bookmarkedAnnouncements = new Set(readList(bookmarkStorageKey));
        updateBookmarkButton(bookmarkedAnnouncements.has(announcementId));
    } catch (error) {
        console.error('Tidak dapat membaca pengumuman tersimpan.', error);
        bookmarkButton.disabled = true;
        showFeedback('Status simpan pengumuman tidak dapat dibaca dari penyimpanan browser.');
    }

    try {
        updateAcknowledgeButton(readList(readStorageKey).includes(announcementId));
    } catch (error) {
        console.error('Tidak dapat membaca status pengumuman.', error);
        showFeedback('Status baca pengumuman tidak dapat dibaca dari penyimpanan browser.');
    }

    bookmarkButton.addEventListener('click', () => {
        if (!bookmarkedAnnouncements) return;
        const updatedBookmarks = new Set(bookmarkedAnnouncements);
        if (updatedBookmarks.has(announcementId)) updatedBookmarks.delete(announcementId);
        else updatedBookmarks.add(announcementId);
        try {
            localStorage.setItem(bookmarkStorageKey, JSON.stringify(Array.from(updatedBookmarks)));
            bookmarkedAnnouncements = updatedBookmarks;
            updateBookmarkButton(updatedBookmarks.has(announcementId));
            showFeedback(updatedBookmarks.has(announcementId)
                ? 'Pengumuman disimpan.'
                : 'Pengumuman dihapus dari daftar tersimpan.');
        } catch (error) {
            console.error('Tidak dapat menyimpan status pengumuman.', error);
            showFeedback('Perubahan status simpan gagal disimpan.');
        }
    });

    document.getElementById('announcement-share').addEventListener('click', async () => {
        const shareData = {
            title: 'Detail Pengumuman - SE/HRD/2026/X/084',
            text: 'Penyesuaian batas verifikasi jadwal kerja, presensi, dan pengajuan lembur akhir bulan Oktober 2026.',
            url: window.location.href,
        };
        try {
            if (navigator.share) await navigator.share(shareData);
            else if (navigator.clipboard) {
                await navigator.clipboard.writeText(shareData.url);
                showFeedback('Tautan pengumuman berhasil disalin.');
            } else {
                showFeedback('Fitur berbagi tidak tersedia pada browser ini.');
            }
        } catch (error) {
            if (error.name === 'AbortError') return;
            console.error('Tidak dapat membagikan pengumuman.', error);
            showFeedback('Pengumuman tidak dapat dibagikan. Silakan coba lagi.');
        }
    });

    acknowledgeButton.addEventListener('click', () => {
        try {
            const readAnnouncements = new Set(readList(readStorageKey));
            readAnnouncements.add(announcementId);
            localStorage.setItem(readStorageKey, JSON.stringify(Array.from(readAnnouncements)));
            updateAcknowledgeButton(true);
            showFeedback('Terima kasih. Pengumuman ditandai sudah dibaca.');
        } catch (error) {
            console.error('Tidak dapat menandai pengumuman sebagai sudah dibaca.', error);
            showFeedback('Status baca gagal disimpan. Silakan coba lagi.');
        }
    });

    document.getElementById('announcement-download').addEventListener('click', () => {
        window.print();
    });
})();
