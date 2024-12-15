<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">

        <div class="sidebar-menu">
            <ul class="menu ">


                <li class="sidebar-item my-4 text-center" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="right" title="Hold Transaction">
                    <a href="javascript:void(0)" id="hold_modal" data-bs-toggle="modal" data-bs-target="#holdmodal" class='sidebar-link'>
                        <i class="far fa-save text-white"></i>
                    </a>
                    <hr class="text-white">
                </li>


                <li class="sidebar-item my-4 text-center" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="right" title="Tambah Pelangan">
                    <a href="javascript:void(0)" id="hold_modal" data-bs-toggle="modal" data-bs-target="#addCustomer" class='sidebar-link'>
                        <i class="fas fa-user-plus text-white"></i>
                    </a>
                    <hr class="text-white">
                </li>


                <li class="sidebar-item my-4 text-center" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="right" title="Purchase Order">
                    <a href="{{ route('purchase.index') }}" class='sidebar-link'>
                        <i class="fas fa-truck text-white"></i>
                    </a>
                    <hr class="text-white">
                </li>

                <li class="sidebar-item my-4 text-center" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="right" title="Adjustment Stok">
                    <a href="{{ route('adjustment.index') }}" class='sidebar-link' >
                        <i class="far fa-check-circle text-white"></i>
                    </a>
                    <hr class="text-white">
                </li>

                <li class="sidebar-item my-4 text-center" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="right" title="Laporan Penjualan">
                    <a href="{{ route('sell.report') }}" class='sidebar-link'>
                        <i class="fas fa-file-invoice-dollar text-white"></i>
                    </a>
                    <hr class="text-white">
                </li>

                <li class="sidebar-item my-4 text-center" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="right" title="Transfer Stok">
                    <a href="{{ route('transfer.index') }}" class='sidebar-link'>
                        <i class="far fa-share-square text-white"></i>
                    </a>
                    <hr class="text-white">
                </li>

                <li class="sidebar-item my-4 text-center" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="right" title="Kembali Ke Dashboard">
                    <a href="{{ route('index') }}" class='sidebar-link'>
                        <i class="fas fa-sign-out-alt text-white"></i>
                    </a>
                    <hr>
                </li>


            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>