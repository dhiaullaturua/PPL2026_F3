(() => {
  const holidayStorageKey = "attendance-admin-holidays";
  const scheduleStorageKey = "attendance-admin-work-schedule";
  const overtimeStorageKey = "attendance-admin-overtime-status";
  const lateStorageKey = "attendance-late-requests";
  const overtimeRequestStorageKey = "attendance-overtime-requests";
  const page = document.body.dataset.adminPage;

  function readStoredArray(key) {
    try {
      const value = JSON.parse(localStorage.getItem(key) || "[]");
      if (Array.isArray(value)) return value;
      console.error(`Expected ${key} in local storage to contain an array.`);
      return [];
    } catch (error) {
      console.error(`Could not read ${key} from local storage.`, error);
      return [];
    }
  }

  function readStoredObject(key) {
    try {
      const value = JSON.parse(localStorage.getItem(key) || "{}");
      if (value && typeof value === "object" && !Array.isArray(value)) return value;
      console.error(`Expected ${key} in local storage to contain an object.`);
      return {};
    } catch (error) {
      console.error(`Could not read ${key} from local storage.`, error);
      return {};
    }
  }

  function escapeHtml(value) {
    return String(value).replace(
      /[&<>"']/g,
      (character) =>
        ({
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          '"': "&quot;",
          "'": "&#39;",
        })[character],
    );
  }

  function renderSubmittedOvertimeRequests() {
    if (page !== "overtime") return;
    const list = document.getElementById("admin-overtime-list");
    if (!list) return;
    const savedRequests = readStoredArray(overtimeRequestStorageKey);
    const dynamicCards = savedRequests
      .filter((request) => request && request.status && request.date && request.start && request.end)
      .map(
        (request) => `
                <article class="admin-overtime-card" data-request-id="${escapeHtml(request.id || `overtime-${Date.now()}`)}" data-status="${escapeHtml(request.status || "pending")}">
                    <div class="admin-card-heading">
                        <input class="admin-card-check" type="checkbox" aria-label="Pilih pengajuan ${escapeHtml(request.employee || "Karyawan")}">
                        <span class="admin-person-photo" aria-hidden="true">${escapeHtml(
                          (request.employee || "KR")
                            .split(" ")
                            .map((part) => part[0])
                            .slice(0, 2)
                            .join("")
                            .toUpperCase(),
                        )}</span>
                        <div class="admin-person-name">${escapeHtml(request.employee || "Karyawan")}<span class="admin-person-role">${escapeHtml(request.role || "Karyawan")}</span><span class="admin-overtime-type">◷ SPL Lembur · ${escapeHtml(request.reason || "Pengajuan Lembur")}</span></div>
                    </div>
                    <div class="admin-job-details">
                        <div class="admin-job-date"><span>▣ ${escapeHtml(request.day || request.date)}</span><span class="admin-hours">${escapeHtml(request.duration || "0.0")} Jam</span></div>
                        <div class="admin-job-time"><span>◷ ${escapeHtml(request.start)} - ${escapeHtml(request.end)} WIB　(${escapeHtml(request.rate || "Kompensasi sesuai kebijakan")})</span></div>
                        <p class="admin-task">Tugas: “${escapeHtml(request.reason || "Pengajuan lembur dari karyawan")}”</p>
                    </div>
                    <div class="admin-supervisor"><span>Supervisor: <strong>${escapeHtml(request.supervisor || "Menunggu verifikasi atasan")}</strong></span><span class="admin-verified">◉ ${escapeHtml(request.status === "approved" ? "Disetujui" : request.status === "rejected" ? "Ditolak" : "Menunggu Persetujuan")}</span></div>
                    <div class="admin-card-actions">
                        <button class="admin-reject-button" type="button">Tolak Lembur</button>
                        <button class="admin-approve-button" type="button">✓ Setujui Lembur</button>
                    </div>
                </article>
            `,
      )
      .join("");

    if (dynamicCards) {
      list.insertAdjacentHTML("beforeend", dynamicCards);
    }
  }

  function renderSubmittedLateReasons() {
    if (page !== "lateness") return;
    const list = document.querySelector(".admin-lateness-list");
    if (!list) return;
    const submitted = readStoredArray(lateStorageKey);
    const dynamicCards = submitted
      .filter((entry) => entry && entry.reason && entry.dateKey)
      .map(
        (entry) => `
                <article class="admin-lateness-card" data-reason="other" data-decision-id="${escapeHtml(entry.id || `late-${Date.now()}`)}">
                    <div class="admin-lateness-person"><span class="admin-face face-warm">${escapeHtml(
                      (entry.employee || "KR")
                        .split(" ")
                        .map((part) => part[0])
                        .slice(0, 2)
                        .join("")
                        .toUpperCase(),
                    )}</span><div><h3>${escapeHtml(entry.employee || "Karyawan")}</h3><p>${escapeHtml(entry.role || "Karyawan")}</p></div><strong class="admin-delay">◴ +${escapeHtml(entry.delayMinutes || 18)} Menit</strong></div>
                    <div class="admin-reason-meta"><span>▣ Jadwal: 08:30 WIB</span><strong>▦ Presensi: ${escapeHtml(entry.dateKey.replace(/-/g, "/"))} WIB</strong><p><b>Alasan Dari Karyawan</b>　 Via Pengajuan Presensi</p></div>
                    <small class="admin-reason-label">ALASAN KARYAWAN:</small><blockquote>"${escapeHtml(entry.reason)}"</blockquote>
                    <div class="admin-lateness-actions"><button class="admin-late-reject" type="button">× Catat Terlambat</button><button class="admin-late-accept" type="button">✓ Beri Toleransi</button></div>
                </article>
            `,
      )
      .join("");

    if (dynamicCards) {
      list.insertAdjacentHTML("beforeend", dynamicCards);
    }
  }

  if (page === "overtime") {
    const tabs = Array.from(document.querySelectorAll(".admin-tab"));
    let cards = Array.from(document.querySelectorAll(".admin-overtime-card"));
    const selectAll = document.getElementById("admin-select-all");
    const selectedCount = document.getElementById("admin-selected-count");
    const approveSelected = document.getElementById("admin-approve-selected");
    const emptyMessage = document.getElementById("admin-overtime-empty");
    const notice = document.getElementById("admin-overtime-notice");
    const validStatuses = new Set(["pending", "approved", "rejected"]);
    const statusOverrides = new Map();
    Object.entries(readStoredObject(overtimeStorageKey)).forEach(([requestId, status]) => {
      if (typeof requestId === "string" && validStatuses.has(status)) {
        statusOverrides.set(requestId, status);
      } else {
        console.error(`Ignoring invalid status override for ${requestId}.`);
      }
    });
    let activeStatus = "pending";

    function statusFor(card) {
      return statusOverrides.get(card.dataset.requestId) || card.dataset.status;
    }

    function updateCounts() {
      const totals = { pending: 14, approved: 8, rejected: 2 };
      cards.forEach((card) => {
        const originalStatus = card.dataset.status;
        const currentStatus = statusFor(card);
        if (originalStatus !== currentStatus) {
          totals[originalStatus] = Math.max(0, totals[originalStatus] - 1);
          totals[currentStatus] += 1;
        }
      });

      tabs.forEach((tab) => {
        tab.querySelector(".admin-tab-count").textContent = String(totals[tab.dataset.status]);
      });
    }

    function saveStatuses() {
      localStorage.setItem(overtimeStorageKey, JSON.stringify(Object.fromEntries(statusOverrides)));
      updateCounts();
    }

    function updateSelection() {
      const visibleCards = cards.filter((card) => statusFor(card) === activeStatus);
      const selectedCards = visibleCards.filter((card) => card.querySelector(".admin-card-check").checked);
      selectedCount.textContent = `${selectedCards.length} dipilih`;
      selectAll.checked = visibleCards.length > 0 && selectedCards.length === visibleCards.length;
      selectAll.indeterminate = selectedCards.length > 0 && selectedCards.length < visibleCards.length;
      approveSelected.disabled = selectedCards.length === 0;
    }

    function renderCards() {
      let visibleCount = 0;
      cards.forEach((card) => {
        const visible = statusFor(card) === activeStatus;
        card.hidden = !visible;
        card.querySelector(".admin-card-check").checked = false;
        visibleCount += Number(visible);
      });
      emptyMessage.hidden = visibleCount > 0;
      selectAll.checked = false;
      selectAll.indeterminate = false;
      updateSelection();
      updateCounts();
    }

    function setSelectedStatus(nextStatus) {
      const chosen = cards.filter((card) => statusFor(card) === activeStatus && card.querySelector(".admin-card-check").checked);
      chosen.forEach((card) => {
        statusOverrides.set(card.dataset.requestId, nextStatus);
      });
      saveStatuses();
      renderCards();
      notice.textContent = `${chosen.length} pengajuan ${nextStatus === "approved" ? "disetujui" : "ditolak"}.`;
    }

    tabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        activeStatus = tab.dataset.status;
        tabs.forEach((item) => item.classList.toggle("active", item === tab));
        renderCards();
      });
    });

    selectAll.addEventListener("change", () => {
      cards.forEach((card) => {
        if (statusFor(card) === activeStatus) {
          card.querySelector(".admin-card-check").checked = selectAll.checked;
        }
      });
      updateSelection();
    });

    cards.forEach((card) => {
      card.querySelector(".admin-card-check").addEventListener("change", updateSelection);
      card.querySelector(".admin-approve-button").addEventListener("click", () => {
        statusOverrides.set(card.dataset.requestId, "approved");
        saveStatuses();
        renderCards();
      });
      card.querySelector(".admin-reject-button").addEventListener("click", () => {
        statusOverrides.set(card.dataset.requestId, "rejected");
        saveStatuses();
        renderCards();
      });
    });

    approveSelected.addEventListener("click", () => setSelectedStatus("approved"));
    renderSubmittedOvertimeRequests();
    cards = Array.from(document.querySelectorAll(".admin-overtime-card"));
    renderCards();
  }

  if (page === "lateness") {
    renderSubmittedLateReasons();
  }

  if (page === "calendar") {
    const scheduleForm = document.getElementById("admin-work-schedule-form");
    const scheduleInputs = {
      workStart: document.getElementById("admin-work-start"),
      workEnd: document.getElementById("admin-work-end"),
      breakStart: document.getElementById("admin-break-start"),
      breakEnd: document.getElementById("admin-break-end"),
    };
    const form = document.getElementById("admin-holiday-form");
    const dateInput = document.getElementById("admin-holiday-date");
    const nameInput = document.getElementById("admin-holiday-name");
    const roleInput = document.getElementById("admin-creator-role");
    const list = document.getElementById("admin-holiday-list");
    const empty = document.getElementById("admin-holiday-empty");
    const notice = document.getElementById("admin-calendar-notice");
    let holidays = readStoredArray(holidayStorageKey);

    function readSchedule() {
      const defaults = { workStart: "07:00", workEnd: "17:00", breakStart: "12:00", breakEnd: "13:00" };
      try {
        const saved = JSON.parse(localStorage.getItem(scheduleStorageKey) || "null");
        if (!saved || typeof saved !== "object") return defaults;
        return Object.fromEntries(
          Object.entries(defaults).map(([key, fallback]) => [
            key,
            typeof saved[key] === "string" && /^\d{2}:\d{2}$/.test(saved[key]) ? saved[key] : fallback,
          ]),
        );
      } catch (error) {
        console.error(`Could not read ${scheduleStorageKey} from local storage.`, error);
        return defaults;
      }
    }

    Object.entries(readSchedule()).forEach(([key, value]) => {
      scheduleInputs[key].value = value;
    });

    scheduleForm.addEventListener("submit", (event) => {
      event.preventDefault();
      const schedule = Object.fromEntries(
        Object.entries(scheduleInputs).map(([key, input]) => [key, input.value]),
      );
      if (
        !schedule.workStart ||
        !schedule.workEnd ||
        !schedule.breakStart ||
        !schedule.breakEnd ||
        !(schedule.workStart < schedule.breakStart &&
          schedule.breakStart < schedule.breakEnd &&
          schedule.breakEnd < schedule.workEnd)
      ) {
        notice.textContent = "Jadwal tidak valid. Pastikan jam masuk < mulai istirahat < selesai istirahat < selesai kerja.";
        notice.setAttribute("role", "alert");
        return;
      }

      localStorage.setItem(scheduleStorageKey, JSON.stringify(schedule));
      notice.setAttribute("role", "status");
      notice.textContent = "Jadwal kerja berhasil disimpan dan tampil di kalender karyawan pada perangkat ini.";
    });

    function renderHolidays() {
      const storedCount = holidays.length;
      holidays = holidays.filter((holiday) => holiday && typeof holiday.id === "string" && typeof holiday.date === "string" && typeof holiday.name === "string" && typeof holiday.createdBy === "string");
      if (holidays.length < storedCount) {
        console.error("Ignoring malformed holiday entries from local storage.");
      }
      holidays.sort((left, right) => left.date.localeCompare(right.date));
      list.innerHTML = holidays
        .map(
          (holiday) => `
                <article class="admin-holiday-item">
                    <span><strong>${escapeHtml(holiday.name)}</strong><small>${escapeHtml(holiday.date)} · Diinput oleh ${escapeHtml(holiday.createdBy)}</small></span>
                    <button class="admin-delete-button" type="button" data-holiday-id="${escapeHtml(holiday.id)}">Hapus</button>
                </article>
            `,
        )
        .join("");
      empty.hidden = holidays.length > 0;
    }

    function escapeHtml(value) {
      return String(value).replace(
        /[&<>"']/g,
        (character) =>
          ({
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#39;",
          })[character],
      );
    }

    form.addEventListener("submit", (event) => {
      event.preventDefault();
      const date = dateInput.value;
      const name = nameInput.value.trim();
      if (!date || !name) {
        form.reportValidity();
        return;
      }

      const existing = holidays.find((holiday) => holiday.date === date);
      if (existing) {
        existing.name = name;
        existing.createdBy = roleInput.value;
      } else {
        holidays.push({
          id: `${date}-${Date.now()}`,
          date,
          name,
          createdBy: roleInput.value,
        });
      }

      localStorage.setItem(holidayStorageKey, JSON.stringify(holidays));
      nameInput.value = "";
      notice.textContent = "Hari libur disimpan dan akan ditampilkan di kalender karyawan pada perangkat ini.";
      renderHolidays();
    });

    list.addEventListener("click", (event) => {
      const button = event.target.closest("[data-holiday-id]");
      if (!button) return;
      holidays = holidays.filter((holiday) => holiday.id !== button.dataset.holidayId);
      localStorage.setItem(holidayStorageKey, JSON.stringify(holidays));
      notice.textContent = "Hari libur dihapus dari kalender bersama pada perangkat ini.";
      renderHolidays();
    });

    renderHolidays();
  }
})();
