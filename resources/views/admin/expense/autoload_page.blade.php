<div class="table-responsive">

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{__('general.ref_no')}}</th>
                <th>{{__('general.category_name')}}</th>
                <th>{{__('expense.name')}}</th>
                <th>{{__('expense.amount')}}</th>
                <th>{{__('general.store')}}</th>
                <th>{{__('general.date')}}</th>
                <th>{{__('general.action')}}</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $d)
            <tr>
                <td> {{ $d->ref_no }} </td>
                <td> {{ $d->category->name ?? '' }} </td>
                <td> {{ $d->name }} </td>
                <td> {{ number_format($d->amount) }} </td>
                <td> {{ $d->store->name ?? '' }} </td>
                <td> {{ my_date($d->created_at) }} </td>
                <td>
                    <a href="{{ route('expense.update',$d->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('expense.detail',$d->id) }}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('expense.delete',$d->id) }}" class="btn btn-sm btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $data->links('partials.return_pagination') }}
</div>
