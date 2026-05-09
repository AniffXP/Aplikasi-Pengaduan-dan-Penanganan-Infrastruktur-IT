# Aplikasi Pengaduan dan Penanganan Infrastruktur IT

> Sistem pengaduan dan penanganan masalah infrastruktur IT berbasis web, dikembangkan saat **Program Magang (Kerja Praktik) di PT. Pupuk Sriwidjaja Palembang**.

---

## 📋 Tentang Aplikasi

Aplikasi ini dibangun untuk memudahkan proses pengaduan dan penanganan masalah infrastruktur IT di lingkungan PT. Pupuk Sriwidjaja Palembang. Setiap departemen dapat melaporkan kendala IT yang dialami, dan admin TI dapat memantau, memproses, serta menyelesaikan pengaduan secara terstruktur.

Aplikasi menggunakan **alur status bertahap**: `Baru → Proses → Validasi → Selesai`, sehingga setiap pengaduan dapat dipantau progress-nya secara real-time oleh kedua belah pihak.

## 🎯 Fitur Utama

1. **Dashboard Admin** — Ringkasan statistik: total departemen, masalah, pengaduan masuk/proses/validasi/selesai
2. **Dashboard User** — Statistik pengaduan milik departemen yang bersangkutan
3. **Manajemen Departemen** — Admin dapat menambah, mengedit, dan menghapus data departemen (user)
4. **Manajemen Masalah** — Admin mengelola daftar kategori/tracker masalah IT
5. **Pengaduan** — User membuat pengaduan baru dengan kategori, prioritas, deskripsi, dan upload bukti
6. **Validasi** — User dapat memvalidasi apakah pengaduan sudah benar-benar selesai ditangani
7. **Pencarian & Sorting** — Filter dan urutkan data berdasarkan kategori, status, atau tanggal

## 🖼️ Screenshot

### Dashboard Admin
![Dashboard Admin](screenshots/dashboard.png)

### Data Pengaduan
![Data Pengaduan](screenshots/data-pengaduan.png)

### Data Departemen
![Data Departemen](screenshots/data-departemen.png)

### Data Masalah
![Data Masalah](screenshots/data-masalah.png)

## 🛠️ Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Backend | PHP (Native) |
| Database | MySQL |
| Frontend | Bootstrap 5 |
| Icons | Font Awesome, Bootstrap Icons |
| Server | Laragon (Apache) |

## 🚀 Cara Instalasi

### Prasyarat
- [Laragon](https://laragon.org/) atau XAMPP (Apache + MySQL + PHP)
- PHP 7.4+
- MySQL 5.7+

### Langkah-langkah

1. **Clone repository**
   ```bash
   git clone https://github.com/AniffXP/Aplikasi-pengaduan-it.git
   ```

2. **Pindahkan ke folder web server**
   ```
   Laragon: C:\laragon\www\PengaduanIT\
   XAMPP:   C:\xampp\htdocs\PengaduanIT\
   ```

3. **Import database**
   - Buka phpMyAdmin (`http://localhost/phpmyadmin`)
   - Klik **Import** → pilih file `database/layanan_pengaduan.sql`
   - Atau jalankan via terminal:
     ```bash
     mysql -u root < database/layanan_pengaduan.sql
     ```

4. **Akses aplikasi**
   ```
   http://localhost/PengaduanIT/
   ```

### 🔐 Akun Login Default

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin` |
| User (Akuntansi) | `departemenakuntansi` | `user` |
| User (Hukum) | `departemenhukum` | `user` |
| User (Keuangan) | `departemenkeuangan` | `user` |
| User (Produksi) | `departemenproduksi` | `user` |
| User (Riset) | `departemenriset` | `user` |

## 📁 Struktur Folder

```
PengaduanIT/
├── aset/              # CSS custom
│   └── style.css
├── data departemen/   # CRUD departemen (admin)
├── data masalah/      # CRUD tracker masalah (admin)
├── data pengaduan/    # Kelola pengaduan (admin)
├── database/          # SQL dump
├── gambar/            # Logo & assets
├── login/             # Halaman login & logout
├── proses/            # Proses login
├── screenshots/       # Screenshot aplikasi
├── uploads/           # File bukti pengaduan
├── user/              # Halaman user (departemen)
├── index.php          # Dashboard admin
└── koneksi.php        # Konfigurasi database
```

## 📌 Alur Status Pengaduan

```
Baru → Proses → Validasi → Selesai
                    ↓
              (User validasi)
              ↙           ↘
     Selesai ✅     Kembali ke Proses 🔄
```

## ⚠️ Catatan

> **Aplikasi ini dikembangkan saat Program Magang (Kerja Praktik) di PT. Pupuk Sriwidjaja Palembang** sebagai solusi penanganan masalah infrastruktur IT internal perusahaan. Aplikasi ini dibuat untuk keperluan pembelajaran dan pengembangan skill selama masa magang.

---

Dibuat dengan ❤️ oleh **Abdur Hanif** — Program Magang PT. Pupuk Sriwidjaja Palembang
