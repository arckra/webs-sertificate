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
📦sertifikat-website
 ┣ 📂assets
 ┃ ┗ 📂images
 ┃ ┃ ┗ 📜logo-himatif.png
 ┣ 📂includes
 ┃ ┣ 📜config.php
 ┃ ┗ 📜functions.php
 ┣ 📂uploads
 ┃ ┣ 📜312410001.pdf
 ┃ ┣ 📜312410002.pdf
 ┃ ┗ 📜312410248.pdf
 ┣ 📜admin.js
 ┣ 📜admin.php
 ┣ 📜ajax_get_certificate.php
 ┣ 📜dashboard.php
 ┣ 📜index.php
 ┣ 📜logout.php
 ┣ 📜script.js
 ┗ 📜style.css         
```

🖥️ **Preview Tampilan**
---
💻 Halaman Awal

<img width="1120" height="654" alt="image" src="https://github.com/user-attachments/assets/48f36619-1a5e-496d-b5cb-38db58714582" />

---

🏠 Halaman Pengguna

<img width="1389" height="900" alt="image" src="https://github.com/user-attachments/assets/cc3bb7cb-ad56-448a-bb34-b96173bcdb72" />

Tampilan utama dengan form pencarian NIM

---

✅ **Halaman Hasil**

<img width="1436" height="864" alt="image" src="https://github.com/user-attachments/assets/470f4a07-c814-44fb-985b-f371f414cbc6" />

Tampilan hasil pencarian dengan detail sertifikat

---

🙍‍♂️ Halaman Login Admin

<img width="688" height="708" alt="image" src="https://github.com/user-attachments/assets/b3d26879-1fef-44db-94ce-034209960ece" />

---

👨‍💻 Halaman Dashboard Admin

<img width="1350" height="821" alt="image" src="https://github.com/user-attachments/assets/7d86e905-eff9-4393-b10a-216ee3a6aa48" />

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
2. **Upload PDF** - Upload file PDF ke folder `uploads/`
3. **Update Informasi** - Pastikan informasi mahasiswa sesuai

## Instalasi dan Setup

1. **Clone Repository** - Download semua file ke server web
2. **Setup Data** - Jalankan website untuk membuat tabel otomatis
3. **Upload PDF** - Upload file PDF ke folder `uploads/`
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
- Pastikan file PDF ada di folder `uploads/`
- Cek nama file sesuai dengan `[NIM].pdf`
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
