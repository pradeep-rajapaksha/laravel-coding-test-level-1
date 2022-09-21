<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">main menu</div>
            <a class="nav-link" href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <a class="nav-link" href="{{ route('events.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Events
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        @if(Auth::check())
            <ul class="d-md-inline-block navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>

            <div class="small">Logged in as:</div>
            {{ auth()->user()->fname ?? '' }} {{ auth()->user()->lname ?? '' }}
        @else
            <div class="small">
                <a href="{{ route('register') }}">Need an account? Sign up!</a> Or
                <a href="{{ route('login') }}">Login</a>
            </div>
        @endif
    </div>
</nav>