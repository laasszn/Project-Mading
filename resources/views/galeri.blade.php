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

        /* 1. LAYOUT GALERI FULL SCREEN */
        .gallery-fullscreen-wrapper {
            min-height: calc(100vh - 75px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 25px 0 20px 0;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        /* Header Layout */
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
            overflow: hidden;
            padding: 40px 0;
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
            padding: 60px 12px;
            box-sizing: border-box;
            cursor: grab;
            scrollbar-width: none;
            -ms-overflow-style: none;
            -webkit-overflow-scrolling: touch;
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
            background: #14161d;
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

        /* ========================================================
           LIGHTBOX MODAL FULL SCREEN
           ======================================================== */
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
            z-index: 300;
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
            left: 30px;
            right: 30px;
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
                left: 10px;
                right: 10px;
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
            background: #ffffff;
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
            background: #ffffff;
            border-color: rgba(15, 23, 42, 0.15);
            color: #0f172a;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
        }
        html[data-theme="light"] .modal-nav-btn {
            background: #ffffff;
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
    </style>
@endpush

@section('content')
    <div class="gallery-fullscreen-wrapper">
        <!-- Header Section -->
        <div class="curved-header">
            <span class="badge-tag">Kumpulan Karya</span>
            <h1>Galeri Smezine</h1>
            <p>Jelajahi karya karya terbaru dari anggota kami</p>
        </div>

        @php
            $originalGaleris = collect($galeris);
            $totalCount = $originalGaleris->count();
            $displayGaleris = collect();

            if ($totalCount > 0) {
                // Buffer secukupnya agar track selalu memiliki kartu di kedua sisi (untuk putaran wrap)
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

        <!-- 3D Curved Arc Carousel Section (drag mouse / swipe HP / tombol / keyboard) -->
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

        <!-- Tombol Navigasi Carousel Utama -->
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
    </div>

    <!-- Modal Fullscreen -->
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

        // Drag strip thumbnail lightbox dengan mouse (seperti card division)
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

        // ========================================================
        // TRACK NATIVE ala division section:
        // drag mouse (klik-tahan-geser), swipe HP (native), tombol,
        // wheel vertikal -> horizontal, keyboard, efek 3D melengkung,
        // dan putaran tanpa ujung (wrap antar salinan isi yang berulang)
        // ========================================================
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

            // --- Efek 3D melengkung: dihitung dari jarak kartu ke tengah layar ---
            let rafPending = false;
            function applyCurve() {
                rafPending = false;
                const center = track.scrollLeft + track.clientWidth / 2;
                const w = slides[0] ? slides[0].offsetWidth : 270;
                slides.forEach((slide) => {
                    const card = slide.querySelector('.slide-card');
                    if (!card) return;
                    // Tanda progress disamakan dengan Swiper: kartu di kanan tengah = negatif,
                    // agar lengkungan tetap mencekung (mendalam) seperti semula
                    const progress = (center - (slide.offsetLeft + slide.offsetWidth / 2)) / w;
                    const abs = Math.min(Math.abs(progress), 4);
                    const rotateY = Math.max(-45, Math.min(45, progress * 13.5));
                    const translateZ = Math.min(220, Math.pow(abs, 1.2) * 35);
                    const scale = 1 + Math.pow(abs, 1.15) * 0.04;
                    const translateY = Math.pow(abs, 1.25) * 4.5;
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

            // --- Putaran tanpa ujung: jaga posisi di salinan tengah ---
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

            // --- Drag dengan mouse (klik-tahan-geser), seperti card division ---
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
                stopGlide(); // hentikan luncuran tombol agar drag manual yang pegang kendali
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
            // bedakan klik vs drag: habis drag jangan buka lightbox
            track.addEventListener('click', function (e) {
                if (dragged) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);

            // --- Wheel vertikal -> horizontal saat masih bisa geser (seperti division) ---
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
            // --- Tombol panah: fisika momentum seperti slide manual ---
            // Ketuk cepat = meluncur halus 1 kartu; tahan = meluncur mengalir;
            // lepas = melambat sendiri seperti melepas drag jari.
            let holding = 0; // -1 | 0 | 1 : arah tombol yang sedang ditahan
            let vel = 0; // px per frame
            let rafId = null;
            const MAX_VEL = 15;
            function tick() {
                if (holding !== 0) {
                    vel += (holding * MAX_VEL - vel) * 0.12; // akselerasi halus
                } else {
                    vel *= 0.94; // deselerasi (momentum)
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
                // sentakan seperti flick jari: meluncur ~1 kartu lalu berhenti sendiri
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
                        // ketuk cepat = geser halus 1 kartu (seperti klik biasa)
                        stopGlide();
                        stepOnce(dir);
                    }
                    // kalau tahan lama: biarkan momentum yang menyelesaikan
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

            // --- Keyboard: panah kiri/kanan = flick seperti slide manual ---
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
                if (document.activeElement === track) return; // sudah ditangani di atas
                if (e.key === 'ArrowLeft') flick(-1);
                else if (e.key === 'ArrowRight') flick(1);
            });

            // --- Posisi awal: tengah salinan tengah agar bisa geser dua arah ---
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