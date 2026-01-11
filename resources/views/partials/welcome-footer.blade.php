@php
    $hasSidebar = $hasSidebar ?? false;
    $delayVisibility = $delayVisibility ?? false;
    $fullBleed = $fullBleed ?? false;
    $footerOffsetScale = isset($footerOffsetScale) ? floatval($footerOffsetScale) : 1.0;
    $userRole = optional(auth()->user())->role;
    // Disable floating help button for all users. If needed later,
    // re-enable by restoring the previous role-based condition.
    $showHelpFloat = false;
@endphp
<!-- Welcome footer + help modal (copied from welcome.blade.php) -->
<style>
    /* Ensure help button and modal styles are present when this partial is included */
    .help-float {
        position: fixed;
        right: 24px;
        bottom: 24px;
        width: 56px;
        height: 56px;
        border-radius: 9999px;
        background: linear-gradient(135deg,#f97316,#10b981);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(2,6,23,0.35);
        z-index: 2000;
        cursor: pointer;
        transition: transform .12s ease, box-shadow .12s ease;
    }
    .help-float:hover { transform: translateY(-4px); box-shadow: 0 16px 36px rgba(2,6,23,0.45); }
    .help-float .badge { position: absolute; top: -6px; right: -6px; background: #ef4444; color: white; font-size: 11px; padding: 2px 6px; border-radius: 9999px; }

    .help-modal-backdrop { position: fixed; inset: 0; background: rgba(2,6,23,0.6); display: none; align-items: center; justify-content: center; z-index: 1990; }
    .help-modal { background: white; width: 96%; max-width: 440px; border-radius: 12px; padding: 20px; box-shadow: 0 10px 40px rgba(2,6,23,0.4); }
    .help-modal h4 { margin-top: 0; margin-bottom: 8px; }
    .help-modal p { margin-bottom: 12px; color: #334155; }
    .help-modal .actions { display:flex; gap:10px; }

    @media (min-width: 768px) { .help-float{ right:32px; } }
    /* Footer inner container adjusts when a left sidebar is present (sidebar width: 16rem) */
    .footer-inner { max-width: 100%; margin: 0 auto; padding-left: 1rem; padding-right: 1rem; transition: margin-left 0.18s ease, max-width 0.18s ease; }
    @media (min-width: 1024px) {
        /* When a sidebar is active, JS will set --sidebar-offset to the sidebar's
           width and toggle `.has-sidebar`. Pages can pass `$footerOffsetScale`
           to reduce how much the footer shifts (1.0 = full offset).
        */
        .footer-inner.has-sidebar { margin-left: calc(var(--sidebar-offset, 0px) * {{ $footerOffsetScale }}); max-width: calc(100% - (var(--sidebar-offset, 0px) * {{ $footerOffsetScale }})); }
    }
    /* Removed full-bleed overrides so footer appearance matches welcome.blade.php */
    @if($delayVisibility)
    .app-footer {
        opacity: 0;
        transform: translateY(24px);
        pointer-events: none;
        transition: opacity 0.25s ease, transform 0.25s ease;
    }

    .app-footer.footer-visible {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
    @endif
</style>
<footer class="app-footer text-white py-6{{ $fullBleed ? ' full-bleed' : '' }}" style="background: linear-gradient(135deg, #2d5a3d 0%, #1e3e2a 100%) !important; margin-top: auto;">
    <div class="footer-inner {{ $hasSidebar ? 'has-sidebar' : '' }}">
        <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
            <div class="space-y-4">
                <h3 class="text-2xl font-bold flex items-center gap-2">
                    @if(file_exists(public_path('images/ruang-aksara-logo-fix.jpeg')))
                        <img src="{{ asset('images/ruang-aksara-logo-fix.jpeg') }}" alt="Ruang Aksara" class="h-12 mr-0 inline-block" />
                    @elseif(file_exists(public_path('images/ruang-aksara-logo.svg')))
                        <img src="{{ asset('images/ruang-aksara-logo.svg') }}" alt="Ruang Aksara" class="h-12 mr-0 inline-block" />
                    @else
                        <i class="fas fa-book"></i>
                    @endif
                    <span style="color: #FFD600;">Ruang Aksara</span>
                </h3>
                <p class="text-gray-200 text-sm leading-relaxed">
                    Platform buku yang berfokus pada kurasi bacaan bermanfaat dan dukungan pelanggan cepat.
                </p>
            </div>
            <div class="flex flex-col items-end text-right space-y-3">
                <h4 class="text-lg font-semibold">Kontak Kami</h4>
                <div class="flex flex-wrap justify-end gap-4 text-sm text-gray-200">
                    <span class="inline-flex items-center gap-1">
                        <i class="fas fa-map-marker-alt"></i>
                        <a href="https://maps.app.goo.gl/bPb1terfQACK9VCF7" target="_blank" class="text-gray-200 hover:text-white underline-offset-2">Campus UII Main Library, Sleman</a>
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <i class="fas fa-phone"></i>
                        <a href="tel:+62274123456" class="text-gray-200 hover:text-white">(0274) 123-456</a>
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:ruangg.aksara@gmail.com" class="text-gray-200 hover:text-white">ruangg.aksara@gmail.com</a>
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <i class="fab fa-whatsapp"></i>
                        <a href="https://wa.me/6281335833583" target="_blank" class="text-gray-200 hover:text-white">081335833583</a>
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <i class="fab fa-instagram"></i>
                        <a href="https://www.instagram.com/ruanggaksara?igsh=MXZ2M3JwdHZiYWZzdA==" target="_blank" class="text-gray-200 hover:text-white">@ruanggaksara</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="border-t border-white/20 mt-6 pt-3 text-center text-gray-200 text-sm">
            <p>&copy; {{ date('Y') }} Ruang Aksara. All rights reserved.</p>
        </div>
    </div>
</footer>
@if($showHelpFloat)
<!-- Floating help button -->
<div id="helpBackdrop" class="help-modal-backdrop" aria-hidden="true">
    <div class="help-modal" role="dialog" aria-modal="true" aria-labelledby="helpTitle">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
            <h4 id="helpTitle">Butuh Bantuan?</h4>
            <button id="helpClose" aria-label="Tutup" style="background:none;border:none;font-size:18px;">&times;</button>
        </div>
        <p>Butuh bantuan dengan pesanan atau mencari buku? Pilih salah satu opsi di bawah atau kunjungi Pusat Bantuan.</p>
        <div class="actions">
            <a href="/help" class="px-4 py-2 bg-green-600 text-white rounded-lg">Pusat Bantuan</a>
            <a href="mailto:ruangg.aksara@gmail.com" class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg">Kirim Email</a>
        </div>
    </div>
</div>

<button id="helpButton" class="help-float" title="Butuh Bantuan?">
    <i class="fas fa-headset"></i>
    <span class="badge">?</span>
</button>
@endif

<script>
    // Clear Google session and reload
    function clearGoogleSession() {
        fetch('{{ route("google.clear.session") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}'
            }
        }).then(() => {
            window.location.reload();
        });
    }

    // Help modal toggle
    (function(){
        const btn = document.getElementById('helpButton');
        const backdrop = document.getElementById('helpBackdrop');
        const close = document.getElementById('helpClose');
        if(!btn || !backdrop) return;
        btn.addEventListener('click', function(){ backdrop.style.display = 'flex'; backdrop.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; });
        close && close.addEventListener('click', function(){ backdrop.style.display='none'; backdrop.setAttribute('aria-hidden','true'); document.body.style.overflow=''; });
        backdrop.addEventListener('click', function(e){ if(e.target === backdrop){ backdrop.style.display='none'; backdrop.setAttribute('aria-hidden','true'); document.body.style.overflow=''; } });
        document.addEventListener('keydown', function(e){ if(e.key === 'Escape' && backdrop.style.display === 'flex'){ backdrop.style.display='none'; backdrop.setAttribute('aria-hidden','true'); document.body.style.overflow=''; } });
    })();
</script>

<script>
    // Adjust help button so it doesn't overlap the footer
    function adjustHelpButton() {
        const btn = document.getElementById('helpButton');
        if (!btn) return;

        const footer = document.querySelector('footer');
        const baseGap = 24; // default gap from bottom

        if (!footer) {
            btn.style.bottom = baseGap + 'px';
            return;
        }

        const rect = footer.getBoundingClientRect();
        // If footer is at or near the bottom of the viewport, lift the button above it
        if (rect.bottom >= window.innerHeight - 5) {
            btn.style.bottom = (rect.height + baseGap) + 'px';
        } else {
            btn.style.bottom = baseGap + 'px';
        }
    }

    window.addEventListener('load', adjustHelpButton);
    window.addEventListener('resize', adjustHelpButton);
    // In case content changes dynamically
    new MutationObserver(adjustHelpButton).observe(document.body, { childList: true, subtree: true });
</script>

@if($delayVisibility)
<script>
    (function(){
        const footer = document.querySelector('.app-footer');
        if(!footer) return;

        const scrollArea = document.querySelector('main.main-content');
        const epsilon = 4;

        function updateFooterVisibility(){
            let reachedBottom = false;

            if(scrollArea){
                const remaining = scrollArea.scrollHeight - scrollArea.scrollTop - scrollArea.clientHeight;
                reachedBottom = remaining <= epsilon;
            } else {
                const doc = document.documentElement;
                const scrollTop = window.scrollY || doc.scrollTop;
                const remaining = doc.scrollHeight - (scrollTop + window.innerHeight);
                reachedBottom = remaining <= epsilon;
            }

            footer.classList.toggle('footer-visible', reachedBottom);
        }

        const target = scrollArea || window;
        target.addEventListener('scroll', updateFooterVisibility, { passive: true });
        window.addEventListener('resize', updateFooterVisibility);
        updateFooterVisibility();
    })();
</script>
@endif

    <script>
        // Watch sidebar visibility and toggle .has-sidebar on the footer inner container
        (function(){
            const footerInner = document.querySelector('.footer-inner');
            if(!footerInner) return;

            const sidebar = document.getElementById('sidebar') || document.querySelector('.sidebar');

            function updateFooterForSidebar(){
                const isLarge = window.innerWidth >= 1024;
                let sidebarVisible = false;
                let sidebarWidth = 0;

                if(sidebar){
                    const style = window.getComputedStyle(sidebar);
                    sidebarVisible = style.display !== 'none' && !sidebar.classList.contains('hidden');
                    if(sidebarVisible){
                        const rect = sidebar.getBoundingClientRect();
                        sidebarWidth = Math.max(0, Math.round(rect.width));
                    }
                }

                if(isLarge && sidebarVisible){
                    footerInner.style.setProperty('--sidebar-offset', sidebarWidth + 'px');
                    footerInner.classList.add('has-sidebar');
                } else {
                    footerInner.classList.remove('has-sidebar');
                    footerInner.style.setProperty('--sidebar-offset', '0px');
                }
            }

            updateFooterForSidebar();

            if(sidebar){
                new MutationObserver(updateFooterForSidebar).observe(sidebar, { attributes: true, attributeFilter: ['class', 'style'] });
            }

            window.addEventListener('resize', updateFooterForSidebar);
            document.addEventListener('sidebar:toggled', updateFooterForSidebar);

            // If a global toggleSidebar function exists, wrap it to emit an event so the footer can react
            if(typeof window.toggleSidebar === 'function'){
                const _orig = window.toggleSidebar;
                window.toggleSidebar = function(){
                    const res = _orig.apply(this, arguments);
                    setTimeout(()=> document.dispatchEvent(new Event('sidebar:toggled')), 60);
                    return res;
                }
            }
        })();
    </script>
