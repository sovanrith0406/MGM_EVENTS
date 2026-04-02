@include('backend.layouts.header')
@include('backend.layouts.leftsidebar')
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake"
         src="{{ asset('assets/dist/img/AdminLTELogo1.png') }}"
         alt="Your Logo"
         height="60"
         width="60">
</div>

    @yield('main-content')


@include('backend.layouts.footer')
