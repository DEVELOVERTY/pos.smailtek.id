<div class="cat-slider border-bottom">
    @foreach ($category as $c)
    <div class="cat-item px-1 py-3" >
        <a class="d-block text-center" id="{{$c->id}}" href="javascript:void(0)" onclick="bycategory(this.id)">
            <img src="{{asset($c->image)}}" style="width: 80%; height:70px" class="img-fluid mb-2 shadow">
            <p class="m-0 small">{{$c->name}}</p>
        </a>
    </div>
    @endforeach
</div>