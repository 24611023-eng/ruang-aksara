@auth
@if(auth()->user()->role === 'user')
    <!-- Sidebar (static for users) -->
    <aside class="sidebar" id="sidebar" aria-label="Menu pengguna">
        @include('partials.user-sidebar-content')
    </aside>

    @once
        @push('scripts')
            <script src="{{ asset('js/sidebar.js') }}" defer></script>
        @endpush
    @endonce
@endif
@endauth

