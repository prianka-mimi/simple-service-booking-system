<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion theme-gradient-sidebar" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link fs-5" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fs-5"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Menu</div>

                <div>
                    <a class="nav-link" href="#">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                        Users
                    </a>

                    <a class="nav-link" href="{{ route('service.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                        Services
                    </a>

                    <a class="nav-link" href="{{ route('booking.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-handshake"></i></div>
                        Bookings
                    </a>
                </div>
            </div>
    </nav>
</div>
