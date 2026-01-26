// Data sertifikat (bisa juga di-load dari JSON file)
let certificates = [];

// Load data dari JSON file
async function loadCertificates() {
    try {
        const response = await fetch('data/certificates.json');
        if (!response.ok) {
            throw new Error('Gagal load data sertifikat');
        }
        certificates = await response.json();
        console.log('Data sertifikat loaded:', certificates.length, 'records');
    } catch (error) {
        console.error('Error loading certificates:', error);
        // Fallback data jika file JSON tidak ada
        certificates = [
            {
                "nim": "312410248",
                "nama": "Ari Cakra Kurniawan",
                "filename": "312410248.pdf",
                "judul_sertifikat": "Seminar Web Development 2024"
            },
            {
                "nim": "312410224",
                "nama": "Vivi Alydia",
                "filename": "312410224.pdf",
                "judul_sertifikat": "Seminar Web Development 2024"
            },
            {
                "nim": "312410188",
                "nama": "Nadine Amelia Putri",
                "filename": "312410188.pdf",
                "judul_sertifikat": "Seminar Web Development 2024"
            }
        ];
    }
}

// DOM Elements
const nimInput = document.getElementById('nim');
const searchBtn = document.getElementById('searchBtn');
const resultSection = document.getElementById('resultSection');
const downloadBtn = document.getElementById('downloadBtn');
const backBtn = document.getElementById('backBtn');
const loading = document.getElementById('loading');
const errorMessage = document.getElementById('errorMessage');
const errorText = document.getElementById('errorText');
const statusMessage = document.getElementById('statusMessage');

// Result display elements
const resultNim = document.getElementById('resultNim');
const resultNama = document.getElementById('resultNama');
const resultJudul = document.getElementById('resultJudul');
const resultFile = document.getElementById('resultFile');

// Validasi input NIM
function validateNIM(nim) {
    // Hanya angka, panjang 1-10 digit
    const regex = /^\d{1,10}$/;
    return regex.test(nim);
}

// Cari sertifikat berdasarkan NIM
function findCertificateByNIM(nim) {
    return certificates.find(cert => cert.nim === nim);
}

// Tampilkan error
function showError(message) {
    errorText.textContent = message;
    errorMessage.style.display = 'flex';
    
    // Sembunyikan error setelah 5 detik
    setTimeout(() => {
        errorMessage.style.display = 'none';
    }, 5000);
}

// Tampilkan loading
function showLoading() {
    loading.style.display = 'block';
}

// Sembunyikan loading
function hideLoading() {
    loading.style.display = 'none';
}

// Tampilkan hasil pencarian
function showResult(certificate) {
    // Update UI dengan data sertifikat
    resultNim.textContent = certificate.nim;
    resultNama.textContent = certificate.nama;
    resultJudul.textContent = certificate.judul_sertifikat;
    resultFile.textContent = certificate.filename;
    
    // Sembunyikan search section, tampilkan result section
    document.querySelector('.search-section').style.display = 'none';
    resultSection.style.display = 'block';
    
    // Scroll ke result section
    resultSection.scrollIntoView({ behavior: 'smooth' });
}

// Kembali ke form pencarian
function backToSearch() {
    resultSection.style.display = 'none';
    document.querySelector('.search-section').style.display = 'block';
    nimInput.value = '';
    nimInput.focus();
    
    // Sembunyikan status message
    statusMessage.classList.remove('show');
}

// Download sertifikat
function downloadCertificate(certificate) {
    const fileUrl = `assets/pdf/${certificate.filename}`;
    
    // Tampilkan status
    statusMessage.textContent = `Mendownload ${certificate.filename}...`;
    statusMessage.classList.add('show');
    
    // Coba buka file PDF
    const link = document.createElement('a');
    link.href = fileUrl;
    link.download = certificate.filename;
    link.target = '_blank';
    
    // Simulasikan klik untuk download
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Update status setelah 2 detik
    setTimeout(() => {
        statusMessage.textContent = `✅ Download berhasil: ${certificate.filename}`;
    }, 2000);
}

// Event Listeners
searchBtn.addEventListener('click', async () => {
    const nim = nimInput.value.trim();
    
    // Validasi input
    if (!nim) {
        showError('Silakan masukkan NIM');
        nimInput.focus();
        return;
    }
    
    if (!validateNIM(nim)) {
        showError('NIM hanya boleh berisi angka (maksimal 10 digit)');
        nimInput.focus();
        nimInput.select();
        return;
    }
    
    // Sembunyikan error jika ada
    errorMessage.style.display = 'none';
    
    // Tampilkan loading
    showLoading();
    
    // Simulasikan loading (bisa dihapus jika tidak perlu)
    await new Promise(resolve => setTimeout(resolve, 500));
    
    // Cari sertifikat
    const certificate = findCertificateByNIM(nim);
    
    // Sembunyikan loading
    hideLoading();
    
    if (certificate) {
        // Tampilkan hasil
        showResult(certificate);
    } else {
        showError(`Sertifikat dengan NIM ${nim} tidak ditemukan`);
        nimInput.focus();
        nimInput.select();
    }
});

// Enter key untuk search
nimInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        searchBtn.click();
    }
});

// Download button
downloadBtn.addEventListener('click', () => {
    const nim = resultNim.textContent;
    const certificate = findCertificateByNIM(nim);
    
    if (certificate) {
        downloadCertificate(certificate);
    } else {
        showError('Gagal mendownload sertifikat');
    }
});

// Back button
backBtn.addEventListener('click', backToSearch);

// Validasi real-time input
nimInput.addEventListener('input', (e) => {
    // Hanya izinkan angka
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
    
    // Batasi panjang
    if (e.target.value.length > 10) {
        e.target.value = e.target.value.substring(0, 10);
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    // Load data sertifikat
    loadCertificates();
    
    // Fokus ke input NIM
    nimInput.focus();
    
    // Test: Log jumlah sertifikat yang loaded
    setTimeout(() => {
        console.log(`Sistem siap. ${certificates.length} sertifikat tersedia.`);
    }, 1000);
});

// Fitur tambahan: Drag & Drop PDF (opsional)
function setupDragAndDrop() {
    const dropZone = document.querySelector('.search-card');
    
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#339af0';
    });
    
    dropZone.addEventListener('dragleave', () => {
        dropZone.style.borderColor = 'rgba(255, 255, 255, 0.1)';
    });
    
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = 'rgba(255, 255, 255, 0.1)';
        
        // Handle dropped files (jika mau tambah fitur upload)
        console.log('File dropped');
    });
}

// Panggil setup drag & drop jika diperlukan
// setupDragAndDrop();