<style>
    .navbar-vertical.navbar-expand-xs .navbar-collapse {
        overflow: visible!important;
    }
</style>

@props(['activePage'])

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-transparent" id="sidenav-main">
    <div class="sidenav-header">
        <img src="{{ asset('assets') }}/img/logos/logo.png" class="cursor-pointer h-80 w-80" id="iconSidenav" alt="">
    </div>
    <hr class="horizontal light mt-2 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'dashboard' ? ' active bg-gradient-secondary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'trainings' ? ' active bg-gradient-secondary' : '' }} "
                    href="{{ route('trainings') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">list</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">Trainings</span>
                </a>
            </li>
            @if(auth()->user()->isAdmin())
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'trainees' ? ' active bg-gradient-secondary' : '' }} "
                    href="{{ route('trainees') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">book</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">Trainees</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'training-centers' ? ' active bg-gradient-secondary' : '' }} "
                    href="{{ route('training.centers') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">home</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">Training Centers</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->isRoleSuperAdmin())
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'users' ? ' active bg-gradient-secondary' : '' }} "
                    href="{{ route('users') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">people</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">User Management</span>
                </a>
            </li>
            @endif
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'profile' ? 'active bg-gradient-secondary' : '' }} "
                    href="{{ route('profile') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">My Profile</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
