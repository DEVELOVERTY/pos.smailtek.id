<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koneksi Kedit Error</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
        }
        .error-icon {
            font-size: 64px;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        .error-title {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        .error-message {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .instructions {
            background: #fff5f5;
            border-left: 4px solid #e74c3c;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
            border-radius: 5px;
        }
        .instructions h4 {
            margin: 0 0 10px 0;
            color: #c0392b;
        }
        .instructions ul {
            margin: 0;
            padding-left: 20px;
        }
        .instructions li {
            margin-bottom: 5px;
            color: #34495e;
        }
        .details {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 14px;
            text-align: left;
            max-height: 150px;
            overflow-y: auto;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 10px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #c0392b;
        }
        .btn-secondary {
            background: #95a5a6;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        .retry-btn {
            background: #f39c12;
        }
        .retry-btn:hover {
            background: #e67e22;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">🚫</div>
        <div class="error-title">Koneksi ke Sistem Kedit Gagal</div>
        <div class="error-message">{{ $error_message }}</div>
        
        <div class="instructions">
            <h4>Kemungkinan Penyebab:</h4>
            <ul>
                <li>Server Kedit sedang tidak aktif</li>
                <li>Masalah koneksi jaringan</li>
                <li>Token merchant tidak valid</li>
                <li>Endpoint API berubah</li>
            </ul>
        </div>

        <div class="instructions">
            <h4>Langkah Penyelesaian:</h4>
            <ul>
                <li>Pastikan server Kedit berjalan di <code>http://127.0.0.1:8000</code></li>
                <li>Periksa koneksi internet</li>
                <li>Hubungi administrator sistem</li>
                <li>Coba lagi dalam beberapa saat</li>
            </ul>
        </div>

        <div class="details">
            <strong>Detail Error:</strong><br>
            {{ $details }}<br><br>
            <strong>Transaction Info:</strong><br>
            Transaction Code: {{ $transaction_code }}<br>
            User ID: {{ $user_id }}<br>
            Store ID: {{ session('mystore') ?? 'Not Set' }}<br>
            Timestamp: {{ now()->format('Y-m-d H:i:s') }}
        </div>

        <div style="margin-top: 30px;">
            <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
            <a href="javascript:location.reload()" class="btn retry-btn">Coba Lagi</a>
            <a href="{{ route('pos.index') }}" class="btn">Ke Halaman Utama</a>
        </div>
    </div>

    <script>
        // Auto close setelah 45 detik
        setTimeout(function() {
            if (window.opener) {
                window.close();
            } else {
                window.location.href = '{{ route("pos.index") }}';
            }
        }, 45000);
    </script>
</body>
</html>
