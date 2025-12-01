<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" style="text-decoration: none; color: blue;" href="{{ route('admin.dashboard') }}"><h3>Naufal Adli</h3></a>
        <a class="sidebar-brand brand-logo-mini" style="text-decoration: none; color: blue;" href="{{ route('admin.dashboard') }}"><h3>Adli</h3></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    @php
                        $sidebar = \App\Models\Home::first();
                    @endphp
                    <div class="count-indicator">
                        <img loading="lazy" class="img-xs rounded-circle " src="{{ asset('img/home/'.$sidebar->foto) }}" alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name ?? 'Guest User' }}</h5>
                        <span>Admin Access</span>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-logout text-danger"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject ellipsis mb-1 text-small">Log out</p>
                            </div>
                        </button>
                    </form>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#portfolio-menu" aria-expanded="false" aria-controls="portfolio-menu">
                <span class="menu-icon"><i class="mdi mdi-briefcase"></i></span>
                <span class="menu-title">Portfolio Data</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="portfolio-menu">
                <ul class="nav flex-column sub-menu">
                    <!-- Tambahkan Link Ini -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.home.index') }}">Home / Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.about.index') }}">About Me</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.tech.index') }}">Tech Stack</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.journey.index') }}">My Journey</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.project.index') }}">My Project</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.certificate.index') }}">My Certificate</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.security.index') }}">
                <span class="menu-icon"><i class="mdi mdi-security"></i></span>
                <span class="menu-title">Security</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth"></div>
        </li>
    </ul>
</nav>
