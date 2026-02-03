<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Ambil data acara untuk dropdown
$acara = getAcaraData($conn);

// Proses pencarian jika ada request
$results = [];
$search_performed = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search_performed = true;
    $nim = trim($_POST['nim']);
    $acara_id = $_POST['acara_id'] ?? 'all';
    
    if (!empty($nim) && preg_match('/^\d+$/', $nim) && strlen($nim) <= 10) {
        $results = searchCertificates($conn, $nim, $acara_id);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php if (!isset($_GET['mode'])): ?>
            <!-- Mode Selection Screen -->
            <div class="mode-selection">
                <div class="logo">
                    <img src="assets/images/logo-himatif.png" alt="Logo Sertifikat" class="logo-image">
                    <h1>Sertifikat Mahasiswa</h1>
                </div>
                
                <div class="mode-cards">
                    <a href="?mode=user" class="mode-card" id="user-mode">
                        <div class="mode-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3>Mode Pengguna</h3>
                        <p>Cari dan download sertifikat Anda dengan mudah menggunakan NIM</p>
                    </a>
                    
                    <a href="admin.php" class="mode-card" id="admin-mode">
                        <div class="mode-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3>Mode Admin</h3>
                        <p>Login untuk mengelola data sertifikat dan peserta</p>
                    </a>
                </div>
            </div>
        
        <?php elseif ($_GET['mode'] == 'user'): ?>
            <!-- User Search Screen -->
            <div class="user-screen">
                <header>
                    <div class="logo-header">
                        <img src="assets/images/logo-himatif.png" alt="Logo Sertifikat" class="logo-image">
                        <h1>CETAK SERTIFIKAT</h1>
                    </div>
                    <a href="index.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </header>

                <main>
                    <section class="hero">
                        <h2>Download sertifikat dengan mudah menggunakan NIM</h2>
                    </section>

                    <section class="search-section">
                        <h3><i class="fas fa-search"></i> Cari Sertifikat</h3>
                        <p>Masukkan NIM Anda untuk mencari sertifikat yang tersedia</p>

                        <form method="POST" action="?mode=user">
                            <div class="filter-section">
                                <div class="form-group">
                                    <label for="filter-acara"><i class="fas fa-filter"></i> Filter Berdasarkan Acara</label>
                                    <select id="filter-acara" name="acara_id" class="form-control">
                                        <option value="all">Semua Acara</option>
                                        <?php foreach ($acara as $a): ?>
                                            <option value="<?php echo $a['id']; ?>" 
                                                <?php echo (isset($_POST['acara_id']) && $_POST['acara_id'] == $a['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($a['nama_acara']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                                        
                            <div class="search-box">
                                <div class="form-group nim-search-row">
                                    <div class="nim-input-container">
                                        <label for="nim-input"><strong>Nomor Induk Mahasiswa (NIM)</strong></label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-id-card"></i>
                                            <input type="text" id="nim-input" name="nim" 
                                                   placeholder="Contoh: 312410248" maxlength="10"
                                                   value="<?php echo isset($_POST['nim']) ? htmlspecialchars($_POST['nim']) : ''; ?>">
                                        </div>
                                    </div>
                                        
                                    <div class="search-button-container">
                                        <button type="submit" name="search" class="btn-primary">
                                            <i class="fas fa-search"></i> Cari Sertifikat
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>

                    <?php if ($search_performed): ?>
                        <section class="results-section">
                            <h3><i class="fas fa-list"></i> Hasil Pencarian</h3>
                            <div id="results-container">
                                <?php if (!empty($results)): ?>
                                    <?php foreach ($results as $cert): ?>
                                        <div class="certificate-card">
                                            <div class="certificate-info">
                                                <h4><?php echo htmlspecialchars($cert['nama_peserta']); ?></h4>
                                                <div class="certificate-details">
                                                    <div class="detail-item">
                                                        <i class="fas fa-calendar-alt"></i>
                                                        <span><?php echo formatDate($cert['tanggal_pelaksana']); ?></span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-graduation-cap"></i>
                                                        <span><?php echo htmlspecialchars($cert['nim']); ?></span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-certificate"></i>
                                                        <span><?php echo htmlspecialchars($cert['nama_acara']); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="certificate-actions">
                                                <a href="<?php echo UPLOAD_PATH . $cert['nama_file']; ?>" 
                                                   target="_blank" class="btn-preview">
                                                    <i class="fas fa-eye"></i> Preview
                                                </a>
                                                <a href="<?php echo UPLOAD_PATH . $cert['nama_file']; ?>" 
                                                   download="Sertifikat_<?php echo $cert['nama_peserta']; ?>_<?php echo $cert['nama_file']; ?>" 
                                                   class="btn-download">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="no-data-message">
                                        <i class="fas fa-search"></i>
                                        <p>Tidak ditemukan sertifikat untuk NIM <?php echo htmlspecialchars($_POST['nim']); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </main>

                <footer>
                    <p>&copy; 2026 - Sistem Sertifikat Mahasiswa</p>
                </footer>
            </div>
        <?php endif; ?>
    </div>

    <!-- Preview Modal -->
    <div id="preview-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-eye"></i> Preview Sertifikat</h3>
                <span class="close-modal">&times;</span>
            </div>
            <div class="preview-content" id="preview-content">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>