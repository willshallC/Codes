@auth()
    @include('employee.layouts.navbars.navs.auth')
@endauth

@guest()
    @include('employee.layouts.navbars.navs.guest')
@endguest
