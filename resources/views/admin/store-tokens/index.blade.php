@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/vendors/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<style>
    .badge-lg {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
    }
    .empty-state {
        padding: 2rem;
    }
    .empty-state i {
        display: block;
        margin: 0 auto 1rem;
    }
    .token-cell {
        min-width: 150px;
    }
    .store-info strong {
        color: #2c3e50;
    }
</style>
@endsection

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">Token Toko</h6>
                </div>
                <div class="col-md-4">
                    @if($currentStoreId && $stores->count() > 0)
                        <a class="btn btn-md btn-primary float-end" href="{{ route('admin.store-tokens.edit', $stores->first()->id) }}">
                            <i class="fa fa-edit"></i> Edit Token
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <x-admin.validation-component></x-admin.validation-component>
        
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">
                            @if($currentStoreId)
                                Token untuk: {{ $stores->first()->name ?? 'Toko Terpilih' }}
                            @else
                                Kelola Token Semua Toko
                            @endif
                        </h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if($currentStoreId)
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    Token untuk toko: <strong>{{ $stores->first()->name }}</strong>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>Nama Toko</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stores as $store)
                                        <tr>
                                            <td class="store-info">
                                                <strong>{{ $store->name }}</strong>
                                            </td>
                                            <td>
                                                @if($store->storeToken)
                                                    <a href="{{ route('admin.store-tokens.edit', $store->id) }}" 
                                                       class="btn btn-sm btn-primary"
                                                       title="Edit Token">
                                                        <i class="fas fa-edit"></i> Edit Token
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-store fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Tidak ada data toko</h5>
                                                    <p class="text-muted">Belum ada toko yang terdaftar dalam sistem</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $('#table-1').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian.json"
        }
    });
</script>
@endsection
