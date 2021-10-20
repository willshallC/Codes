<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent fixed-top">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
			    <a class="main-logo"  href="{{ route('login') }}"><img src="{{ asset('/') }}custom/images/willshall-logo.svg" alt="Willshall Project Management System" title="Willshall  Project Management System"><span>Project Management System</span></a>
            <!--a class="navbar-brand" href="#">{{ $page ?? '' }}</a-->
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse guest_login_page" id="navigation">
            <ul class="navbar-nav ml-auto">
                <!--li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link text-primary">
                        <i class="tim-icons icon-minimal-left"></i> {{ __('Back to Dashboard') }}
                    </a>
                </li-->
                <li class="nav-item ">
                    <a href="{{ route('register') }}" class="nav-link">
                        <img src="{{ asset('/') }}custom/images/register.png" alt="" title="Register Now"> <span>{{ __('Register Now') }}</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('login') }}" class="nav-link">
                        <img src="{{ asset('/') }}custom/images/login-icon.svg" alt="" title="Login Now" style="width: 23px;"> <span> {{ __('Login') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
