# Website Download Sertifikat Mahasiswa

🎯 **Tentang Proyek**
Sertifikat Web adalah platform sederhana dan elegan yang memungkinkan mahasiswa mendownload sertifikat mereka dengan mudah hanya menggunakan Nomor Induk Mahasiswa (NIM). Sistem ini dirancang dengan tampilan minimalist yang user-friendly dan fungsionalitas yang efisien.


✨ **Fitur Utama**
---
- 🔍 Pencarian Cepat - Temukan sertifikat hanya dengan NIM
- 📄 Preview Sertifikat - Lihat informasi sertifikat sebelum download
- ⬇️ Download Otomatis - Unduh sertifikat dengan satu klik
- 🎨 Desain Minimalist - Tampilan clean dengan palet warna biru tua dan abu terang
- 📱 Responsive Design - Optimal di semua perangkat
- 🔒 Validasi Input - Sistem validasi NIM otomatis
- ⚡ Tanpa Backend - Berjalan murni dengan HTML, CSS, dan JavaScript

📁 **Struktur Proyek**
---
```bash
sertifikat-web/
├── 📄 index.html              # Halaman utama
├── 📁 data/
│   └── 📄 certificates.json   # Database sertifikat
├── 📁 assets/
│   ├── 🖼️ logo.png       # Logo kustom
│   ├── 📁 css/
│   │   └── 🎨 style.css      # Stylesheet utama
│   └── 📁 pdf/
└── 📁 js/
    └── ⚙️ script.js           # JavaScript utama
```

🖥️ **Preview Tampilan**
---
🏠 Halaman Pencarian

<img width="1223" height="866" alt="Screenshot from 2026-01-26 22-40-31" src="https://github.com/user-attachments/assets/6f052447-8a94-47ff-8d68-917ce3f85af2" />

Tampilan utama dengan form pencarian NIM

---

✅ **Halaman Hasil**

<img width="1223" height="874" alt="Screenshot from 2026-01-26 22-42-20" src="https://github.com/user-attachments/assets/96ba3eab-7793-49fb-8f55-246024d45a92" />

Tampilan hasil pencarian dengan detail sertifikat

---

## Cara Penggunaan

### Bagi Mahasiswa:

1. **Akses Website** - Buka halaman utama website
2. **Masukkan NIM** - Ketikkan NIM Anda di kolom yang tersedia
3. **Klik Cari** - Tekan tombol "Cari Sertifikat" untuk mencari
4. **Preview Sertifikat** - Lihat informasi sertifikat yang muncul
5. **Download** - Klik tombol "Download Sertifikat" untuk mengunduh

### Bagi Admin:

1. **Tambah Data** - Tambahkan data sertifikat melalui API atau langsung ke tabel
2. **Upload PDF** - Upload file PDF ke folder `assets/pdf/`
3. **Update Informasi** - Pastikan informasi mahasiswa sesuai

## Struktur Data

### Tabel Sertifikat
```
- nim (text): Nomor Induk Mahasiswa
- nama (text): Nama lengkap mahasiswa
- program_studi (text): Program studi
- jenis_sertifikat (text): Jenis sertifikat
- tanggal_terbit (datetime): Tanggal penerbitan
- file_path (text): Path file PDF
```

## Endpoint API

- `GET /tables/sertifikat` - Mendapatkan daftar sertifikat
- `POST /tables/sertifikat` - Menambahkan data sertifikat baru
- `PUT /tables/sertifikat/{id}` - Update data sertifikat
- `DELETE /tables/sertifikat/{id}` - Menghapus data sertifikat

## Instalasi dan Setup

1. **Clone Repository** - Download semua file ke server web
2. **Setup Data** - Jalankan website untuk membuat tabel otomatis
3. **Upload PDF** - Upload file PDF ke folder `assets/pdf/`
4. **Tambah Data** - Tambahkan data mahasiswa ke tabel
5. **Deploy** - Deploy ke server web

## Warna Tema

- **Primary**: Biru tua (#1e3a5f, #2c5282)
- **Secondary**: Abu terang (#a0aec0, #cbd5e0)
- **Accent**: Biru cerah (#4299e1)
- **Success**: Hijau (#38a169)
- **Error**: Merah (#e53e3e)

## Fitur Keamanan

- Validasi input NIM (hanya alphanumeric)
- Penanganan error yang baik
- Tidak ada akses langsung ke file tanpa NIM yang valid
- Tidak ada data sensitif yang disimpan di frontend

## Troubleshooting

### File PDF Tidak Bisa Didownload
- Pastikan file PDF ada di folder `assets/pdf/`
- Cek nama file sesuai dengan `sertifikat_[NIM].pdf`
- Pastikan file memiliki izin baca yang benar

### Data Tidak Ditemukan
- Cek apakah data sudah ditambahkan ke tabel
- Pastikan NIM yang dicari sesuai dengan data
- Cek koneksi ke API

### Error Umum
- Refresh halaman dan coba lagi
- Clear browser cache
- Cek console log untuk detail error

## Browser Support

- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+

## Lisensi

Projek ini dibuat untuk keperluan pendidikan dan dapat dimodifikasi sesuai kebutuhan.

## Kontak

Untuk pertanyaan atau masalah teknis, hubungi administrator sistem.
