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
                    @can("Tambah Users")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('user.create') }}"><i class="fa fa-plus"></i> {{__('user.add_user')}}</a>
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
                                            <th class="text-center"> No </th>
                                            <th>{{__('user.name')}}</th>
                                            <th>{{__('general.email')}}</th>
                                            <th>{{__('sidebar.role')}}</th>
                                            <th>{{__('general.image')}}</th>
                                            <th>{{__('general.store')}}</th>
                                            <th>{{__('general.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach($data as $d)
                                        <tr>
                                            <td>{{$no++}} </td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ $d->email }}</td>
                                            <td>{{ $d->getRoleNames() ?? '' }}</td>
                                            <td>
                                                <img src="{{ asset($d->photo ?? 'uploads/image.jpg') }}" style="width: 50px">
                                            </td>
                                            <td>{{ $d->store->name ?? __('user.all_store') }}</td>
                                            <td>
                                                <a href="{{ route('user.update',$d->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                @if($d->id != Auth()->user()->id)
                                                <a href="{{route('user.delete',$d->id)}}" class="btn btn-sm btn-danger deletebutton"><i class="fas fa-trash"></i></a>
                                                @endif
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
    </div>
</div>

@section('scripts')
<script src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/vendors/datatables/datatables.js')}}"></script>
@endsection
@endsection