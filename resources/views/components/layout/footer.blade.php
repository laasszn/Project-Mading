{{-- footer --}}
<style>
    footer.smezine-footer {
        --footer-body-top: #0c203f;
        --footer-body-bottom: #07090e;
        --footer-sky: #0a1730;
        --footer-stars: 0.9;
        --footer-moon: #eef3ff;
        --footer-moon-opacity: 0.95;
        --footer-aurora: 1;
        --footer-mtn-far: #22395e;
        --footer-mtn-near: #16294a;
        --footer-ice: #dcebf5;
        --footer-heading: #93c5fa;
        --footer-link: #e8eef7;
        --footer-link-hover: #60a5fa;
        --footer-text: #aebdd4;
        --footer-muted: #7d93b5;
        --footer-line: rgba(147, 197, 253, 0.18);
        --footer-social: #bfdbfe;
        --footer-social-border: rgba(147, 197, 253, 0.35);

        background: linear-gradient(180deg, transparent 0, var(--footer-body-top) 260px, var(--footer-body-bottom) 100%);
        color: var(--footer-text);
        font-size: 0.9rem;
        margin-top: 0;
        padding: 0 0 26px;
        border-top: none;
        text-align: left;
        position: relative;
        overflow: hidden;
    }
    html[data-theme="light"] footer.smezine-footer {
        --footer-body-top: #d7e5f2;
        --footer-body-bottom: #bcd2e8;
        --footer-sky: #edf3f9;
        --footer-stars: 0;
        --footer-moon: #ffffff;
        --footer-moon-opacity: 0.45;
        --footer-aurora: 0.35;
        --footer-mtn-far: #c9d9ea;
        --footer-mtn-near: #a5c0d9;
        --footer-ice: #ffffff;
        --footer-heading: #1d4ed8;
        --footer-link: #0f172a;
        --footer-link-hover: #2563eb;
        --footer-text: #334155;
        --footer-muted: #64748b;
        --footer-line: rgba(29, 78, 216, 0.2);
        --footer-social: #1d4ed8;
        --footer-social-border: rgba(29, 78, 216, 0.35);

        background: linear-gradient(180deg, transparent 0, var(--footer-body-top) 260px, var(--footer-body-bottom) 100%);
        border-top: none;
        color: var(--footer-text);
    }

    .smezine-footer .footer-scene {
        display: block;
        width: 100%;
        height: 150px;
        margin-bottom: -2px;
        position: relative;
        z-index: 0;
    }
    .smezine-footer .footer-cols,
    .smezine-footer .footer-bottom {
        position: relative;
        z-index: 1;
    }
    .smezine-footer .mezzie {
        position: absolute;
        right: -45px;
        bottom: -35px;
        width: 280px;
        z-index: 2;
        pointer-events: none;
    }
    .smezine-footer .mezzie img {
        width: 100%;
        height: auto;
        display: block;
        transform: rotate(-45deg);
    }

    /* langit footer */
    .smezine-footer .sky-stop-0 { stop-color: var(--footer-sky); stop-opacity: 0; }
    .smezine-footer .sky-stop-mid { stop-color: var(--footer-sky); stop-opacity: 1; }
    .smezine-footer .sky-stop-1 { stop-color: var(--footer-body-top); stop-opacity: 1; }
    .smezine-footer .f-stars { opacity: var(--footer-stars); }
    .smezine-footer .f-moon { fill: var(--footer-moon); opacity: var(--footer-moon-opacity); }
    .smezine-footer .f-aurora { opacity: var(--footer-aurora); }
    .smezine-footer .f-mtn-far { fill: var(--footer-mtn-far); }
    .smezine-footer .f-mtn-near { fill: var(--footer-mtn-near); }
    .smezine-footer .f-ground { fill: var(--footer-body-top); }
    .smezine-footer .f-ice { fill: var(--footer-ice); }

    .smezine-footer .footer-cols {
        max-width: 1040px;
        margin: 0 auto;
        padding: 34px 20px 0;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 28px;
    }
    .smezine-footer .footer-col + .footer-col {
        border-left: 1px solid var(--footer-line);
        padding-left: 28px;
    }
    .smezine-footer .footer-heading {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--footer-heading);
        margin: 0 0 16px;
    }
    .smezine-footer .footer-links {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px 18px;
    }
    .smezine-footer .footer-links a {
        color: var(--footer-link);
        text-decoration: none;
        font-size: 0.88rem;
        transition: color 0.2s ease;
    }
    .smezine-footer .footer-links a:hover { color: var(--footer-link-hover); }
    .smezine-footer .footer-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
    .smezine-footer .footer-brand img { width: 36px; height: 36px; object-fit: contain; }
    .smezine-footer .footer-brand strong { display: block; color: var(--footer-link); font-size: 0.95rem; }
    .smezine-footer .footer-brand small { display: block; color: var(--footer-heading); font-size: 0.72rem; letter-spacing: 0.5px; }
    .smezine-footer .footer-desc { margin: 0 0 16px; color: var(--footer-text); font-size: 0.85rem; line-height: 1.6; }
    .smezine-footer .footer-social { display: flex; gap: 10px; }
    .smezine-footer .footer-social a {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 1px solid var(--footer-social-border);
        color: var(--footer-social);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .smezine-footer .footer-social a:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        transform: translateY(-2px);
    }
    .smezine-footer .footer-bottom {
        max-width: 1040px;
        margin: 28px auto 0;
        padding: 16px 20px 0;
        border-top: 1px solid var(--footer-line);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        font-size: 0.82rem;
        color: var(--footer-muted);
    }
    .smezine-footer .footer-bottom a { color: var(--footer-link); text-decoration: none; }
    .smezine-footer .footer-bottom a:hover { color: var(--footer-link-hover); }
    @media (max-width: 768px) {
        .smezine-footer .footer-cols { grid-template-columns: 1fr; gap: 24px; }
        .smezine-footer .footer-col + .footer-col { border-left: none; padding-left: 0; border-top: 1px solid var(--footer-line); padding-top: 24px; }
        .smezine-footer .footer-scene { height: 84px; }
        .smezine-footer .mezzie {width: 100px; right: -30px; bottom: 0px;}
    }
</style>

<footer class="smezine-footer">
    <svg class="footer-scene" viewBox="0 0 1440 150" preserveAspectRatio="xMidYMax slice" aria-hidden="true">
        <defs>
            <linearGradient id="footerSkyFade" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" class="sky-stop-0" />
                <stop offset="45%" class="sky-stop-mid" />
                <stop offset="100%" class="sky-stop-1" />
            </linearGradient>
            <linearGradient id="footerAuroraGreen" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#5eead4" stop-opacity="0" />
                <stop offset="55%" stop-color="#5eead4" stop-opacity="0.55" />
                <stop offset="100%" stop-color="#5eead4" stop-opacity="0" />
            </linearGradient>
            <linearGradient id="footerAuroraBlue" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#60a5fa" stop-opacity="0" />
                <stop offset="55%" stop-color="#60a5fa" stop-opacity="0.5" />
                <stop offset="100%" stop-color="#60a5fa" stop-opacity="0" />
            </linearGradient>
        </defs>
        <rect x="0" y="0" width="1440" height="150" fill="url(#footerSkyFade)" />
        <g class="f-stars" fill="#ffffff">
            <circle cx="120" cy="26" r="1.8" /><circle cx="260" cy="48" r="1.4" /><circle cx="420" cy="22" r="1.8" />
            <circle cx="580" cy="40" r="1.4" /><circle cx="740" cy="20" r="1.8" /><circle cx="900" cy="44" r="1.4" />
            <circle cx="60" cy="56" r="1.3" /><circle cx="1330" cy="56" r="1.6" /><circle cx="1010" cy="24" r="1.4" />
        </g>
        <circle class="f-moon" cx="1150" cy="34" r="19" />
        <g class="f-aurora">
            <path d="M-20 84 C 180 34, 340 90, 560 48 C 780 12, 980 82, 1220 38 C 1320 22, 1390 44, 1460 30 L1460 -10 L-20 -10 Z" fill="url(#footerAuroraGreen)" />
            <path d="M-20 98 C 200 56, 400 102, 620 62 C 840 26, 1060 94, 1280 54 C 1360 40, 1410 60, 1460 50 L1460 -10 L-20 -10 Z" fill="url(#footerAuroraBlue)" />
        </g>
        <path class="f-mtn-far" d="M0 106 L120 68 L230 96 L340 62 L470 98 L600 70 L730 100 L860 66 L990 98 L1110 68 L1240 100 L1360 72 L1440 92 L1440 150 L0 150 Z" />
        <path class="f-mtn-near" d="M0 120 L180 94 L360 118 L540 96 L720 120 L900 98 L1080 120 L1260 100 L1440 118 L1440 150 L0 150 Z" />
        <path class="f-ground" d="M0 132 L220 118 L420 131 L640 119 L880 132 L1100 119 L1300 131 L1440 123 L1440 150 L0 150 Z" />
        <g class="f-ice">
            <polygon points="1052,132 1076,104 1100,132" />
            <polygon points="300,133 318,112 336,133" opacity="0.9" />
            <rect x="560" y="124" width="150" height="10" rx="5" opacity="0.85" />
        </g>
        <g>
            <ellipse cx="618" cy="112" rx="11" ry="15" fill="#10233f" />
            <ellipse cx="618" cy="115" rx="6.5" ry="10" fill="#ffffff" />
            <circle cx="614" cy="102" r="1.4" fill="#ffffff" /><circle cx="622" cy="102" r="1.4" fill="#ffffff" />
            <polygon points="618,105 615.5,108 620.5,108" fill="#f59e0b" />
            <ellipse cx="650" cy="116" rx="8" ry="11" fill="#10233f" />
            <ellipse cx="650" cy="118" rx="4.8" ry="7.4" fill="#ffffff" />
            <polygon points="650,109 648.2,111.4 651.8,111.4" fill="#f59e0b" />
        </g>
    </svg>

    <div class="footer-cols">
        <div class="footer-col">
            <div class="footer-brand">
                <img src="{{ asset('image/icon_2.png') }}" alt="Logo Smezine" />
                <div>
                    <strong>Smezine</strong>
                    <small>SMK N 1 DUKUHTURI</small>
                </div>
            </div>
            <p class="footer-desc">Wadah literasi, jurnalistik, dan kreativitas digital siswa Ekstrakurikuler Mading.</p>
            <div class="footer-social">
                <a href="#" aria-label="Instagram Smezine" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" aria-label="TikTok Smezine" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                <a href="#" aria-label="YouTube Smezine" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                <a href="#" aria-label="Facebook Smezine" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            </div>
        </div>
        <div class="footer-col">
            <h4 class="footer-heading">Jelajahi</h4>
            <div class="footer-links">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ url('/berita') }}">Berita Terbaru</a>
                <a href="{{ url('/galeri') }}">Galeri Karya</a>
                <a href="{{ url('/tentang') }}">Tentang Kami</a>
                <a href="{{ route('login') }}">Login Admin</a>
                @auth
                    <a href="{{ route('admin.berita.index') }}">Kelola Berita</a>
                @endauth
            </div>
        </div>
        <div class="footer-col">
            <h4 class="footer-heading">Sekolah</h4>
            <div class="footer-links">
                <a href="{{ url('/') }}">SMK N 1 Dukuhturi</a>
                <a href="{{ url('/tentang') }}">Profil Ekskul</a>
                <a href="{{ url('/berita') }}">Kegiatan</a>
                <a href="{{ url('/galeri') }}">Dokumentasi</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <span class="">&copy; {{ date('Y') }} Smezine — SMK N 1 Dukuhturi. All rights reserved.</span>
  
    </div>

    <div class="mezzie">
        <img src="{{ asset('image/mezzie_mikir.png') }}" alt="Mezzie">
    </div>
</footer>
