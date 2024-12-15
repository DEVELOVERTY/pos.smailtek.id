<div class="row top" style="margin-bottom: -1px; margin-left:0px; margin-right:0px; background-color: #4882c3;">
    <div class=" table-responsive">
        <table class="table mx-2" style=" margin-bottom:-0px; border: solid #4882c3">
            <tr>
                <th style="width:65%;" class="formsearch">
                    <div class="input-group" style="height: 6vh" id="seacrhform">
                        <input type="text" class="form-control form-pencarian" placeholder="Cari / Scan Produk" id="searchProduct" style="margin-top:0px;">
                        <span class="input-group-text">
                            <i class="fas fa-barcode"></i>
                        </span>
                    </div>
                    <div class="d-none" id="choosecustomer">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="position-relative">
                                        <select class="select2 form-control form-category" name="category" id="category" style="width:100%; ">
                                            <option value="all">{{__('pos.all_category')}}</option>
                                            @foreach ($category as $c)
                                            <optgroup label="{{ $c->name }}">
                                                @foreach ($c->children as $sub)
                                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="input-group">
                                    <select class="select2 form-control form-user" name="customer_id" id="customer_id" style="width:100%; ">
                                        @foreach ($customer as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
                <th class="text-right">
                    <button onclick="swicthcustomer()" class="btn btn-lg btn-light btn-rounded btn-primary float-end swicthcustomer" type="button">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                    <button onclick="swicthsearch()" class="btn btn-lg btn-light btn-rounded btn-primary float-end swicthsearch d-none" type="button">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                </th>

            </tr>
        </table>
    </div>
</div>