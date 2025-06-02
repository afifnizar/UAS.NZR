<?php
include 'koneksi.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize data from form
    $id = mysqli_real_escape_string($koneksi, trim($_POST['id']));
    $nama_kegiatan = mysqli_real_escape_string($koneksi, trim($_POST['nama_kegiatan'])); 
    $waktu_kegiatan = mysqli_real_escape_string($koneksi, trim($_POST['waktu_kegiatan']));
    
    // Input validation
    if (empty($id) || empty($nama_kegiatan) || empty($waktu_kegiatan)) {
        $error = "Semua field harus diisi!";
    } else {
        // Check if ID already exists using the correct column name
        $cek_query = "SELECT id FROM kegiatan WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $cek_query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                $error = "ID '$id' sudah terdaftar! Silakan gunakan ID yang berbeda.";
            } else {
                // Insert new data - make sure column names match your database
                $insert_query = "INSERT INTO kegiatan (id, nama_kgt, waktu_kgt) VALUES (?, ?, ?)";
                $insert_stmt = mysqli_prepare($koneksi, $insert_query);
                
                if ($insert_stmt) {
                    mysqli_stmt_bind_param($insert_stmt, "sss", $id, $nama_kegiatan, $waktu_kegiatan);
                    
                    if (mysqli_stmt_execute($insert_stmt)) {
                        // Success - redirect to index.php
                        mysqli_stmt_close($insert_stmt);
                        mysqli_stmt_close($stmt);
                        mysqli_close($koneksi);
                        header("Location: index.php?status=sukses&pesan=" . urlencode("Data berhasil ditambahkan"));
                        exit();
                    } else {
                        $error = "Gagal menyimpan data: " . mysqli_error($koneksi);
                    }
                    mysqli_stmt_close($insert_stmt);
                } else {
                    $error = "Error preparing insert statement: " . mysqli_error($koneksi);
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Error preparing check statement: " . mysqli_error($koneksi);
        }
    }
}

// Preserve form data if there's an error
$form_id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';
$form_nama_kegiatan = isset($_POST['nama_kegiatan']) ? htmlspecialchars($_POST['nama_kegiatan']) : '';
$form_waktu_kegiatan = isset($_POST['waktu_kegiatan']) ? htmlspecialchars($_POST['waktu_kegiatan']) : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kegiatan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 650px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="text"],
        textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        
        textarea {
            resize: vertical;
            height: 120px;
            font-family: inherit;
            line-height: 1.5;
        }
        
        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 35px;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
        }
        
        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        
        .alert-info {
            background-color: #cce7ff;
            border: 1px solid #b3d7ff;
            color: #004085;
        }
        
        .required {
            color: #dc3545;
        }
        
        .form-info {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            color: #004085;
        }
        
        .char-count {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            font-weight: 500;
        }
        
        .input-help {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 25px;
            }
            
            .header h2 {
                font-size: 24px;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
        
        /* Loading animation */
        .btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }
        
        .btn.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>➕ Tambah Data Kegiatan</h2>
            <p class="subtitle">Tambahkan kegiatan mahasiswa baru ke dalam database</p>
        </div>
        
        <div class="form-info alert-info">
            <div>
                <strong>ℹ️ Informasi Penting:</strong><br>
                • Pastikan ID unik dan tidak sama dengan data yang sudah ada<br>
                • Semua field yang bertanda (*) wajib diisi<br>
                • Data akan disimpan ke database setelah validasi berhasil
            </div>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <span>❌</span>
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <span>✅</span>
                <strong>Sukses:</strong> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" id="tambahForm">
            <div class="form-group">
                <label for="id">🆔 ID Kegiatan <span class="required">*</span></label>
                <input type="text" 
                       id="id" 
                       name="id" 
                       value="<?php echo $form_id; ?>" 
                       required
                       placeholder="Contoh: KGT001, SEMINAR2024, dll."
                       maxlength="20"
                       pattern="[A-Za-z0-9_-]+"
                       title="ID hanya boleh mengandung huruf, angka, underscore, dan dash">
                <div class="input-help">
                    ID harus unik dan tidak boleh sama dengan yang sudah ada (max 20 karakter)
                </div>
            </div>
            
            <div class="form-group">
                <label for="nama_kegiatan">📝 Nama Kegiatan <span class="required">*</span></label>
                <input type="text" 
                       id="nama_kegiatan" 
                       name="nama_kegiatan" 
                       value="<?php echo $form_nama_kegiatan; ?>" 
                       required
                       placeholder="Contoh: Seminar Teknologi Informasi 2024"
                       maxlength="255">
                <div class="input-help">
                    Nama lengkap kegiatan (max 255 karakter)
                </div>
            </div>
            
            <div class="form-group">
                <label for="waktu_kegiatan">⏰ Waktu Kegiatan <span class="required">*</span></label>
                <textarea id="waktu_kegiatan" 
                          name="waktu_kegiatan" 
                          required
                          placeholder="Contoh:&#10;Hari: Senin, 15 Januari 2024&#10;Waktu: 08:00 - 12:00 WIB&#10;Tempat: Aula Utama Kampus"
                          maxlength="500"><?php echo $form_waktu_kegiatan; ?></textarea>
                <div class="char-count">
                    <span id="charCount">0</span>/500 karakter
                </div>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    💾 Simpan Data
                </button>
                <a href="index.php" class="btn btn-secondary">
                    ↩️ Kembali ke Beranda
                </a>
            </div>
        </form>
    </div>

    <script>
        // Auto focus on first field
        document.getElementById('id').focus();
        
        // Character count for textarea
        const textarea = document.getElementById('waktu_kegiatan');
        const charCount = document.getElementById('charCount');
        
        function updateCharCount() {
            const count = textarea.value.length;
            charCount.textContent = count;
            
            if (count > 450) {
                charCount.style.color = '#dc3545';
                charCount.style.fontWeight = 'bold';
            } else if (count > 400) {
                charCount.style.color = '#ffc107';
                charCount.style.fontWeight = '600';
            } else {
                charCount.style.color = '#28a745';
                charCount.style.fontWeight = '500';
            }
        }
        
        textarea.addEventListener('input', updateCharCount);
        updateCharCount(); // Initial count
        
        // Form validation and submission
        document.getElementById('tambahForm').addEventListener('submit', function(e) {
            const id = document.getElementById('id').value.trim();
            const nama_kegiatan = document.getElementById('nama_kegiatan').value.trim();
            const waktu_kegiatan = document.getElementById('waktu_kegiatan').value.trim();
            const submitBtn = document.getElementById('submitBtn');
            
            // Validation
            if (!id || !nama_kegiatan || !waktu_kegiatan) {
                e.preventDefault();
                alert('⚠️ Semua field wajib diisi!');
                return false;
            }
            
            // ID format validation
            const idPattern = /^[A-Za-z0-9_-]+$/;
            if (!idPattern.test(id)) {
                e.preventDefault();
                alert('⚠️ ID hanya boleh mengandung huruf, angka, underscore (_), dan dash (-)!');
                document.getElementById('id').focus();
                return false;
            }
            
            // Confirmation
            if (!confirm(`✅ Konfirmasi Penyimpanan Data\n\nID: ${id}\nKegiatan: ${nama_kegiatan.substring(0, 50)}${nama_kegiatan.length > 50 ? '...' : ''}\n\nApakah Anda yakin ingin menyimpan data ini?`)) {
                e.preventDefault();
                return false;
            }
            
            // Add loading state
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = '⏳ Menyimpan...';
            submitBtn.disabled = true;
        });
        
        // Auto-trim whitespace on blur
        document.querySelectorAll('input[type="text"], textarea').forEach(function(element) {
            element.addEventListener('blur', function() {
                this.value = this.value.trim();
                if (this.id === 'waktu_kegiatan') {
                    updateCharCount();
                }
            });
        });
        
        // Input formatting for ID
        document.getElementById('id').addEventListener('input', function() {
            // Remove invalid characters as user types
            this.value = this.value.replace(/[^A-Za-z0-9_-]/g, '');
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (!alert.classList.contains('alert-info')) {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.style.display = 'none', 500);
                }
            });
        }, 5000);
    </script>
</body>
</html>