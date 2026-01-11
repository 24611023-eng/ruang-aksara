@auth
    @if(auth()->user()->role === 'user')
    <!-- Sidebar Navigation (static) -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">
                @if(file_exists(public_path('images/ruang-aksara-logo-fix.jpeg')))
                    <img src="{{ asset('images/ruang-aksara-logo-fix.jpeg') }}" alt="Logo Ruang Aksara" class="sidebar-brand-logo mr-0" width="56" height="56">
                @else
                    <img src="{{ asset('images/ruang-aksara-logo.svg') }}" alt="Logo Ruang Aksara" class="sidebar-brand-logo mr-0" width="56" height="56">
                @endif
                <span style="color:#FFD600">Ruang Aksara</span>
            </a>
        </div>

        @auth
        <div class="sidebar-user-info">
            <p class="sidebar-user-name">{{ Auth::user()->name }}</p>
            <p class="sidebar-user-address">{{ Auth::user()->alamat ?? 'Alamat belum diisi' }}</p>
            <div class="sidebar-user-points">
                <i class="fas fa-star"></i>
                <span>{{ number_format(Auth::user()->points ?? 0) }} Points</span>
            </div>
        </div>
        @endauth

        <nav class="sidebar-nav">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.index') ? 'nav-active' : '' }}">
                @if(file_exists(public_path('images/ruang-aksara-logo-fix.jpeg')))
                    <img src="{{ asset('images/ruang-aksara-logo-fix.jpeg') }}" alt="Buku" class="sidebar-nav-icon" width="20" height="20">
                @else
                    <i class="fas fa-book"></i>
                @endif
                <span>Katalog Buku</span>
            </a>
            <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.index') ? 'nav-active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Order Saya</span>
            </a>
            <a href="{{ route('wishlists.index') }}" class="nav-link {{ request()->routeIs('wishlists.index') ? 'nav-active' : '' }}">
                <i class="fas fa-heart"></i>
                <span>Wishlist</span>
            </a>
            <a href="{{ route('loans.index') }}" class="nav-link {{ request()->routeIs('loans.index') ? 'nav-active' : '' }}">
                <i class="fas fa-book-open"></i>
                <span>Peminjaman</span>
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('help') }}" class="nav-link {{ request()->routeIs('help*') ? 'nav-active' : '' }}">
                <i class="fas fa-question-circle"></i>
                <span>Bantuan</span>
            </a>
            <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'nav-active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            
            @auth
            <form method="POST" action="{{ route('logout') }}" style="width: 100%; margin: 0;">
                @csrf
                <button type="submit" class="nav-link" style="margin-bottom: 0;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </button>
            </form>
            @endauth
        </nav>
    </div>
    @endif
@endauth

<!-- Main Wrapper (ALWAYS RENDERED) -->
<div class="main-wrapper sidebar-open" id="mainWrapper">

