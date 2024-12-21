<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">

            <!-- MDHPOS LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('index') }}" class="logo logo-light mb-2">
                    <span class="logo-sm">
                        <img src="{{ asset($settings->logo) }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset($settings->logo) }}" class="mt-4" alt="" style="width: 65%;">
                    </span>
                </a>
            </div>
            <!-- END MDHPOS LOGO -->

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>


        </div>

        <div class="d-flex">
            <!-- Attendance -->
            @if (Auth()->user()->can('Check Int Check Out') == true)
            <div class="dropdown d-none d-lg-inline-block button-header">
                @if ($attendance == null)
                <a href="javascript:void(0)" id="checkint_attendance" class="btn  btn-block btn-primary mt-3"><i class="fas fa-arrow-alt-circle-up"></i> {{__('attendance.check_int')}}</a>
                <a href="javascript:void(0)" id="checkout_attendance" class="btn btn-block btn-danger mt-3 d-none"><i class="fas fa-arrow-alt-circle-up"></i> {{__('attendance.check_out')}}</a>
                <a href="javascript:void(0)" class="btn btn-block btn-success mt-3 d-none" id="attendance_clear"><i class="fas fa-check-circle"></i> {{__('attendance.end')}} </a>
                @elseif($attendance->check_out == null)
                <a href="javascript:void(0)" id="checkout_attendance" class="btn btn-block btn-danger mt-3"><i class="fas fa-arrow-alt-circle-up"></i> {{__('attendance.check_out')}}</a>
                <a href="javascript:void(0)" class="btn btn-block btn-success mt-3 d-none" id="attendance_clear"><i class="fas fa-check-circle"></i> {{__('attendance.end')}}</a>
                @else
                <a href="javascript:void(0)" class="btn btn-block btn-success mt-3" id="attendance_clear"><i class="fas fa-check-circle"></i> {{__('attendance.end')}}</a>
                @endif
            </div>
            @endif
            <!-- End Attendance -->



            @can("Peringatan Stock")
            <div class="dropdown d-none button-header d-lg-inline-block">
                <a href="{{ route('stock.alert') }}" id="checkint_attendance" class="btn  btn-block btn-primary mt-3">
                    <i class="mdi mdi-bell-outline"></i> Qty Alert
                </a>
            </div>
            @endcan

            @can("POS")
            <div class="dropdown d-none button-header d-lg-inline-block">
                <a href="{{route('pos.index')}}" id="checkint_attendance" class="btn  btn-block btn-primary mt-3">
                    <i class="mdi mdi-desktop-classic"></i> POS
                </a>
            </div>
            @endcan

            @can("Profit Loss Report")
            <div class="dropdown d-none button-header d-lg-inline-block">
                <a href="{{ route('profit.loss') }}" id="checkint_attendance" class="btn  btn-block btn-primary mt-3">
                    <i class="mdi mdi-book-open-outline"></i> Profit Loss
                </a>
            </div>
            @endcan

            <!-- Language Option -->
            <div class="dropdown d-none d-md-block">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="me-2" src="{{ asset('assets/icon/lang/'.app()->getLocale().'.png') }}" alt="Language" height="16"> {{app()->getLocale()}} <span class="mdi mdi-chevron-down"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    @foreach($lang as $key => $value)
                    <a href="{{ url('locale',$key) }}" class="dropdown-item notify-item">
                        <img src="{{ asset('assets/icon/lang/'.$key.'.png') }}" alt="user-image" class="me-1" height="12"> <span class="align-middle"> {{ __($value) }} </span>
                    </a>
                    @endforeach
                </div>
            </div>
            <!-- End Language Option -->

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{asset(Auth()->user()->photo)}}" alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{route('profile')}}"><i class="mdi mdi-account-circle font-size-17 align-middle me-1"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>



        </div>
    </div>
</header>
