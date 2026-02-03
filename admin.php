<?php
session_start();
require_once 'includes/config.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $nim = trim($_POST['nim']);
    
    if (!empty($nim)) {
        $sql = "SELECT * FROM admin WHERE nim = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $nim);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_nim'] = $nim;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'NIM admin tidak valid';
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $error = 'Silakan masukkan NIM admin';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sertifikat Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* PERBAIKAN LAYOUT KOTAK FORM */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .login-header {
            padding: 40px 30px 30px;
            text-align: center;
            color: white;
        }
        
        .login-header i {
            font-size: 50px;
            margin-bottom: 20px;
        }
        
        .login-header h1 {
            font-size: 26px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .login-header p {
            font-size: 15px;
            opacity: 0.9;
        }
        
        .login-form {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-group input:focus {
            border-color: #667eea;
            background: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-primary {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #142b6f 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: #fff5f5;
            color: #e53e3e;
            padding: 14px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 14px;
            border-left: 4px solid #e53e3e;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .back-link {
            margin-top: 25px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
        }
        
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .back-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        /* Responsive adjustments */
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            
            .login-container {
                border-radius: 12px;
            }
            
            .login-header {
                padding: 30px 20px 25px;
            }
            
            .login-form {
                padding: 25px 20px;
            }
            
            .form-group input,
            .btn-primary {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <i class="fas fa-user-shield"></i>
                <h1>Login Admin</h1>
                <p>Masukkan NIM admin untuk mengakses dashboard</p>
            </div>
            
            <form method="POST" action="">
                <div class="login-form">
                    <div class="form-group">
                        <label for="admin-nim"><i class="fas fa-id-card"></i> NIM Admin</label>
                        <input type="text" id="admin-nim" name="nim" placeholder="Masukkan NIM admin" required>
                    </div>
                    
                    <button type="submit" name="login" class="btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                    
                    <?php if ($error): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="back-link">
                        <a href="index.php">
                            <i class="fas fa-arrow-left"></i> Kembali ke halaman utama
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>