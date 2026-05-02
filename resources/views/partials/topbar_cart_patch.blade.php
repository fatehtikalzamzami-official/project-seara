{{--
    PATCH topbar.blade.php
    Ganti bagian "Keranjang" (a href="#") dengan ini:
--}}

{{-- Keranjang --}}
<a href="{{ route('cart.index') }}" class="topbar-icon-btn">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    <span>Keranjang</span>
    <div class="cart-badge" id="cartBadge" style="display:none">0</div>
</a>

{{--
    Tambahkan script ini di dalam tag <script> yang sudah ada di topbar,
    setelah pollChatBadge atau di akhir script:
--}}
@auth
(function pollCartBadge() {
    async function fetchCartCount() {
        try {
            const res  = await fetch('{{ route("cart.count") }}', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            const badge = document.getElementById('cartBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count > 99 ? '99+' : data.count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        } catch(e) { /* silent */ }
    }
    fetchCartCount();
    setInterval(fetchCartCount, 15000); // update tiap 15 detik
})();
@endauth
