@extends('layouts.app')

@section('title', 'Galeri Smezine - Curved 3D')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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
            overflow: visible;
            padding: 40px 0;
        }

        .swiper-curved {
            width: 100%;
            overflow: visible !important;
            padding: 60px 0 !important;
        }

        .swiper-wrapper {
            will-change: transform;
            transform-style: preserve-3d;
        }

        /* Wadah Slide (dikelola oleh internal Swiper untuk posisi loop) */
        .swiper-curved .swiper-slide {
            width: 270px;
            height: 380px;
            position: relative;
            cursor: pointer;
            overflow: visible !important;
            background: transparent !important;
            border: none !important;
        }

        @media (max-width: 768px) {
            .gallery-fullscreen-wrapper {
                min-height: auto;
                padding: 20px 0;
            }
            .swiper-curved .swiper-slide {
                width: 195px;
                height: 275px;
            }
        }

        /* Kartu Fisik yang diberi efek 3D (tidak mengganggu rel Swiper) */
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
                // Buffer secukupnya agar track Swiper selalu memiliki kartu di kedua sisi
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

        <!-- 3D Curved Arc Carousel Section -->
        <div class="curved-gallery-wrapper">
            <div class="swiper swiper-curved">
                <div class="swiper-wrapper">
                    @forelse ($displayGaleris as $data)
                        @php
                            $foto = $data['item'];
                            $origIndex = $data['original_index'];
                        @endphp
                        <div class="swiper-slide">
                            <div class="slide-card" onclick="openLightbox({{ $origIndex }})">
                                <img src="{{ asset('storage/' . $foto->gambar) }}" 
                                     alt="{{ $foto->judul }}" 
                                     loading="lazy">
                                <div class="slide-info">
                                    <h5>{{ $foto->judul }}</h5>
                                    <p>{{ $foto->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-secondary py-5 w-100">
                            <p>Belum ada foto di galeri.</p>
                        </div>
                    @endforelse
                </div>
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
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

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

        // ========================================================
        // INISIALISASI SWIPER DENGAN TRUE INFINITE FLOW (MENGALIR TANPA LONCAT)
        // ========================================================
        document.addEventListener('DOMContentLoaded', function () {
            let isFastForwarding = false;
            let activeDirection = null;
            let holdTimer = null;

            const swiper = new Swiper('.swiper-curved', {
                slidesPerView: 'auto',
                centeredSlides: true,
                spaceBetween: 26,
                grabCursor: true,
                loop: true,
                // Parameter Swiper 11 murni tanpa opsi usang
                loopAdditionalSlides: 8,
                loopPreventsSliding: false,
                watchSlidesProgress: true,
                roundLengths: true,
                speed: 600,
                touchRatio: 1.2,
                resistanceRatio: 0.85,
                on: {
                    progress: function (s) {
                        s.slides.forEach((slide) => {
                            // Terapkan efek 3D ke elemen DALAM (.slide-card),
                            // BUKAN ke .swiper-slide agar posisi loop Swiper tidak tertimpa
                            const card = slide.querySelector('.slide-card');
                            if (!card) return;

                            const progress = slide.progress;
                            const absProgress = Math.abs(progress);

                            const rotateY = progress * 13.5;
                            const translateZ = Math.min(220, Math.pow(absProgress, 1.2) * 35);
                            const scale = 1 + Math.pow(absProgress, 1.15) * 0.04;
                            const translateY = Math.pow(absProgress, 1.25) * 4.5;

                            card.style.transform = `perspective(1300px) translateY(${translateY}px) translateZ(${translateZ}px) rotateY(${rotateY}deg) scale(${scale})`;
                            slide.style.zIndex = Math.round(50 + absProgress * 10);
                        });
                    },
                    setTransition: function (s, duration) {
                        const timing = isFastForwarding ? 'linear' : 'cubic-bezier(0.22, 1, 0.36, 1)';

                        s.slides.forEach((slide) => {
                            const card = slide.querySelector('.slide-card');
                            if (card) {
                                card.style.transition = `${duration}ms ${timing}`;
                            }
                        });
                        if (s.wrapperEl) {
                            s.wrapperEl.style.transitionTimingFunction = timing;
                        }
                    }
                }
            });

            // ========================================================
            // FAST-FORWARD BERANTAI (CHAINED) TANPA RESET ATAU LONCAT
            // ========================================================
            function triggerFastStep() {
                if (!isFastForwarding) return;
                if (activeDirection === 'next') {
                    swiper.slideNext(160, false);
                } else {
                    swiper.slidePrev(160, false);
                }
            }

            // Tiap kali 1 kartu selesai bergeser, langsung sambung ke kartu berikutnya
            swiper.on('transitionEnd', function () {
                if (isFastForwarding) {
                    triggerFastStep();
                }
            });

            function setupSmoothHoldFastForward(btn, direction) {
                if (!btn) return;

                const startHold = (e) => {
                    if (e.button !== undefined && e.button !== 0) return;
                    e.preventDefault();

                    activeDirection = direction;

                    // Geser 1 kali dengan animasi halus saat awal ditekan
                    if (direction === 'next') swiper.slideNext(550);
                    else swiper.slidePrev(550);

                    // Jika ditekan > 240ms, aktifkan fast forward linear yang mengalir
                    holdTimer = setTimeout(() => {
                        isFastForwarding = true;
                        triggerFastStep();
                    }, 240);
                };

                const stopHold = () => {
                    clearTimeout(holdTimer);

                    if (isFastForwarding) {
                        isFastForwarding = false;
                        activeDirection = null;
                        // Biarkan kartu yang sedang berputar berhenti secara alami di posisinya
                        // (TIDAK memanggil slideTo / slideToClosest agar tidak memicu reset loncat)
                    }
                };

                btn.addEventListener('mousedown', startHold);
                btn.addEventListener('mouseup', stopHold);
                btn.addEventListener('mouseleave', stopHold);

                btn.addEventListener('touchstart', startHold, { passive: false });
                btn.addEventListener('touchend', stopHold);
                btn.addEventListener('touchcancel', stopHold);
            }

            setupSmoothHoldFastForward(document.getElementById('galleryPrevBtn'), 'prev');
            setupSmoothHoldFastForward(document.getElementById('galleryNextBtn'), 'next');
        });
    </script>
@endpush