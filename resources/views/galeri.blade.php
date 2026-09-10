@extends('layouts.app')

@section('title', 'Galeri Smezine - Curved 3D')

@push('styles')
    <style>
        body {
            background-color: #0b0d10 !important;
            color: #ffffff;
            font-family: "Poppins", sans-serif;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* layout galeri */
        .gallery-fullscreen-wrapper {
            min-height: calc(100vh - 75px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 25px 0 20px 0;
            box-sizing: border-box;
            position: relative;
            /* biar card 3d gak kepotong */
            overflow: visible;
        }

        /* header */
        .curved-header {
            text-align: center;
            padding: 0 20px;
            flex-shrink: 0;
        }
        .curved-header .badge-tag {
            font-size: 0.85rem;
            font-weight: 600;
            color: #8e95a5;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: inline-block;
        }
        .curved-header h1 {
            font-size: clamp(2.2rem, 4.5vw, 3.6rem);
            font-weight: 800;
            letter-spacing: -1px;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 10px;
            color: #ffffff;
        }
        .curved-header p {
            max-width: 550px;
            margin: 0 auto;
            color: #9aa0a6;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* 3D Curved Arc Wrapper */
        .curved-gallery-wrapper {
            position: relative;
            width: 100%;
            flex-grow: 1;
            display: flex;
            align-items: center;
            perspective: 1300px;
            /* visible: scroll horizontal sudah ditampung track sendiri,
               jadi card 3D tidak terpotong wrapper */
            overflow: visible;
            padding: 40px 0;
            /* Display mode: transparan ikut background halaman, lapisan teratas konten */
            background: transparent;
            z-index: 60;
        }

        /* Track native: digeser dengan drag mouse / swipe HP / tombol / keyboard,
           polanya sama seperti card division di halaman tentang */
        .gallery-track {
            display: flex;
            align-items: center;
            gap: 26px;
            width: 100%;
            overflow-x: auto;
            overflow-y: visible;
            /* CATATAN: overflow-x:auto memaksa overflow-y jadi auto,
               jadi track TETAP memotong vertikal — padding atas-bawah
               ini ruang napasnya agar card + bayangan tidak terpotong.
               Bawah lebih besar karena bayangan menjulur ke bawah
               (z-index tidak bisa mengatasi potongan overflow). */
            padding: 70px 12px 120px;
            box-sizing: border-box;
            cursor: grab;
            scrollbar-width: none;
            -ms-overflow-style: none;
            -webkit-overflow-scrolling: touch;
            /* Transparan ikut background halaman, lapisan teratas konten */
            background: transparent;
            position: relative;
            z-index: 61;
        }
        .gallery-track::-webkit-scrollbar {
            display: none;
        }
        .gallery-track.is-dragging {
            cursor: grabbing;
            scroll-behavior: auto;
            user-select: none;
            -webkit-user-select: none;
        }
        .gallery-track.is-dragging img {
            pointer-events: none;
        }
        .gallery-track:focus { outline: none; }
        .gallery-track:focus-visible {
            outline: 2px solid rgba(255, 255, 255, 0.35);
            outline-offset: -2px;
            border-radius: 12px;
        }

        /* Wadah tiap kartu (transparan, hanya untuk layout) */
        .gallery-track .g-slide {
            width: 270px;
            height: 380px;
            flex: 0 0 auto;
            position: relative;
            background: transparent;
            border: none;
        }

        @media (max-width: 768px) {
            .gallery-fullscreen-wrapper {
                min-height: auto;
                padding: 20px 0;
            }
            .gallery-track {
                padding: 60px 12px 110px;
            }
            .gallery-track .g-slide {
                width: 195px;
                height: 275px;
            }
        }

        /* Kartu Fisik yang diberi efek 3D (efek diterapkan ke kartu, bukan wadahnya) */
        .slide-card {
            width: 100%;
            height: 100%;
            position: relative;
            border-radius: 22px;
            overflow: hidden;
            /* Transparan ikut background halaman, bukan hitam sendiri
               (keterbacaan caption dijaga overlay gradient ::after) */
            background: transparent;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.12);
            user-select: none;
            transform-style: preserve-3d;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            will-change: transform, opacity;
            transition: box-shadow 0.3s ease;
        }

        .slide-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            pointer-events: none;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .slide-card:hover img {
            transform: scale(1.08);
        }

        .slide-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
            pointer-events: none;
        }

        .slide-info {
            position: absolute;
            bottom: 18px;
            left: 18px;
            right: 18px;
            z-index: 2;
            pointer-events: none;
        }

        .slide-info h5 {
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .slide-info p {
            font-size: 0.82rem;
            color: #a5b0c0;
            margin: 3px 0 0 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Tombol Navigasi Carousel Utama */
        .slider-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 18px;
            padding-bottom: 10px;
            flex-shrink: 0;
            user-select: none;
            -webkit-user-select: none;
        }

        .slider-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        .slider-btn:hover {
            background: #ffffff;
            color: #000000;
            transform: scale(1.08);
        }

        .slider-btn:active {
            transform: scale(0.95);
        }

        /* ---- Switch Display / Grid Mode ---- */
        .gallery-view-switch {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 18px;
            padding: 4px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .gallery-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 22px;
            border-radius: 50px;
            border: none;
            background: transparent;
            color: #9aa0a6;
            font-family: "Poppins", sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
        }
        .gallery-view-btn:hover { color: #ffffff; }
        .gallery-view-btn.active {
            background: #ffffff;
            color: #000000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        /* mode grid */
        .gallery-masonry { display: none; }
        .gallery-fullscreen-wrapper.grid-mode {
            display: block;
            min-height: auto;
            overflow: visible;
        }
        .gallery-fullscreen-wrapper.grid-mode .curved-gallery-wrapper,
        .gallery-fullscreen-wrapper.grid-mode .slider-controls {
            display: none;
        }
        .gallery-fullscreen-wrapper.grid-mode .gallery-masonry {
            display: block;
            column-count: 4;
            column-gap: 22px;
            max-width: 1280px;
            margin: 0 auto;
            padding: 34px 24px 30px;
            box-sizing: border-box;
        }
        .masonry-card {
            display: inline-block;
            width: 100%;
            break-inside: avoid;
            -webkit-column-break-inside: avoid;
            margin: 0 0 22px 0;
            border-radius: 16px;
            overflow: hidden;
            background: #14161d;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 16px 34px rgba(0, 0, 0, 0.6);
            cursor: pointer;
            transition: transform 0.25s ease, border-color 0.25s ease;
        }
        .masonry-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.4);
        }
        .masonry-card img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: contain;
            background: #000;
        }
        .masonry-info { padding: 14px 16px 16px; }
        .masonry-info h5 {
            font-size: 0.98rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }
        .masonry-info p {
            font-size: 0.82rem;
            color: #a5b0c0;
            margin: 4px 0 0 0;
            line-height: 1.5;
        }
        @media (max-width: 1100px) {
            .gallery-fullscreen-wrapper.grid-mode .gallery-masonry { column-count: 3; }
        }
        @media (max-width: 820px) {
            .gallery-fullscreen-wrapper.grid-mode .gallery-masonry { column-count: 2; column-gap: 16px; padding: 24px 16px; }
            .masonry-card { margin-bottom: 16px; }
            .gallery-view-btn { padding: 8px 16px; font-size: 0.78rem; }
        }

        /* popup */
        .gallery-modal {
            position: fixed;
            inset: 0;
            background: rgba(5, 6, 8, 0.98);
            backdrop-filter: blur(25px);
            z-index: 999999;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.3s;
            box-sizing: border-box;
            padding: 20px;
        }

        .gallery-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-btn-close {
            position: absolute;
            top: 24px;
            left: 28px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 300;
            transition: all 0.2s ease;
        }

        .modal-btn-close:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.08);
        }

        .modal-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            /* Paling belakang: di bawah stage foto (100), bottom-bar (200), tombol close (300).
               Tetap terlihat & bisa diklik karena stage punya inset 100px (64px di HP). */
            z-index: 50;
            backdrop-filter: blur(10px);
            transition: all 0.2s ease;
        }

        .modal-nav-btn:hover {
            background: rgba(255, 255, 255, 0.28);
            transform: translateY(-50%) scale(1.08);
        }

        .modal-nav-btn.prev { left: 24px; }
        .modal-nav-btn.next { right: 24px; }

        .modal-stage {
            position: absolute;
            top: 20px;
            bottom: 95px;
            /* Jarak aman dari tombol nav kiri-kanan (56px + offset 24px = 80px)
               agar foto tidak pernah berada di bawah tombol */
            left: 100px;
            right: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .modal-stage img {
            width: 100%;
            height: 100%;
            max-width: 95vw;
            max-height: calc(100vh - 120px);
            object-fit: contain;
            border-radius: 12px;
            filter: drop-shadow(0 20px 50px rgba(0, 0, 0, 0.95));
            transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .modal-bottom-bar {
            position: absolute;
            bottom: 18px;
            left: 32px;
            right: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 200;
            pointer-events: none;
        }

        .modal-artwork-info {
            max-width: 320px;
            pointer-events: none;
        }

        .modal-artwork-info h3 {
            font-size: 1.45rem;
            font-weight: 700;
            margin: 0 0 3px 0;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.9);
        }

        .modal-artwork-info p {
            font-size: 0.92rem;
            color: #b0bac9;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9);
        }

        .modal-thumbs-container {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            pointer-events: auto;
            max-width: min(650px, 55vw);
            background: rgba(18, 21, 28, 0.85);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 8px 12px;
            overflow-x: auto;
            scrollbar-width: thin;
        }

        .modal-thumbs-track {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .thumb-box {
            width: 54px;
            height: 54px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            cursor: pointer;
            border: 2.5px solid transparent;
            opacity: 0.45;
            background: #151515;
            transition: all 0.2s ease;
        }

        .thumb-box:hover {
            opacity: 0.85;
            transform: scale(1.05);
        }

        .thumb-box.active {
            border-color: #ffffff;
            opacity: 1;
            transform: scale(1.08);
            box-shadow: 0 0 14px rgba(255, 255, 255, 0.35);
        }

        .thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 768px) {
            .modal-stage {
                top: 70px;
                bottom: 135px;
                /* Jarak aman dari tombol nav (44px + offset 10px = 54px) */
                left: 64px;
                right: 64px;
            }
            .modal-stage img {
                max-height: calc(100vh - 210px);
            }
            .modal-bottom-bar {
                flex-direction: column;
                align-items: flex-start;
                bottom: 12px;
                left: 16px;
                right: 16px;
            }
            .modal-artwork-info {
                margin-bottom: 10px;
                max-width: 100%;
            }
            .modal-artwork-info h3 {
                font-size: 1.15rem;
            }
            .modal-artwork-info p {
                font-size: 0.82rem;
            }
            .modal-thumbs-container {
                position: static;
                transform: none;
                max-width: 100%;
                width: 100%;
                padding: 6px 8px;
            }
            .thumb-box {
                width: 44px;
                height: 44px;
                border-radius: 8px;
            }
            .modal-nav-btn {
                width: 44px;
                height: 44px;
                background: rgba(0, 0, 0, 0.5);
            }
            .modal-nav-btn.prev { left: 10px; }
            .modal-nav-btn.next { right: 10px; }
        }

        /* LIGHT MODE */
        html[data-theme="light"] body { background-color: #f7f9fc !important; }
        html[data-theme="light"] .curved-header .badge-tag { color: var(--primary); }
        html[data-theme="light"] .curved-header h1 { color: #0f172a; }
        html[data-theme="light"] .curved-header p { color: #64748b; }
        html[data-theme="light"] .slide-card {
            background: transparent;
            border-color: rgba(15, 23, 42, 0.12);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.14);
        }
        html[data-theme="light"] .slider-btn {
            background: #ffffff;
            border-color: rgba(15, 23, 42, 0.15);
            color: #334155;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.1);
        }
        html[data-theme="light"] .slider-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
        }
        html[data-theme="light"] .gallery-modal { background: rgba(248, 250, 252, 0.97); }
        html[data-theme="light"] .modal-btn-close {
            /* Kaca translusen agar tidak terlihat memotong foto */
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-color: rgba(15, 23, 42, 0.15);
            color: #0f172a;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
        }
        html[data-theme="light"] .modal-nav-btn {
            /* Kaca translusen agar sisi foto tetap terlihat tembus */
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-color: rgba(15, 23, 42, 0.15);
            color: #0f172a;
        }
        html[data-theme="light"] .modal-stage img { filter: drop-shadow(0 20px 40px rgba(15, 23, 42, 0.25)); }
        html[data-theme="light"] .modal-artwork-info h3 { color: #0f172a; text-shadow: none; }
        html[data-theme="light"] .modal-artwork-info p { color: #64748b; text-shadow: none; }
        html[data-theme="light"] .modal-thumbs-container {
            background: rgba(255, 255, 255, 0.92);
            border-color: rgba(15, 23, 42, 0.12);
        }
        html[data-theme="light"] .thumb-box { background: #e2e8f0; }
        html[data-theme="light"] .thumb-box.active {
            border-color: var(--accent-red);
            box-shadow: 0 0 14px rgba(220, 38, 38, 0.35);
        }
        html[data-theme="light"] .gallery-view-switch {
            background: #ffffff;
            border-color: rgba(15, 23, 42, 0.15);
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.1);
        }
        html[data-theme="light"] .gallery-view-btn { color: #64748b; }
        html[data-theme="light"] .gallery-view-btn:hover { color: #0f172a; }
        html[data-theme="light"] .gallery-view-btn.active {
            background: var(--primary);
            color: #ffffff;
        }
        html[data-theme="light"] .masonry-card {
            background: #ffffff;
            border-color: rgba(15, 23, 42, 0.12);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        }
        html[data-theme="light"] .masonry-card:hover { border-color: var(--primary); }
        html[data-theme="light"] .masonry-card img { background: #e2e8f0; }
        html[data-theme="light"] .masonry-info h5 { color: #0f172a; }
        html[data-theme="light"] .masonry-info p { color: #64748b; }
    </style>
@endpush

@section('content')
    <div class="gallery-fullscreen-wrapper" id="galleryFullscreenWrap">
        <!-- header -->
        <div class="curved-header">
            <span class="badge-tag">Kumpulan Karya</span>
            <h1>Galeri Smezine</h1>
            <p>Jelajahi karya karya terbaru dari anggota kami</p>
            <div>
                <div class="gallery-view-switch" role="tablist" aria-label="Mode tampilan galeri">
                    <button type="button" class="gallery-view-btn active" id="btnGalleryDisplay" onclick="setGalleryViewMode('display')" role="tab" aria-selected="true">
                        <i class="fa-solid fa-clone"></i> Display
                    </button>
                    <button type="button" class="gallery-view-btn" id="btnGalleryGrid" onclick="setGalleryViewMode('grid')" role="tab" aria-selected="false">
                        <i class="fa-solid fa-grip"></i> Grid
                    </button>
                </div>
            </div>
        </div>

        @php
            $originalGaleris = collect($galeris);
            $totalCount = $originalGaleris->count();
            $displayGaleris = collect();

            if ($totalCount > 0) {
                // digandain biar bisa muter terus
                $targetCount = max(18, $totalCount * 3);
                $repeatCount = (int) ceil($targetCount / $totalCount);
                for ($r = 0; $r < $repeatCount; $r++) {
                    foreach ($originalGaleris as $idx => $item) {
                        $displayGaleris->push([
                            'item' => $item,
                            'original_index' => $idx
                        ]);
                    }
                }
            }
        @endphp

        <!-- galeri geser -->
        <div class="curved-gallery-wrapper">
            <div class="gallery-track" id="galleryTrack" tabindex="0"
                 data-repeat="{{ $repeatCount ?? 1 }}"
                 aria-label="Galeri karya, geser atau gunakan panah kiri kanan">
                @forelse ($displayGaleris as $data)
                    @php
                        $foto = $data['item'];
                        $origIndex = $data['original_index'];
                    @endphp
                    <div class="g-slide">
                        <div class="slide-card" onclick="openLightbox({{ $origIndex }})">
                            <img src="{{ asset('storage/' . $foto->gambar) }}" 
                                 alt="{{ $foto->judul }}" 
                                 loading="lazy"
                                 draggable="false">
                            <div class="slide-info">
                                <h5>{{ $foto->judul }}</h5>
                                <p>{{ $foto->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; color:#6c757d; padding:48px 0; width:100%;">
                        <p>Belum ada foto di galeri.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- tombol geser -->
        @if($totalCount > 0)
            <div class="slider-controls">
                <div class="slider-btn prev-btn" id="galleryPrevBtn" aria-label="Previous Slide">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <div class="slider-btn next-btn" id="galleryNextBtn" aria-label="Next Slide">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
        @endif

        <!-- mode grid -->
        <div class="gallery-masonry" id="galleryMasonry">
            @forelse ($originalGaleris as $i => $foto)
                <div class="masonry-card" onclick="openLightbox({{ $i }})">
                    <img src="{{ asset('storage/' . $foto->gambar) }}"
                         alt="{{ $foto->judul }}"
                         loading="lazy">
                    <div class="masonry-info">
                        <h5>{{ $foto->judul }}</h5>
                        @if($foto->deskripsi)
                            <p>{{ $foto->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align:center; color:#6c757d; padding:48px 0; column-span: all;">
                    <p>Belum ada foto di galeri.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- popup gambar -->
    <div id="customGalleryModal" class="gallery-modal" role="dialog" aria-modal="true">
        <button class="modal-btn-close" onclick="closeLightbox()" aria-label="Tutup Galeri">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <button class="modal-nav-btn prev" onclick="navigateLightbox(-1)" aria-label="Gambar Sebelumnya">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>

        <button class="modal-nav-btn next" onclick="navigateLightbox(1)" aria-label="Gambar Selanjutnya">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>

        <div class="modal-stage" id="modalStageArea">
            <img id="modalMainImg" src="" alt="Karya">
        </div>

        <div class="modal-bottom-bar">
            <div class="modal-artwork-info">
                <h3 id="modalTitle">Judul Karya</h3>
                <p id="modalDesc">by: Pembuat</p>
            </div>

            <div class="modal-thumbs-container">
                <div class="modal-thumbs-track" id="modalThumbsTrack">
                    @foreach ($originalGaleris as $i => $item)
                        <div class="thumb-box {{ $i === 0 ? 'active' : '' }}" onclick="selectThumb({{ $i }})" data-index="{{ $i }}">
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const galleryItems = [
            @foreach ($originalGaleris as $item)
            {
                title: @json($item->judul ?? 'Tanpa Judul'),
                desc: @json($item->deskripsi ?? ''),
                src: @json(asset('storage/' . $item->gambar))
            },
            @endforeach
        ];

        let activeIndex = 0;
        const modal = document.getElementById('customGalleryModal');
        const modalImg = document.getElementById('modalMainImg');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');

        function openLightbox(index) {
            if (!galleryItems.length) return;
            activeIndex = index;
            updateLightboxContent();
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        function navigateLightbox(direction) {
            if (!galleryItems.length) return;
            activeIndex = (activeIndex + direction + galleryItems.length) % galleryItems.length;
            updateLightboxContent();
        }

        function selectThumb(index) {
            activeIndex = index;
            updateLightboxContent();
        }

        function updateLightboxContent() {
            const currentItem = galleryItems[activeIndex];

            modalImg.style.opacity = '0';
            modalImg.style.transform = 'scale(0.97)';

            setTimeout(() => {
                modalImg.src = currentItem.src;
                modalImg.alt = currentItem.title;
                modalTitle.textContent = currentItem.title;
                modalDesc.textContent = currentItem.desc;

                modalImg.style.opacity = '1';
                modalImg.style.transform = 'scale(1)';
            }, 120);

            const thumbBoxes = document.querySelectorAll('.thumb-box');
            thumbBoxes.forEach((thumb, idx) => {
                if (idx === activeIndex) {
                    thumb.classList.add('active');
                    thumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                } else {
                    thumb.classList.remove('active');
                }
            });
        }

        document.addEventListener('keydown', function (e) {
            if (!modal.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') navigateLightbox(-1);
            if (e.key === 'ArrowRight') navigateLightbox(1);
        });

        let touchStartX = 0;
        const modalStageArea = document.getElementById('modalStageArea');
        if (modalStageArea) {
            modalStageArea.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            modalStageArea.addEventListener('touchend', e => {
                const touchEndX = e.changedTouches[0].screenX;
                if (touchStartX - touchEndX > 45) navigateLightbox(1);
                if (touchEndX - touchStartX > 45) navigateLightbox(-1);
            }, { passive: true });
        }

        // geser thumbnail pakai mouse
        const thumbsContainer = document.querySelector('.modal-thumbs-container');
        if (thumbsContainer) {
            thumbsContainer.style.cursor = 'grab';
            let tDown = false;
            let tMoved = false;
            let tX = 0;
            let tScroll = 0;
            thumbsContainer.addEventListener('pointerdown', e => {
                if (e.pointerType !== 'mouse' || e.button !== 0) return;
                tDown = true;
                tMoved = false;
                tX = e.clientX;
                tScroll = thumbsContainer.scrollLeft;
                thumbsContainer.style.cursor = 'grabbing';
            });
            thumbsContainer.addEventListener('pointermove', e => {
                if (!tDown) return;
                const dx = e.clientX - tX;
                if (Math.abs(dx) > 6) tMoved = true;
                if (tMoved) thumbsContainer.scrollLeft = tScroll - dx;
            });
            ['pointerup', 'pointercancel', 'pointerleave'].forEach(evt => {
                thumbsContainer.addEventListener(evt, () => {
                    tDown = false;
                    thumbsContainer.style.cursor = 'grab';
                    setTimeout(() => { tMoved = false; }, 50);
                });
            });
            thumbsContainer.addEventListener('click', e => {
                if (tMoved) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);
        }

        // ganti display / grid, pilihannya disimpan
        function setGalleryViewMode(mode) {
            const wrap = document.getElementById('galleryFullscreenWrap');
            const btnDisplay = document.getElementById('btnGalleryDisplay');
            const btnGrid = document.getElementById('btnGalleryGrid');
            const isGrid = mode === 'grid';
            if (wrap) wrap.classList.toggle('grid-mode', isGrid);
            if (btnDisplay) {
                btnDisplay.classList.toggle('active', !isGrid);
                btnDisplay.setAttribute('aria-selected', String(!isGrid));
            }
            if (btnGrid) {
                btnGrid.classList.toggle('active', isGrid);
                btnGrid.setAttribute('aria-selected', String(isGrid));
            }
            try { localStorage.setItem('smezine-gallery-view', isGrid ? 'grid' : 'display'); } catch (e) {}
        }

        document.addEventListener('DOMContentLoaded', function () {
            try {
                if (localStorage.getItem('smezine-gallery-view') === 'grid') {
                    setGalleryViewMode('grid');
                }
            } catch (e) {}
        });

        function isGalleryGridMode() {
            const wrap = document.getElementById('galleryFullscreenWrap');
            return !!(wrap && wrap.classList.contains('grid-mode'));
        }

        // logic geser galeri
        document.addEventListener('DOMContentLoaded', function () {
            const track = document.getElementById('galleryTrack');
            if (!track) return;
            const slides = Array.from(track.querySelectorAll('.g-slide'));
            if (!slides.length) return;

            const GAP = 26;
            const repeat = Math.max(1, parseInt(track.dataset.repeat || '1', 10));

            function cardStep() {
                const first = slides[0];
                return (first ? first.offsetWidth : 270) + GAP;
            }

            // efek lengkung
            let rafPending = false;
            function applyCurve() {
                rafPending = false;
                const center = track.scrollLeft + track.clientWidth / 2;
                const w = slides[0] ? slides[0].offsetWidth : 270;
                slides.forEach((slide) => {
                    const card = slide.querySelector('.slide-card');
                    if (!card) return;
                    // biar tetap mencekung
                    const progress = (center - (slide.offsetLeft + slide.offsetWidth / 2)) / w;
                    const abs = Math.min(Math.abs(progress), 4);
                    const rotateY = Math.max(-45, Math.min(45, progress * 13.5));
                    // dilunakin biar gak kepotong
                    const translateZ = Math.min(120, Math.pow(abs, 1.2) * 35);
                    const scale = 1 + Math.pow(abs, 1.15) * 0.022;
                    const translateY = Math.pow(abs, 1.25) * 3;
                    card.style.transform = `perspective(1300px) translateY(${translateY}px) translateZ(${translateZ}px) rotateY(${rotateY}deg) scale(${scale})`;
                    slide.style.zIndex = Math.round(50 + abs * 10);
                });
            }
            function requestCurve() {
                if (!rafPending) {
                    rafPending = true;
                    requestAnimationFrame(applyCurve);
                }
            }

            // biar muter terus
            function wrapAround() {
                if (repeat < 2) return;
                const unit = track.scrollWidth / repeat;
                if (!unit) return;
                const midIndex = Math.floor(repeat / 2);
                const midStart = unit * midIndex;
                const midEnd = midStart + unit;
                const center = track.scrollLeft + track.clientWidth / 2;
                if (center < midStart) {
                    track.scrollLeft += unit;
                } else if (center > midEnd) {
                    track.scrollLeft -= unit;
                }
            }

            track.addEventListener('scroll', function () {
                wrapAround();
                requestCurve();
            }, { passive: true });

            // geser pakai mouse
            let isDown = false;
            let dragged = false;
            let startX = 0;
            let startScroll = 0;

            track.querySelectorAll('img').forEach(function (img) {
                img.setAttribute('draggable', 'false');
                img.addEventListener('dragstart', function (e) { e.preventDefault(); });
            });

            track.addEventListener('pointerdown', function (e) {
                if (e.pointerType !== 'mouse' || e.button !== 0) return;
                stopGlide(); // stop biar drag manual yang jalan
                isDown = true;
                dragged = false;
                startX = e.clientX;
                startScroll = track.scrollLeft;
                track.classList.add('is-dragging');
            });
            track.addEventListener('pointermove', function (e) {
                if (!isDown) return;
                const dx = e.clientX - startX;
                if (Math.abs(dx) > 6) dragged = true;
                if (dragged) track.scrollLeft = startScroll - dx;
            });
            ['pointerup', 'pointercancel', 'pointerleave'].forEach(function (evt) {
                track.addEventListener(evt, function () {
                    isDown = false;
                    track.classList.remove('is-dragging');
                    setTimeout(function () { dragged = false; }, 50);
                });
            });
            // habis drag jangan buka gambar
            track.addEventListener('click', function (e) {
                if (dragged) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);

            // scroll bawah jadi geser samping
            track.addEventListener('wheel', function (e) {
                if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return;
                const maxLeft = track.scrollWidth - track.clientWidth - 10;
                const isAtEnd = track.scrollLeft >= maxLeft;
                const isAtStart = track.scrollLeft <= 10;
                if ((e.deltaY > 0 && !isAtEnd) || (e.deltaY < 0 && !isAtStart)) {
                    e.preventDefault();
                    track.scrollBy({ left: e.deltaY * 2.5, behavior: 'auto' });
                }
            }, { passive: false });
            // tombol panah, ketuk = 1 kartu, tahan = ngalir
            let holding = 0; // arah tombol yg ditahan
            let vel = 0;
            let rafId = null;
            const MAX_VEL = 15;
            function tick() {
                if (holding !== 0) {
                    vel += (holding * MAX_VEL - vel) * 0.12; // gas halus
                } else {
                    vel *= 0.94; // rem pelan
                    if (Math.abs(vel) < 0.3) {
                        vel = 0;
                        rafId = null;
                        return;
                    }
                }
                track.scrollLeft += vel;
                rafId = requestAnimationFrame(tick);
            }
            function ensureTick() {
                if (rafId === null) rafId = requestAnimationFrame(tick);
            }
            function stopGlide() {
                holding = 0;
                vel = 0;
                if (rafId !== null) {
                    cancelAnimationFrame(rafId);
                    rafId = null;
                }
            }
            function flick(dir) {
                // flick jari
                holding = 0;
                vel = dir * 17;
                ensureTick();
            }
            function stepOnce(dir) {
                track.scrollBy({ left: dir * cardStep(), behavior: 'smooth' });
            }
            function setupHoldButton(btn, dir) {
                if (!btn) return;
                let pressedAt = 0;
                const TAP_MS = 220;
                const press = (e) => {
                    if (e.pointerType === 'mouse' && e.button !== 0) return;
                    e.preventDefault();
                    pressedAt = performance.now();
                    holding = dir;
                    ensureTick();
                };
                const release = () => {
                    if (holding !== dir) return;
                    holding = 0;
                    if (performance.now() - pressedAt < TAP_MS) {
                        // ketuk = geser 1 kartu
                        stopGlide();
                        stepOnce(dir);
                    }
                    // tahan lama biarin momentum
                };
                btn.setAttribute('tabindex', '0');
                btn.setAttribute('role', 'button');
                btn.addEventListener('pointerdown', press);
                window.addEventListener('pointerup', release);
                btn.addEventListener('pointercancel', release);
                btn.addEventListener('pointerleave', release);
                btn.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        flick(dir);
                    }
                });
            }
            setupHoldButton(document.getElementById('galleryPrevBtn'), -1);
            setupHoldButton(document.getElementById('galleryNextBtn'), 1);

            // keyboard kiri-kanan
            track.addEventListener('keydown', function (e) {
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    flick(-1);
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    flick(1);
                }
            });
            document.addEventListener('keydown', function (e) {
                if (modal.classList.contains('active')) return;
                if (isGalleryGridMode()) return; // mode grid biarin scroll biasa
                if (document.activeElement === track) return;
                if (e.key === 'ArrowLeft') flick(-1);
                else if (e.key === 'ArrowRight') flick(1);
            });

            // mulai dari tengah biar bisa geser dua arah
            function jumpToMiddle() {
                if (repeat < 2) {
                    applyCurve();
                    return;
                }
                const unit = track.scrollWidth / repeat;
                const midIndex = Math.floor(repeat / 2);
                track.scrollLeft = unit * midIndex + unit / 2 - track.clientWidth / 2;
                applyCurve();
            }
            jumpToMiddle();
            window.addEventListener('load', jumpToMiddle);
            window.addEventListener('resize', requestCurve);
        });
    </script>
@endpush