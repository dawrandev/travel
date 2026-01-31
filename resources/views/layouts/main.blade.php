<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('components.header')
            @include('components.sidebar')
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
                @include('components.settingsidebar')
            </div>
            @include('components.footer')
        </div>
    </div>

    @stack('modals')

    @include('partials.script')
    @include('components.sweetalert')
    @stack('scripts')
</body>

</html>