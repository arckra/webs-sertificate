<?php
require_once 'config.php';

function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function getAcaraData($conn) {
    $sql = "SELECT * FROM acara ORDER BY nama_acara";
    $result = mysqli_query($conn, $sql);
    $acara = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $acara[] = $row;
        }
    }
    
    return $acara;
}

function searchCertificates($conn, $nim, $acara_id = 'all') {
    $sql = "SELECT s.*, a.nama_acara FROM sertifikat s 
            JOIN acara a ON s.id_acara = a.id 
            WHERE s.nim = ?";
    
    $params = [$nim];
    
    if ($acara_id !== 'all') {
        $sql .= " AND s.id_acara = ?";
        $params[] = $acara_id;
    }
    
    $sql .= " ORDER BY s.tanggal_pelaksana DESC";
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        if (count($params) > 1) {
            mysqli_stmt_bind_param($stmt, "si", $nim, $acara_id);
        } else {
            mysqli_stmt_bind_param($stmt, "s", $nim);
        }
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $certificates = [];
        
        while ($row = mysqli_fetch_assoc($result)) {
            $certificates[] = $row;
        }
        
        mysqli_stmt_close($stmt);
        return $certificates;
    }
    
    return [];
}

function getAllCertificates($conn, $acara_id = 'all', $search = '') {
    $sql = "SELECT s.*, a.nama_acara FROM sertifikat s 
            JOIN acara a ON s.id_acara = a.id 
            WHERE 1=1";
    
    $params = [];
    $types = "";
    
    if ($acara_id !== 'all') {
        $sql .= " AND s.id_acara = ?";
        $params[] = $acara_id;
        $types .= "i";
    }
    
    if (!empty($search)) {
        $sql .= " AND (s.nim LIKE ? OR s.nama_peserta LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= "ss";
    }
    
    $sql .= " ORDER BY s.created_at DESC";
    
    if (!empty($params)) {
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $certificates = [];
            
            while ($row = mysqli_fetch_assoc($result)) {
                $certificates[] = $row;
            }
            
            mysqli_stmt_close($stmt);
            return $certificates;
        }
    } else {
        $result = mysqli_query($conn, $sql);
        $certificates = [];
        
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $certificates[] = $row;
            }
        }
        
        return $certificates;
    }
    
    return [];
}

function getCertificateById($conn, $id) {
    $sql = "SELECT s.*, a.nama_acara FROM sertifikat s 
            JOIN acara a ON s.id_acara = a.id 
            WHERE s.id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        return $row;
    }
    
    mysqli_stmt_close($stmt);
    return null;
}

function deleteCertificateFile($fileName) {
    $filePath = UPLOAD_PATH . $fileName;
    if (file_exists($filePath)) {
        unlink($filePath);
        return true;
    }
    return false;
}

function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('d/m/Y');
}
?>