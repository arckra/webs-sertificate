<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $certificate = getCertificateById($conn, $id);
    
    if ($certificate) {
        echo json_encode([
            'success' => true, 
            'certificate' => [
                'id' => $certificate['id'],
                'nim' => $certificate['nim'],
                'nama_peserta' => $certificate['nama_peserta'],
                'id_acara' => $certificate['id_acara'],
                'tanggal_pelaksana' => $certificate['tanggal_pelaksana']
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Certificate not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No ID specified']);
}
?>