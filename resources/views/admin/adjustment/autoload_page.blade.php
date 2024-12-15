<div class="table-responsive">

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{__('general.date')}}</th>
                <th>{{__('general.ref_no')}}</th>
                <th>{{__('general.type')}}</th>
                <th>{{__('adjustment.amount_total')}}</th>
                <th>{{__('adjustment.amount_recovered')}}</th>
                <th>{{__('general.action')}}</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $d)
            <tr>
                <td> {{ $d->created_at }}</td>
                <td> {{ $d->ref_no }} </td>
                <td> <span class=" badge bg-primary text-white">{{ $d->adjustment_type }}</span> </td>
                <td> {{ number_format($d->final_total) }} </td>
                <td> {{ number_format($d->total_amount_recovered) }} </td>
                <td>
                    @can("Detail Adjustment")
                    <a class="btn btn-sm btn-success" href="{{ route('adjustment.detail',$d->id) }}">
                        <i class="fa fa-eye"></i> {{__('general.detail')}}
                    </a>
                    @endcan
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $data->links('partials.return_pagination') }}

</div>
