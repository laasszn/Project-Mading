@extends('layouts.app')

@section('title', 'Profil Smezine - SMK N 1 Dukuhturi')

@push('styles')
    <!-- Google Fonts & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --blue-primary: #2563eb;
            --blue-dark: #1d4ed8;
            --dark-bg: #07090e;
            --dark-surface: #0f131d;
            --dark-card: rgba(18, 24, 38, 0.88);
            --dark-border: rgba(255, 255, 255, 0.08);
            --text-muted: #94a3b8;
        }

        /* RESET AGAR TIDAK TERKUNCI */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-color: var(--dark-bg) !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #ffffff;
            overflow: hidden !important;
        }

        /* MANGA SCREEN PATTERN (BERSIH, TANPA GLOW) */
        .manga-panel-pattern {
            position: fixed;
            inset: 0;
            background-image: 
                radial-gradient(rgba(255, 255, 255, 0.06) 1.2px, transparent 1.2px),
                linear-gradient(to right, rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 26px 26px, 120px 120px, 120px 120px;
            pointer-events: none;
            z-index: 1;
        }

        /* ========================================================
           CONTAINER UTAMA SCROLL-SNAP VERTIKAL (3 SLIDE)
           ======================================================== */
        .fullpage-scroll-container {
            width: 100vw;
            height: calc(100vh - 65px);
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scroll-snap-type: y mandatory;
            scroll-behavior: smooth;
            position: relative;
            z-index: 5;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .fullpage-scroll-container::-webkit-scrollbar {
            display: none;
        }

        .fullpage-slide-section {
            width: 100vw;
            height: calc(100vh - 65px);
            min-height: calc(100vh - 65px);
            max-height: calc(100vh - 65px);
            scroll-snap-align: start;
            scroll-snap-stop: always;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            background-color: var(--dark-bg);
            display: flex;
            align-items: center;
        }

        /* INDIKATOR 3 TITIK VERTIKAL KANAN */
        .vertical-dots-nav {
            position: fixed;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 999;
        }
        .v-dot-item {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .v-dot-item.active {
            height: 28px;
            border-radius: 20px;
            background: var(--blue-primary);
        }

        /* ========================================================
           SLIDE 1: INTRO (FOTO BESAR & TANPA GLOW)
           ======================================================== */
        .slide-1-grid {
            width: 100%;
            height: 100%;
            display: grid;
            grid-template-columns: 1.25fr 1fr;
            box-sizing: border-box;
            position: relative;
            z-index: 10;
        }

        .slide-1-img-col {
            position: relative;
            height: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow: hidden;
            padding-bottom: 25px;
            box-sizing: border-box;
        }

        .hero-team-img {
            height: 88%;
            max-height: 90%;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            object-position: bottom center;
            filter: drop-shadow(0 20px 35px rgba(0, 0, 0, 0.9));
            transform: translateY(60px);
            opacity: 0;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease;
            position: relative;
            z-index: 5;
        }

        .fullpage-slide-section.active .hero-team-img {
            transform: translateY(0);
            opacity: 1;
        }

        .trio-indicator-dots {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }
        .t-dot {
            width: 9px;
            height: 9px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
        }
        .t-dot.active {
            width: 24px;
            background: var(--blue-primary);
            border-radius: 20px;
        }

        .slide-1-text-col {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 80px 0 20px;
            z-index: 5;
        }

        .slide-1-text-col h1 {
            font-size: clamp(2.3rem, 3.8vw, 3.6rem);
            font-weight: 900;
            line-height: 1.15;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            margin: 0 0 18px 0;
            color: #ffffff;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.15s;
        }
        .slide-1-text-col h1 span {
            color: var(--blue-primary);
        }

        .slide-1-text-col p {
            color: var(--text-muted);
            font-size: 1.05rem;
            line-height: 1.7;
            max-width: 520px;
            margin: 0 0 32px 0;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.25s;
        }

        .btn-blue-action {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--blue-primary);
            color: #ffffff;
            padding: 14px 36px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            transition: all 0.25s ease;
            width: fit-content;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.35s;
        }
        .btn-blue-action:hover {
            background: var(--blue-dark);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .fullpage-slide-section.active .slide-1-text-col h1,
        .fullpage-slide-section.active .slide-1-text-col p,
        .fullpage-slide-section.active .btn-blue-action {
            transform: translateY(0);
            opacity: 1;
        }

        /* ========================================================
           SLIDE 2: KETUA UMUM (KARTU KACA & BADGE #01 BPH)
           ======================================================== */
        .slide-2-grid {
            width: 100%;
            height: 100%;
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            box-sizing: border-box;
            position: relative;
            z-index: 10;
        }

        .slide-2-card-col {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 60px 0 80px;
            z-index: 15;
        }

        .glass-intro-card {
            background: var(--dark-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 28px;
            padding: 45px 42px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.7);
            position: relative;
            max-width: 480px;
            transform: translateX(-50px);
            opacity: 0;
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.15s;
        }

        .fullpage-slide-section.active .glass-intro-card {
            transform: translateX(0);
            opacity: 1;
        }

        .glass-intro-card h2 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 4px 0;
            line-height: 1.1;
        }
        .glass-intro-card h2 span {
            color: var(--blue-primary);
            font-size: 1rem;
            font-weight: 600;
            display: block;
            margin-top: 6px;
        }

        .glass-intro-card p {
            color: #cbd5e1;
            font-size: 0.96rem;
            line-height: 1.7;
            margin: 20px 0 30px 0;
        }

        .circular-bph-badge {
            position: absolute;
            bottom: -25px;
            right: 35px;
            background: var(--blue-primary);
            color: #ffffff;
            width: 74px;
            height: 74px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 1.05rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
            border: 3px solid var(--dark-bg);
            z-index: 20;
        }
        .circular-bph-badge span {
            font-size: 0.65rem;
            font-weight: 700;
            opacity: 0.9;
        }

        .slide-2-img-col {
            position: relative;
            height: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow: hidden;
        }

        .curved-blue-bg {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, #1e3a8a, rgba(37, 99, 235, 0.4));
            border-top-left-radius: 260px;
            border-bottom-left-radius: 40px;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1;
        }

        .lead-big-img {
            height: 92%;
            max-height: 94%;
            width: auto;
            object-fit: contain;
            object-position: bottom center;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.85));
            position: relative;
            z-index: 5;
            transform: translateY(60px);
            opacity: 0;
            transition: all 0.85s cubic-bezier(0.16, 1, 0.3, 1) 0.2s;
        }

        .fullpage-slide-section.active .lead-big-img {
            transform: translateY(0);
            opacity: 1;
        }

        /* ========================================================
           SLIDE 3: DIVISI & PENGURUS HARIAN (SEMUA 8 KARTU TAMPIL)
           ======================================================== */
        .slide-3-grid {
            width: 100%;
            height: 100%;
            display: grid;
            grid-template-columns: 320px 1fr;
            box-sizing: border-box;
            position: relative;
            z-index: 10;
        }

        .slide-3-blue-col {
            background: linear-gradient(175deg, #1e40af, #1d4ed8, #0f172a);
            height: 100%;
            padding: 70px 40px 50px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 10;
        }

        .slide-3-blue-col h2 {
            font-family: 'Bebas Neue', cursive;
            font-size: 3.4rem;
            line-height: 0.95;
            letter-spacing: 2px;
            margin: 10px 0 0 0;
            color: #ffffff;
        }

        .slide-3-blue-col p {
            font-size: 0.92rem;
            color: #bfdbfe;
            line-height: 1.6;
            margin: 0;
        }

        /* Navigasi Panah Geser Kartu */
        .cards-scroll-controls {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        .btn-card-nav {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-card-nav:hover {
            background: var(--blue-primary);
            transform: scale(1.08);
        }

        .slide-3-cards-col {
            height: 100%;
            display: flex;
            align-items: center;
            padding: 0 60px 0 35px;
            gap: 22px;
            overflow-x: auto;
            scroll-behavior: smooth;
            box-sizing: border-box;
            /* Scrollbar halus agar user tahu kartu bisa digeser */
            scrollbar-width: thin;
            scrollbar-color: var(--blue-primary) rgba(255, 255, 255, 0.05);
        }
        .slide-3-cards-col::-webkit-scrollbar {
            height: 6px;
            display: block;
        }
        .slide-3-cards-col::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }
        .slide-3-cards-col::-webkit-scrollbar-thumb {
            background: var(--blue-primary);
            border-radius: 10px;
        }

        .division-card-box {
            flex: 0 0 240px;
            height: 74%;
            border-radius: 22px;
            position: relative;
            overflow: hidden;
            background: #0d121f;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 22px;
            box-sizing: border-box;
            cursor: pointer;
            transform: translateY(40px);
            opacity: 0;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.5s ease, border-color 0.25s ease;
        }

        /* PERBAIKAN: SEMUA KARTU (1 s/d 8) DIBUAT TAMPIL OTOMATIS */
        .fullpage-slide-section.active .division-card-box {
            transform: translateY(0);
            opacity: 1;
        }
        .division-card-box:nth-child(1) { transition-delay: 0.05s; }
        .division-card-box:nth-child(2) { transition-delay: 0.1s; }
        .division-card-box:nth-child(3) { transition-delay: 0.15s; }
        .division-card-box:nth-child(4) { transition-delay: 0.2s; }
        .division-card-box:nth-child(5) { transition-delay: 0.25s; }
        .division-card-box:nth-child(6) { transition-delay: 0.3s; }
        .division-card-box:nth-child(7) { transition-delay: 0.35s; }
        .division-card-box:nth-child(8) { transition-delay: 0.4s; }

        .division-card-box:hover {
            transform: translateY(-8px) !important;
            border-color: var(--blue-primary);
        }

        .char-img-inner {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 85%;
            object-fit: cover;
            object-position: top center;
            z-index: 1;
            transition: transform 0.4s ease;
        }
        .division-card-box:hover .char-img-inner {
            transform: translateX(-50%) scale(1.06);
        }

        .division-card-box::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(7, 9, 14, 0.98) 0%, rgba(7, 9, 14, 0.6) 45%, transparent 85%);
            z-index: 2;
        }

        .division-caption {
            position: relative;
            z-index: 5;
        }

        .division-caption .d-tag {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--blue-primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .division-caption h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            line-height: 1.25;
        }

        .d-bookmark {
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 6;
            color: #cbd5e1;
            font-size: 1.1rem;
            transition: color 0.25s ease, transform 0.25s ease;
        }
        .division-card-box:hover .d-bookmark {
            color: var(--blue-primary);
            transform: scale(1.15);
        }

        /* RESPONSIVE LAYAR HP */
        @media (max-width: 992px) {
            .slide-1-grid,
            .slide-2-grid,
            .slide-3-grid {
                grid-template-columns: 1fr;
            }
            .slide-1-img-col {
                order: 2;
                height: 48%;
            }
            .slide-1-text-col {
                order: 1;
                padding: 40px 25px 0;
            }
            .slide-2-img-col {
                display: none;
            }
            .slide-2-card-col {
                padding: 40px 25px 0;
                justify-content: center;
            }
            .slide-3-blue-col {
                height: auto;
                padding: 30px 25px 15px;
            }
            .slide-3-cards-col {
                padding: 15px 25px 40px;
            }
            .vertical-dots-nav {
                right: 14px;
            }
        }

        /* LIGHT MODE — panel biru slide 3 & badge DPH tetap seperti semula */
        html[data-theme="light"] {
            --dark-bg: #f7f9fc;
            --dark-surface: #ffffff;
            --dark-card: rgba(255, 255, 255, 0.94);
            --dark-border: rgba(15, 23, 42, 0.1);
            --text-muted: #64748b;
        }
        html[data-theme="light"] body { color: #0f172a; }
        html[data-theme="light"] .manga-panel-pattern {
            background-image:
                radial-gradient(rgba(15, 23, 42, 0.07) 1.2px, transparent 1.2px),
                linear-gradient(to right, rgba(15, 23, 42, 0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15, 23, 42, 0.04) 1px, transparent 1px);
        }
        html[data-theme="light"] .v-dot-item { background: rgba(15, 23, 42, 0.2); }
        html[data-theme="light"] .t-dot { background: rgba(15, 23, 42, 0.18); }
        html[data-theme="light"] .slide-1-text-col h1 { color: #0f172a; }
        html[data-theme="light"] .hero-team-img,
        html[data-theme="light"] .lead-big-img { filter: drop-shadow(0 20px 30px rgba(15, 23, 42, 0.25)); }
        html[data-theme="light"] .glass-intro-card {
            border-color: rgba(15, 23, 42, 0.12);
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.12);
        }
        html[data-theme="light"] .glass-intro-card h2 { color: #0f172a; }
        html[data-theme="light"] .glass-intro-card p { color: #475569; }
        html[data-theme="light"] .division-card-box {
            background: #ffffff;
            border-color: rgba(15, 23, 42, 0.12);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.1);
        }
        html[data-theme="light"] .division-card-box::after {
            background: linear-gradient(to top, rgba(255,255,255,0.98) 0%, rgba(255,255,255,0.65) 45%, transparent 85%);
        }
        html[data-theme="light"] .division-caption h3 { color: #0f172a; }
        html[data-theme="light"] .d-bookmark { color: #94a3b8; }
        html[data-theme="light"] .division-card-box:hover .d-bookmark { color: var(--accent-red); }
    </style>
@endpush

@section('content')
<!-- MANGA PATTERN OVERLAY (TANPA GLOW) -->
<div class="manga-panel-pattern"></div>

<!-- INDIKATOR 3 TITIK VERTIKAL SISI KANAN -->
<div class="vertical-dots-nav">
    <div class="v-dot-item active" onclick="jumpToSlide(0)"></div>
    <div class="v-dot-item" onclick="jumpToSlide(1)"></div>
    <div class="v-dot-item" onclick="jumpToSlide(2)"></div>
</div>

<!-- ========================================================
     CONTAINER FULLPAGE (HANYA 3 SLIDE)
     ======================================================== -->
<div class="fullpage-scroll-container" id="scrollContainer">

    <!-- SLIDE 1: INTRO SMEZINE - JUDUL, DESKRIPSI, FOTO DARI DB (tentang_slide1s) -->
    <section class="fullpage-slide-section active" id="sec-slide-0">
        <div class="slide-1-grid">
            <div class="slide-1-img-col">
                @if(isset($slide1) && $slide1 && $slide1->foto)
                    <img src="{{ asset('storage/' . $slide1->foto) }}" 
                         alt="Slide 1" 
                         class="hero-team-img"
                         onerror="this.src='https://www.pngmart.com/files/4/Haikyuu-PNG-Photos.png'">
                @else
                    <img src="https://www.pngmart.com/files/4/Haikyuu-PNG-Photos.png" 
                         alt="Smezine Team" 
                         class="hero-team-img"
                         onerror="this.src='https://pngimg.com/uploads/anime_girl/anime_girl_PNG41.png'">
                @endif
            </div>

            <div class="slide-1-text-col">
                @php
                    $defaultJudul = 'LITERASI & KREATIFITAS DIGITAL TINGGI HANYA DI SMEZINE.';
                    $judul = isset($slide1) && $slide1 && $slide1->judul ? $slide1->judul : $defaultJudul;
                    // highlight SMEZINE (dengan atau tanpa titik) jika ada, else highlight kata terakhir
                    if (str_contains(strtolower($judul), 'smezine')) {
                        $judulHtml = preg_replace('/(smezine\.?)/i', '<span>$1</span>', e($judul));
                    } else {
                        $parts = explode(' ', e($judul));
                        if (count($parts) > 1) {
                            $last = array_pop($parts);
                            $judulHtml = e(implode(' ', $parts)) . ' <span>' . $last . '</span>';
                        } else {
                            $judulHtml = '<span>' . e($judul) . '</span>';
                        }
                    }
                    $defaultDeskripsi = 'Smezine (Ekstrakurikuler Majalah Dinding SMK N 1 Dukuhturi) adalah wadah eksplorasi jurnalistik modern, seni grafis, dan multimedia sekolah. Kami memadukan budaya literasi dengan estetika visual digital terkini untuk melahirkan karya berdaya cipta tinggi.';
                    $deskripsi = isset($slide1) && $slide1 && $slide1->deskripsi ? $slide1->deskripsi : $defaultDeskripsi;
                @endphp
                <h1>{!! $judulHtml !!}</h1>
                <p>{{ $deskripsi }}</p>
                <div>
                    <button class="btn-blue-action" onclick="jumpToSlide(1)">
                        Pelajari Pimpinan <i class="fa-solid fa-arrow-down"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- SLIDE 2: KETUA UMUM - FOTO & NAMA DARI DATABASE -->
    <section class="fullpage-slide-section" id="sec-slide-1">
        <div class="slide-2-grid">
            <div class="slide-2-card-col">
                <div class="glass-intro-card">
                    <h2>
                        @if(isset($ketuaUmumSingle) && $ketuaUmumSingle) {{ $ketuaUmumSingle->nama }} @else Ketua Umum @endif
                        <span>@if(isset($ketuaUmumSingle) && $ketuaUmumSingle) {{ $ketuaUmumSingle->jabatan }} - @endif Badan Pengurus Harian 2025 / 2026</span>
                    </h2>
                    <p>
                        @if(isset($ketuaUmumSingle) && $ketuaUmumSingle)
                            "{{ $ketuaUmumSingle->nama }} - {{ $ketuaUmumSingle->jabatan }} memimpin tim kreatif Smezine untuk terus berinovasi dalam mengemas informasi sekolah yang mendidik, segar, dan berwawasan digital tanpa menghilangkan nilai estetika karya."
                        @else
                            "Memimpin tim kreatif Smezine untuk terus berinovasi dalam mengemas informasi sekolah yang mendidik, segar, dan berwawasan digital tanpa menghilangkan nilai estetika karya."
                        @endif
                    </p>
                    <button class="btn-blue-action" onclick="jumpToSlide(2)">
                        Lihat Divisi & Pengurus <i class="fa-solid fa-arrow-down"></i>
                    </button>

                    <div class="circular-bph-badge">
                        #01
                        <span>BPH</span>
                    </div>
                </div>
            </div>

            <div class="slide-2-img-col">
                <div class="curved-blue-bg"></div>
                @if(isset($ketuaUmumSingle) && $ketuaUmumSingle)
                    <img src="{{ $ketuaUmumSingle->foto ? asset('storage/' . $ketuaUmumSingle->foto) : $ketuaUmumSingle->foto_url }}" 
                         alt="{{ $ketuaUmumSingle->nama }}" 
                         class="lead-big-img"
                         onerror="this.src='https://www.pngmart.com/files/13/Aesthetic-Anime-Boy-PNG-Photo.png'">
                @else
                    <img src="https://www.pngmart.com/files/13/Aesthetic-Anime-Boy-PNG-Photo.png" 
                         alt="Ketua Umum" 
                         class="lead-big-img"
                         onerror="this.src='https://pngimg.com/uploads/anime_girl/anime_girl_PNG31.png'">
                @endif
            </div>
        </div>
    </section>

    <!-- SLIDE 3: DIVISI & SELURUH PENGURUS HARIAN (SEMUA 8 ORANG TAMPIL) -->
    <section class="fullpage-slide-section" id="sec-slide-2">
        <div class="slide-3-grid">
            <!-- Sisi Kiri: Blok Biru Tegak -->
            <div class="slide-3-blue-col">
                <div>
                    <span style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 2px; color: #bfdbfe; font-weight: 700;">Struktur Lengkap</span>
                    <h2>DIVISI & PENGURUS HARIAN</h2>
                    <p style="margin-top: 15px;">Keluarga inti penggerak literasi, ilustrasi, tata kelola, dan media digital mading Smezine.</p>
                </div>

                <!-- Tombol Navigasi Geser Kartu Kiri-Kanan -->
                <div class="cards-scroll-controls">
                    <button type="button" class="btn-card-nav" onclick="scrollMemberCards(-280)" aria-label="Geser kartu ke kiri">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button type="button" class="btn-card-nav" onclick="scrollMemberCards(280)" aria-label="Geser kartu ke kanan">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Sisi Kanan: Kartu Anggota DARI DATABASE - BISA DITAMBAH VIA ADMIN (Slide 3) -->
            <div class="slide-3-cards-col" id="membersCardsTrack">
                @forelse($slide3Members as $anggota)
                    <div class="division-card-box">
                        <img src="{{ $anggota->foto ? asset('storage/' . $anggota->foto) : $anggota->foto_url }}" 
                             alt="{{ $anggota->nama }}" 
                             class="char-img-inner"
                             onerror="this.src='https://via.placeholder.com/300x400?text=No+Image'">
                        <div class="division-caption">
                            <div class="d-tag">{{ $anggota->jabatan }}</div>
                            <h3>{{ $anggota->nama }}</h3>
                        </div>
    
                    </div>
                @empty
                    <div style="flex:0 0 340px; background: rgba(255,255,255,0.04); border:1px dashed rgba(255,255,255,0.14); border-radius:18px; padding:28px; text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px;">
                        <i class="fa-solid fa-users" style="font-size:2rem; color: var(--blue-primary);"></i>
                        <p style="color:#cbd5e1; font-weight:700;">Belum ada anggota di slide ini</p>
                        <p style="color:#94a3b8; font-size:0.85rem; line-height:1.5;">Foto & nama anggota diambil dari database.<br>Silakan kelola melalui <strong>Panel Kelola Anggota</strong>.</p>
                    </div>
                @endforelse

               
            </div>
        </div>
    </section>

</div>

<!-- SCRIPT PENGATUR SCROLL VERTICAL DAN HORIZONTAL -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('scrollContainer');
        const sections = document.querySelectorAll('.fullpage-slide-section');
        const dots = document.querySelectorAll('.v-dot-item');
        const cardsTrack = document.getElementById('membersCardsTrack');

        // 1. Fungsi Lompat Antar Slide Vertikal (0, 1, 2)
        window.jumpToSlide = function(index) {
            if (sections[index]) {
                sections[index].scrollIntoView({ behavior: 'smooth' });
            }
        };

        // 2. Fungsi Geser Kartu Anggota Horizontal di Slide 3
        window.scrollMemberCards = function(amount) {
            if (cardsTrack) {
                cardsTrack.scrollBy({ left: amount, behavior: 'smooth' });
            }
        };

        // 3. Scroll Mouse Wheel Otomatis Menggeser Kartu Saat Cursor Ada di Atas Kartu Slide 3
        if (cardsTrack) {
            cardsTrack.addEventListener('wheel', function(e) {
                // Jika masih ada ruang geser ke samping, geser kartu horizontal
                const isAtEnd = cardsTrack.scrollLeft + cardsTrack.clientWidth >= cardsTrack.scrollWidth - 10;
                const isAtStart = cardsTrack.scrollLeft <= 10;

                if ((e.deltaY > 0 && !isAtEnd) || (e.deltaY < 0 && !isAtStart)) {
                    e.preventDefault();
                    cardsTrack.scrollBy({ left: e.deltaY * 2.5, behavior: 'auto' });
                }
            }, { passive: false });
        }

        // 4. Deteksi Slide Aktif Menggunakan IntersectionObserver (Update Dots)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    sections.forEach(s => s.classList.remove('active'));
                    entry.target.classList.add('active');

                    const id = entry.target.id;
                    const index = parseInt(id.replace('sec-slide-', ''));
                    dots.forEach((dot, idx) => {
                        dot.classList.toggle('active', idx === index);
                    });
                }
            });
        }, {
            root: container,
            threshold: 0.5
        });

        sections.forEach(sec => observer.observe(sec));

        // 5. Dukungan Panah Keyboard Atas & Bawah
        window.addEventListener('keydown', (e) => {
            if (['ArrowDown', 'PageDown', 'Space'].includes(e.key)) {
                e.preventDefault();
                container.scrollBy({ top: container.clientHeight, behavior: 'smooth' });
            } else if (['ArrowUp', 'PageUp'].includes(e.key)) {
                e.preventDefault();
                container.scrollBy({ top: -container.clientHeight, behavior: 'smooth' });
            }
        });
    });
</script>
@endsection
