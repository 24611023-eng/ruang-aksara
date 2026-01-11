@php
    $navItems = [
        [
            'label' => 'Dashboard',
            'icon' => 'fas fa-home',
            'route' => route('home'),
            'active' => request()->routeIs('home'),
        ],
        [
            'label' => 'Katalog Buku',
            'icon' => 'fas fa-book',
            'route' => route('books.index'),
            'active' => request()->routeIs('books.*'),
        ],
        [
            'label' => 'Order Saya',
            'icon' => 'fas fa-shopping-cart',
            'route' => route('orders.index'),
            'active' => request()->routeIs('orders.*'),
        ],
        [
            'label' => 'Wishlist',
            'icon' => 'fas fa-heart',
            'route' => route('wishlists.index'),
            'active' => request()->routeIs('wishlists.*'),
        ],
        [
            'label' => 'Peminjaman',
            'icon' => 'fas fa-book-open',
            'route' => route('loans.index'),
            'active' => request()->routeIs('loans.*'),
        ],
    ];

    $supportItems = [
        [
            'label' => 'Bantuan',
            'icon' => 'fas fa-question-circle',
            'route' => route('help'),
            'active' => request()->routeIs('help*'),
        ],
        [
            'label' => 'Pengaturan',
            'icon' => 'fas fa-cog',
            'route' => route('profile'),
            'active' => request()->routeIs('profile*'),
        ],
    ];
@endphp

<style>
    .sidebar.hidden { transform: none !important; }
</style>

<div class="sidebar-brand">
    <a href="{{ route('home') }}">
        @if(file_exists(public_path('images/ruang-aksara-logo-fix.jpeg')))
            <img src="{{ asset('images/ruang-aksara-logo-fix.jpeg') }}" alt="Ruang Aksara" class="sidebar-brand-logo mr-0" width="44" height="44">
        @else
            <i class="fas fa-book-open"></i>
        @endif
        <span>Ruang Aksara</span>
    </a>
</div>

@auth
@if(auth()->user()->role === 'user')
<div class="sidebar-user-info">
    <p class="sidebar-user-name">{{ Auth::user()->name }}</p>
    <p class="sidebar-user-address">{{ Auth::user()->alamat ?? 'Alamat belum diisi' }}</p>
    <div class="sidebar-user-points">
        <i class="fas fa-star"></i>
        <span>{{ number_format(Auth::user()->points ?? 0) }} Points</span>
    </div>
</div>
@endif
@endauth

<nav class="sidebar-nav" role="navigation" aria-label="Menu Utama">
    @foreach($navItems as $item)
        <a href="{{ $item['route'] }}" class="nav-link {{ $item['active'] ? 'nav-active' : '' }}">
            <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach

    <div class="sidebar-divider" aria-hidden="true"></div>

    @foreach($supportItems as $item)
        <a href="{{ $item['route'] }}" class="nav-link {{ $item['active'] ? 'nav-active' : '' }}">
            <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>

@auth
@if(auth()->user()->role === 'user')
<div class="sidebar-logout">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-logout-btn">
            <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
            <span>Keluar</span>
        </button>
    </form>
</div>
@endif
@endauth
