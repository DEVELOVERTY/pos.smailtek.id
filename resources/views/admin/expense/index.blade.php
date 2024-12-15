@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/vendors/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can("Tambah Kategori Pengeluaran")
                    <a class="btn btn-md btn-primary float-end" href="{{route('exca.create')}}"><i class="fa fa-list"></i> {{__('sidebar.add_category')}}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
 
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card ">
                        <div class="card-header header-modal">
                            <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th style="width:70px;text-align: center;">
                                                    <span class="fa fa-image"></span>
                                                </th>
                                                <th>{{ __('produk.name') }}</th>
                                                <th>{{ __('category.total_subcategory') }}</th>
                                                <th width="110px">
                                                    <span class="fa fa-cogs"></span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $c)
                                            <tr class="data-product">
                                                <td style="width:70px;">
                                                    <a href="javascript:void(0)" data-lity=""><img width="50px" src="{{ asset($c->image) }}"></a>
                                                </td>
                                                <td> {{ $c->name }} </td>
                                                <td> <a href=" @if(Auth()->user()->can(" Daftar Subkategori Pengeluaran")) {{route("exsub.byCat",$c->id)}} @else # @endif" class="btn btn-sm btn-primary"><i class="fa fa-cube"></i> {{ count($c->children) }}</a> </td>
                                                <td>
                                                    @can("Update Kategori Pengeluaran")
                                                    <a href="{{ route('exca.update',$c->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                    @endcan
                                                    @can("Hapus Kategori Pengeluaran")
                                                    <a href="{{ route('exca.delete',$c->id) }}" class="btn btn-sm btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                                                    @endcan
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    @section('scripts')
    <script src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/vendors/datatables/datatables.js')}}"></script>
    @endsection
    @endsection