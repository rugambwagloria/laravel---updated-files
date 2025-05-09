<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'schools-performance') == true ? ' mt-3 mx-3 bg-primary' : '' }}" id="navbarBlur"
        data-scroll="false" style="background-color: brown;">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
{{--                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>--}}
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
            </ol>
            @if (Auth::guard('admin')->check())
                <h5 class="font-weight-bolder text-white mb-0">{{ $title }}</h5>
                <h6 class="text-white">Welcome, {{ Auth::guard('admin')->user()->Fname }} {{ Auth::guard('admin')->user()->Lname }}</h6>
            @endif
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
{{--                                       <img src="/images/math.jpg" alt="Logo" style="width:80px;height:80px;">--}}

                        <div> <img src="/images/math.jpg" alt="Logo" style="width:80px;height:80px;"></div>
                        <div> <a class="nav-link text-white font-weight-bold" href="{{ route('home') }}">MATHEMATICS CHALLENGE COMPETITION</a></div>
                        <div class="get-started"> <a href="{{ route('schools-performance') }}"></a></div>
                    
        
            
                    <div class="nav-item d-flex align-items-center">
                        <a href="{{ route('welcome') }}" class="btn btn-outline-light btn-sm">Back to Home</a>
                    </div>
                    <div class="nav-item d-flex align-items-center">
                        <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            @if (Auth::guard('admin')->check())
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Log out</span>

                            </a>
                            @endif
                        </form>
                        
                    </div>
                
            </div>
        </div>
    </div>
</nav>
<!-- End Navbar -->
