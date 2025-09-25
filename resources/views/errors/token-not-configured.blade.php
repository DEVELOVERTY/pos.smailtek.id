<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token Tidak Dikonfigurasi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
            border-radius: 5px;
        }
        .instructions h4 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        .instructions ol {
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
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 10px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #2980b9;
        }
        .btn-secondary {
            background: #95a5a6;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">🔑</div>
        <div class="error-title">Token Toko Tidak Dikonfigurasi</div>
        <div class="error-message">{{ $error_message }}</div>
        
        <div class="instructions">
            <h4>Langkah untuk Mengatasi:</h4>
            <ol>
                <li>Hubungi administrator sistem</li>
                <li>Minta admin untuk masuk ke menu <strong>"Token Toko"</strong></li>
                <li>Set token 5 digit untuk toko ini</li>
                <li>Sinkronisasi token dengan sistem Kedit</li>
                <li>Coba transaksi kembali</li>
            </ol>
        </div>

        <div class="details">
            <strong>Detail Error:</strong><br>
            Transaction Code: {{ $transaction_code }}<br>
            User ID: {{ $user_id }}<br>
            Store ID: {{ session('mystore') ?? 'Not Set' }}<br>
            Timestamp: {{ now()->format('Y-m-d H:i:s') }}
        </div>

        <div style="margin-top: 30px;">
            <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('pos.index') }}" class="btn">Ke Halaman Utama</a>
        </div>
    </div>

    <script>
        // Auto close setelah 30 detik
        setTimeout(function() {
            if (window.opener) {
                window.close();
            } else {
                window.location.href = '{{ route("pos.index") }}';
            }
        }, 30000);
    </script>
</body>
</html>
