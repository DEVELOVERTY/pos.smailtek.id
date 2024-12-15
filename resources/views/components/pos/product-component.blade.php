<div class="col-xl-7 col-md-7 col-sm-12">
    <div class="row" style="height:18vh; overflow: hidden; " id="">

        <div class="cat-slider border-bottom">
            @foreach ($category as $c)
            <div class="cat-item px-1 py-3">
                <a class="card text-center" style="box-shadow: 0px 1px 1px #000;" id="{{$c->id}}" href="javascript:void(0)" onclick="bycategory(this.id)">
                    <img src="{{asset($c->image)}}"   class="img-fluid mb-1 ">
                    <p class="m-0 ">{{$c->name}}</p>
                </a>
            </div>
            @endforeach
        </div>

    </div>
    <div class="row" style="height:75vh; overflow: auto; " id="productData">

        {{-- Product Data Content --}}

    </div>
</div>