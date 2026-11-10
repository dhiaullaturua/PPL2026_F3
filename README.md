# PT Anaheim Nimbus Universal - Modul Kehadiran dan Kalender Kerja (Kelompok F3)

Reposan ini berisi kode sumber dan dokumentasi untuk **Modul Kehadiran dan Kalender Kerja** yang dikembangkan oleh **Kelompok F3** untuk kebutuhan asesmen perangkat lunak.

---

## 👥 Anggota Tim & Peran
* **Muhammad Dhiaulhaq T. Laturua** (233040171) – *Project Manager, Scrum Master & QA*
* **Nadhil Ikhwan A.W.** (233040039) – *UI/UX Designer*
* **Najran Al-Faresy** (233040084) – *Backend Developer*
* **Ilona Aqila Zahra** (233040127) – *System Analyst*
* **Dea Wardini** (233040003) – *Frontend Developer*

---

## 🛠️ Tech Stack & Lingkungan
* **Backend:** PHP 8.2+, Laravel Framework
* **Frontend:** PHP Blade Templating, Tailwind CSS, JavaScript
* **Database:** MySQL / PostgreSQL via Laragon (Windows)
* **Manajemen Tugas:** Jira Scrum Board (`PPL2026_F3`)

---

## 📂 Struktur Direktori Repositori
Repositori ini dikelola secara terstruktur ke dalam beberapa folder utama:
* `Analyst/` : Dokumentasi spesifikasi kebutuhan, diagram ERD, dan spesifikasi kontrak API (OpenAPI).
* `Designer/` : Aset rancangan antarmuka, *wireframe*, dan *mockup* UI/UX.
* `BE & FE/` : Kode sumber utama aplikasi berbasis Laravel (Backend & Frontend Blade).
* `resources/` : Berkas pendukung dan data *fixtures* (`f1_account.json`, `f2_employee.json`) untuk integrasi data mandiri.

---

## 🚀 Panduan Menjalankan Aplikasi (Lokal Laragon Windows)

Ikuti langkah-langkah di bawah ini untuk mengonfigurasi dan menjalankan aplikasi di komputer lokal Anda:

1. **Prasyarat:**
   * Pastikan aplikasi **Laragon** (versi Full) telah terinstal di komputer Windows Anda.
   * Aktifkan layanan **Apache/Nginx** dan **MySQL/PostgreSQL** pada panel kontrol Laragon.

2. **Kloning Repositori & Masuk ke Direktori Proyek:**
   ```bash
   git clone [https://github.com/dhiaullaturua/PPL2026_F3.git](https://github.com/dhiaullaturua/PPL2026_F3.git)
   cd PPL2026_F3/BE & FE

   berikut bukti dari Tampilan Mobilenya:

<img width="716" height="1280" alt="presensi" src="https://github.com/user-attachments/assets/3d153a17-cffa-4e52-9e30-0f375af67c85" />
<img width="712" height="1280" alt="rekapbulanan" src="https://github.com/user-attachments/assets/4a3672b6-1f00-4c93-97f1-d5e1c7973371" />
<img width="650" height="1155" alt="pengajuanlembur" src="https://github.com/user-attachments/assets/43401cb8-7236-49dc-bb80-8afedcd8c096" />
<img width="695" height="1270" alt="lemburditolak:gagal" src="https://github.com/user-attachments/assets/d3c2bd4a-82cb-4542-ae47-0639eab88add" />
