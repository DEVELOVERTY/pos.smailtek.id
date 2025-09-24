@extends('layouts.admin')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">Edit Token - {{ $store->name }}</h6>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('admin.store-tokens.index') }}" class="btn btn-md btn-secondary float-end">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        
        <x-admin.validation-component></x-admin.validation-component>
        
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">Edit Token Toko</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('admin.store-tokens.update', $store->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Nama Toko</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" value="{{ $store->name }}" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="token">Token Toko <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" 
                                                       class="form-control @error('token') is-invalid @enderror" 
                                                       id="token"
                                                       name="token" 
                                                       value="{{ old('token', $storeToken->token ?? '') }}"
                                                       placeholder="Masukkan token (contoh: 54321)"
                                                       maxlength="20"
                                                       required>
                                                <button type="button" class="btn btn-info" id="generateToken">
                                                    <i class="fa fa-random"></i>
                                                </button>
                                            </div>
                                            @error('token')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        <i class="fa fa-save"></i> Simpan Token
                                    </button>
                                    <a href="{{ route('admin.store-tokens.index') }}" class="btn btn-light-secondary me-1 mb-1">
                                        <i class="fa fa-times"></i> Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
/* Popup Alert Styles */
.popup-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
    max-width: 400px;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateX(100%);
    transition: all 0.3s ease-in-out;
    opacity: 0;
}

.popup-alert.show {
    transform: translateX(0);
    opacity: 1;
}

.popup-alert.success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.popup-alert.error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.popup-alert .popup-icon {
    display: inline-block;
    margin-right: 10px;
    font-size: 18px;
}

.popup-alert .popup-close {
    position: absolute;
    top: 10px;
    right: 15px;
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    color: inherit;
    opacity: 0.7;
}

.popup-alert .popup-close:hover {
    opacity: 1;
}

.popup-alert .popup-message {
    margin: 0;
    font-weight: 500;
}
</style>

<script>
// Function to show success popup
function showSuccessPopup(message) {
    showPopup(message, 'success');
}

// Function to show error popup
function showErrorPopup(message) {
    showPopup(message, 'error');
}

// Generic popup function
function showPopup(message, type) {
    // Remove existing popups
    const existingPopups = document.querySelectorAll('.popup-alert');
    existingPopups.forEach(popup => popup.remove());
    
    // Create popup element
    const popup = document.createElement('div');
    popup.className = `popup-alert ${type}`;
    
    const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
    
    popup.innerHTML = `
        <span class="popup-icon"><i class="${icon}"></i></span>
        <span class="popup-message">${message}</span>
        <button class="popup-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Add to body
    document.body.appendChild(popup);
    
    // Show popup with animation
    setTimeout(() => {
        popup.classList.add('show');
    }, 10);
    
    // Auto hide after 4 seconds
    setTimeout(() => {
        if (popup.parentElement) {
            popup.classList.remove('show');
            setTimeout(() => {
                if (popup.parentElement) {
                    popup.remove();
                }
            }, 300);
        }
    }, 4000);
}

document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generateToken');
    const tokenInput = document.getElementById('token');
    
    if (generateBtn && tokenInput) {
        console.log('Generate token button found and event listener attached');
        generateBtn.addEventListener('click', function() {
            console.log('Generate token button clicked');
            // Disable button sementara
            generateBtn.disabled = true;
            generateBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            
            fetch('{{ route("admin.store-tokens.generate") }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.token) {
                    tokenInput.value = data.token;
                    // Show success popup
                    showSuccessPopup(data.message || 'Token berhasil di-generate!');
                } else {
                    throw new Error(data.message || 'Token tidak ditemukan dalam response');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorPopup('Gagal generate token: ' + error.message);
            })
            .finally(() => {
                // Re-enable button
                generateBtn.disabled = false;
                generateBtn.innerHTML = '<i class="fa fa-random"></i>';
            });
        });
    } else {
        console.error('Generate button atau token input tidak ditemukan');
    }
});
</script>
@endsection
