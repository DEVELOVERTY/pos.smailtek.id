<div class="shadow p-3 homepage-mdhpos-header bg-primary">
    <div class="title d-flex align-items-center">
        <div class="mr-auto">
            <a class="text-dark d-flex align-items-center" href="{{ route('index') }}">
                <i class="feather-skip-back fs-18 mr-2 text-white"></i>
                <h6 class="m-0 border-dashed-bottom text-white"> Kembali Ke Dashboard </h6>
            </a>
        </div>
        <div class=" d-flex align-items-center">
            <a class="text-dark mx-2 fs-18 top-nav-btn-cart position-relative" data-toggle="modal" data-target="#categorysortir" href="#">
                <i class="feather-users text-white"></i>
            </a>
        </div>
        <div class=" d-flex align-items-center">
            <a class="text-dark mx-2 fs-18 top-nav-btn-cart position-relative" id="hold_modal" data-toggle="modal" data-target="#holdmodal" href="#">
                <i class="feather-save text-white"></i>
            </a>
        </div>
    </div>
    <div class="input-group border mdhpos-search mt-3 rounded-lg shadow-sm overflow-hidden">
        <div class="input-group-prepend">
            <button class="border-0 btn btn-outline-secondary text-primary bg-white btn-block"><i class="feather-search"></i></button>
        </div>
        <input type="text" class="shadow-none border-0 form-control pl-0" id="searchProduct" placeholder="Cari Produk Disini ...." aria-label="" aria-describedby="basic-addon1">
    </div>
</div>