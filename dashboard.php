<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin.php');
    exit();
}

// Ambil data acara
$acara = getAcaraData($conn);

// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_certificate'])) {
        $nim = trim($_POST['nim']);
        $nama = trim($_POST['nama']);
        $acara_id = $_POST['acara_id'];
        $tanggal = $_POST['tanggal'];
        
        // Handle file upload
        if (isset($_FILES['sertifikat']) && $_FILES['sertifikat']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['sertifikat']['tmp_name'];
            $fileName = time() . '_' . basename($_FILES['sertifikat']['name']);
            $destPath = UPLOAD_PATH . $fileName;
            
            // Pindahkan file ke folder uploads
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Simpan ke database
                $sql = "INSERT INTO sertifikat (nim, nama_peserta, id_acara, tanggal_pelaksana, nama_file) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssiss", $nim, $nama, $acara_id, $tanggal, $fileName);
                
                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "Data berhasil ditambahkan";
                } else {
                    $error_message = "Gagal menyimpan data ke database";
                }
                
                mysqli_stmt_close($stmt);
            } else {
                $error_message = "Gagal mengupload file";
            }
        } else {
            $error_message = "Silakan pilih file sertifikat";
        }
    }
    
    // Proses edit data
    if (isset($_POST['edit_certificate'])) {
        $id = $_POST['id'];
        $nim = trim($_POST['nim']);
        $nama = trim($_POST['nama']);
        $acara_id = $_POST['acara_id'];
        $tanggal = $_POST['tanggal'];
        
        $sql = "UPDATE sertifikat SET nim = ?, nama_peserta = ?, id_acara = ?, tanggal_pelaksana = ? 
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssisi", $nim, $nama, $acara_id, $tanggal, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Data berhasil diperbarui";
        } else {
            $error_message = "Gagal memperbarui data";
        }
        
        mysqli_stmt_close($stmt);
    }
    
    // Proses hapus data
    if (isset($_POST['delete_certificate'])) {
        $id = $_POST['id'];
        
        // Ambil nama file untuk dihapus
        $sql = "SELECT nama_file FROM sertifikat WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $fileName = $row['nama_file'];
            deleteCertificateFile($fileName);
        }
        
        mysqli_stmt_close($stmt);
        
        // Hapus dari database
        $sql = "DELETE FROM sertifikat WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Data berhasil dihapus";
        } else {
            $error_message = "Gagal menghapus data";
        }
        
        mysqli_stmt_close($stmt);
    }
}

// Ambil filter dari URL
$filter_acara = $_GET['acara'] ?? 'all';
$search_term = $_GET['search'] ?? '';

// Ambil data sertifikat
$certificates = getAllCertificates($conn, $filter_acara, $search_term);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sertifikat Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-left">
                <div class="logo-header">
                    <i class="fas fa-certificate"></i>
                    <h1>Dashboard Admin</h1>
                </div>
            </div>
            <div class="header-right">
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </header>

        <?php if (isset($success_message)): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Filter dan Search -->
        <section class="admin-controls">
            <div class="filter-section">
                <form method="GET" action="" class="filter-form">
                    <div class="form-group">
                        <label for="admin-filter-acara"><i class="fas fa-filter"></i> Filter Acara</label>
                        <select id="admin-filter-acara" name="acara" class="form-control" onchange="this.form.submit()">
                            <option value="all" <?php echo $filter_acara == 'all' ? 'selected' : ''; ?>>Semua Acara</option>
                            <?php foreach ($acara as $a): ?>
                                <option value="<?php echo $a['id']; ?>" 
                                    <?php echo $filter_acara == $a['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($a['nama_acara']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
                
                <form method="GET" action="" class="search-form">
                    <div class="search-box-admin">
                        <div class="input-with-icon">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" placeholder="Cari berdasarkan NIM atau nama..." 
                                   value="<?php echo htmlspecialchars($search_term); ?>">
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <?php if ($filter_acara != 'all' || !empty($search_term)): ?>
                            <a href="dashboard.php" class="btn-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </section>

        <!-- Tabel Data -->
        <section class="data-section">
            <div class="section-header">
                <h3><i class="fas fa-database"></i> Data Sertifikat</h3>
                <button id="add-data-btn" class="btn-success" onclick="showAddModal()">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            </div>
            
            <div class="table-container">
                <table id="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Peserta</th>
                            <th>Acara</th>
                            <th>Tanggal Pelaksana</th>
                            <th>Sertifikat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($certificates)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($certificates as $cert): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($cert['nim']); ?></td>
                                    <td><?php echo htmlspecialchars($cert['nama_peserta']); ?></td>
                                    <td><?php echo htmlspecialchars($cert['nama_acara']); ?></td>
                                    <td><?php echo formatDate($cert['tanggal_pelaksana']); ?></td>
                                    <td>
                                        <a href="<?php echo UPLOAD_PATH . $cert['nama_file']; ?>" 
                                           target="_blank" class="btn-preview">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-edit edit-btn" 
                                                    onclick="showEditModal(<?php echo $cert['id']; ?>)">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form method="POST" action="" style="display: inline;" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat <?php echo addslashes($cert['nama_peserta']); ?>?')">
                                                <input type="hidden" name="id" value="<?php echo $cert['id']; ?>">
                                                <button type="submit" name="delete_certificate" class="btn-delete">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">
                                    <div class="no-data-message">
                                        <i class="fas fa-database"></i>
                                        <p>Tidak ada data sertifikat</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Modal Tambah Data -->
        <div id="add-modal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="fas fa-plus"></i> Tambah Data Sertifikat</h3>
                    <span class="close-modal" onclick="closeAddModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="add-nim">NIM Peserta</label>
                            <input type="text" id="add-nim" name="nim" required maxlength="10">
                        </div>
                        
                        <div class="form-group">
                            <label for="add-nama">Nama Peserta</label>
                            <input type="text" id="add-nama" name="nama" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="add-acara">Acara</label>
                            <select id="add-acara" name="acara_id" required>
                                <option value="">Pilih Acara</option>
                                <?php foreach ($acara as $a): ?>
                                    <option value="<?php echo $a['id']; ?>">
                                        <?php echo htmlspecialchars($a['nama_acara']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="add-tanggal">Tanggal Pelaksana</label>
                            <input type="date" id="add-tanggal" name="tanggal" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="add-sertifikat">Upload Sertifikat (PDF/Image)</label>
                            <input type="file" id="add-sertifikat" name="sertifikat" 
                                   accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="closeAddModal()">Batal</button>
                            <button type="submit" name="add_certificate" class="btn-success">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <div id="edit-modal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i class="fas fa-edit"></i> Edit Data Sertifikat</h3>
                    <span class="close-modal" onclick="closeEditModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="edit-form">
                        <input type="hidden" id="edit-id" name="id">
                        
                        <div class="form-group">
                            <label for="edit-nim">NIM Peserta</label>
                            <input type="text" id="edit-nim" name="nim" required maxlength="10">
                        </div>
                        
                        <div class="form-group">
                            <label for="edit-nama">Nama Peserta</label>
                            <input type="text" id="edit-nama" name="nama" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit-acara">Acara</label>
                            <select id="edit-acara" name="acara_id" required>
                                <?php foreach ($acara as $a): ?>
                                    <option value="<?php echo $a['id']; ?>">
                                        <?php echo htmlspecialchars($a['nama_acara']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit-tanggal">Tanggal Pelaksana</label>
                            <input type="date" id="edit-tanggal" name="tanggal" required>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="closeEditModal()">Batal</button>
                            <button type="submit" name="edit_certificate" class="btn-success">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function showAddModal() {
            document.getElementById('add-modal').style.display = 'flex';
        }
        
        function closeAddModal() {
            document.getElementById('add-modal').style.display = 'none';
            document.getElementById('add-modal').querySelector('form').reset();
        }
        
        function showEditModal(id) {
            // Fetch certificate data via AJAX
            fetch('ajax_get_certificate.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const cert = data.certificate;
                        
                        // Populate form
                        document.getElementById('edit-id').value = cert.id;
                        document.getElementById('edit-nim').value = cert.nim;
                        document.getElementById('edit-nama').value = cert.nama_peserta;
                        document.getElementById('edit-acara').value = cert.id_acara;
                        document.getElementById('edit-tanggal').value = cert.tanggal_pelaksana;
                        
                        // Show modal
                        document.getElementById('edit-modal').style.display = 'flex';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data');
                });
        }
        
        function closeEditModal() {
            document.getElementById('edit-modal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        }
        
        // Auto-hide success/error messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.success-message, .error-message');
            messages.forEach(msg => {
                msg.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>