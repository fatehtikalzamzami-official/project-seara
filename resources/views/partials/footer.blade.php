<style>
footer { background: var(--green-dark); color: white; margin-top: 40px; }
.footer-inner {
    max-width: 1280px; margin: 0 auto;
    padding: 40px 24px 20px;
    display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 32px;
}
.footer-logo { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: #a8e6a8; margin-bottom: 8px; }
.footer-tagline { font-size: 13px; color: rgba(255,255,255,0.6); margin-bottom: 16px; line-height: 1.6; }
.footer-socials { display: flex; gap: 8px; }
.social-btn {
    width: 34px; height: 34px; background: rgba(255,255,255,0.1);
    border-radius: 8px; display: flex; align-items: center; justify-content: center;
    font-size: 16px; cursor: pointer; transition: background 0.2s;
    border: 1px solid rgba(255,255,255,0.1);
}
.social-btn:hover { background: rgba(255,255,255,0.2); }
.footer-col h4 { font-size: 13px; font-weight: 800; margin-bottom: 14px; color: rgba(255,255,255,0.9); }
.footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 8px; }
.footer-col ul li a { font-size: 13px; color: rgba(255,255,255,0.55); transition: color 0.2s; }
.footer-col ul li a:hover { color: #a8e6a8; }
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.08);
    padding: 16px 24px; text-align: center;
    font-size: 12px; color: rgba(255,255,255,0.4);
    max-width: 1280px; margin: 0 auto;
}
</style>

<footer>
    <div class="footer-inner">
        <div>
            <div class="footer-logo">🌾 SEARA</div>
            <p class="footer-tagline">Solusi pintar jual beli hasil komoditas langsung dari tangan petaninya — segar, terpercaya, dan tanpa perantara.</p>
            <div class="footer-socials">
                <div class="social-btn">📘</div>
                <div class="social-btn">📸</div>
                <div class="social-btn">🐦</div>
                <div class="social-btn">▶️</div>
            </div>
        </div>
        <div class="footer-col">
            <h4>Tentang SEARA</h4>
            <ul>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Karir</a></li>
                <li><a href="#">Blog Pertanian</a></li>
                <li><a href="#">Hubungi Kami</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Untuk Pembeli</h4>
            <ul>
                <li><a href="#">Cara Belanja</a></li>
                <li><a href="#">Pembayaran</a></li>
                <li><a href="#">Pengiriman</a></li>
                <li><a href="#">Retur & Refund</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Untuk Petani</h4>
            <ul>
                <li><a href="#">Daftar Petani</a></li>
                <li><a href="#">Cara Berjualan</a></li>
                <li><a href="#">Program Petani</a></li>
                <li><a href="#">Pelatihan</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Ikuti Kami</h4>
            <ul>
                <li><a href="#">Facebook SEARA</a></li>
                <li><a href="#">Instagram @seara</a></li>
                <li><a href="#">Twitter @seara</a></li>
                <li><a href="#">TikTok @seara</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        © {{ date('Y') }} SEARA — Platform Jual Beli Komoditas Pertanian. Hak cipta dilindungi.
    </div>
</footer>
