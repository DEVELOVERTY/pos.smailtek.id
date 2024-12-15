<div class="table-responsive"> 
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Ref No</th>
                <th>Kategori</th>
                <th>Nama Pengeluaran</th> 
                <th>Store</th> 
                <th>Tanggal</th>
                <th>Refund</th> 
                <th>Jumlah Pengeluaran</th> 
            </tr>
        </thead>
        <tbody> 
            @foreach ($data as $d)
                <tr>  
                    <td> {{ $d->ref_no }} </td>
                    <td> {{ $d->category->name ?? '' }} </td>
                    <td> {{ $d->name }} </td> 
                    <td> {{ $d->store->name ?? '' }} </td>
                    <td> {{ my_date($d->created_at) }} </td>
                    <td>
                        @if($d->refund == 'yes') 
                            Iya
                        @else 
                            Bukan
                        @endif
                    </td>  
                    <td> {{ number_format($d->amount) }} </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                <th colspan="6" style="height: 100px; font-size:30px">Total</th> 
                <th>{{ number_format($jumlahTotal) }}</th>
            </tr>
        </tfoot>
    </table> 
    {{ $data->links('partials.return_pagination') }}  
</div>