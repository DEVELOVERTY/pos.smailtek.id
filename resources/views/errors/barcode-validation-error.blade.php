<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Validasi Barcode</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <style>
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .error-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 90%;
        }
        .error-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
        .error-title {
            color: #333;
            margin-bottom: 1rem;
        }
        .error-message {
            color: #666;
            margin-bottom: 1.5rem;
        }
        .btn-retry {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-retry:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card text-center">
            <i class="fas fa-exclamation-triangle error-icon"></i>
            <h2 class="error-title">Error Validasi Barcode</h2>
            <p class="error-message">
                {{ $error_message ?? 'Terjadi kesalahan saat memvalidasi barcode' }}
            </p>
            
            @if(isset($details))
            <div class="alert alert-info text-start">
                <strong>Detail Error:</strong><br>
                {{ $details }}
            </div>
            @endif
            
            @if(isset($instructions))
            <div class="alert alert-warning text-start">
                <strong>Instruksi:</strong><br>
                {{ $instructions }}
            </div>
            @endif
            
            <div class="mt-3">
                <button class="btn btn-retry" onclick="window.close()">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke POS
                </button>
            </div>
            
            @if(isset($transaction_code))
            <div class="mt-3">
                <small class="text-muted">
                    Transaction Code: {{ $transaction_code }}<br>
                    @if(isset($user_id))
                    User ID: {{ $user_id }}
                    @endif
                </small>
            </div>
            @endif
        </div>
    </div>
    
    <script>
        // Auto close after 10 seconds
        setTimeout(function() {
            window.close();
        }, 10000);
    </script>
</body>
</html>
