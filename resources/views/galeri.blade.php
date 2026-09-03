@extends('layouts.app')

@section('title', 'Galeri Smezine - Dark Mode')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

    <style>
        body {
            background-image: none !important;
            background-color: #121212 !important;
            font-family: "Poppins", sans-serif;
            opacity: 1 !important;
            transform: none !important;
        }
        .page-header h1 {
            color: #ffffff;
            font-weight: 700;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }
        .page-header p {
            color: #a0a0a0;
        }
        .masonry {
            column-count: 4;
            column-gap: 20px;
        }
        @media (max-width: 992px) { .masonry { column-count: 3; } }
        @media (max-width: 768px) { .masonry { column-count: 2; } }
        @media (max-width: 576px) { .masonry { column-count: 1; } }
        .masonry-item { break-inside: avoid; margin-bottom: 20px; }
        .gallery-card {
            position: relative; border-radius: 12px; overflow: hidden;
            background-color: #1e1e1e; border: 1px solid #333;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .gallery-card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0, 0, 0, 0.6); border-color: #0d6efd; }
        .gallery-card img { width: 100%; display: block; filter: brightness(0.9); transition: transform 0.5s ease, filter 0.3s ease; }
        .gallery-card:hover img { transform: scale(1.05); filter: brightness(1); }
        .gallery-card::after {
            content: ""; position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.6) 40%, transparent 100%); z-index: 1; pointer-events: none;
        }
        .gallery-text { position: absolute; bottom: 20px; left: 20px; right: 20px; z-index: 2; text-shadow: 0 2px 5px rgba(0, 0, 0, 0.8); }
        .gallery-text h5 { margin: 0; font-size: 1.1rem; font-weight: 600; color: #fff; }
        .gallery-text p { margin-top: 5px; font-size: 0.85rem; color: #cccccc; opacity: 0.9; line-height: 1.4; }
        a { text-decoration: none; }
        .f-slide { padding: 0 !important; margin: 0 !important; }
        .fancybox__content { height: 100% !important; width: 100% !important; display: flex; align-items: center; justify-content: center; }
        .fancybox__image { max-width: 90% !important; max-height: 85% !important; object-fit: contain !important; padding: 0 !important; }
        .f-toolbar { position: absolute; top: 0; left: 0; right: 0; z-index: 20; background: linear-gradient(180deg, rgba(0, 0, 0, 0.6) 0%, transparent 100%) !important; border: none; }
        .f-caption { position: absolute !important; bottom: 0 !important; left: 0 !important; right: 0 !important; z-index: 20; background: linear-gradient(0deg, rgba(0, 0, 0, 0.8) 0%, transparent 100%) !important; padding-bottom: 20px; text-align: center; }
        body.fancybox-active { overflow: hidden !important; }

        /* Tombol close manual di pojok kanan atas lightbox */
        .fancybox-close-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            border: none;
            font-size: 1.4rem;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 100010;
            transition: 0.2s;
        }
        .fancybox-close-btn:hover { background: #ff4d4d; transform: rotate(90deg); }
        .fancybox-close-btn.active { display: flex; }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <div class="page-header text-center mb-5">
            <h1 class="mb-3">Galeri Smezine</h1>
            <p class="lead">
                Kumpulan karya dan dokumentasi kegiatan ekstrakurikuler mading
            </p>
        </div>

        <div id="gallery" class="masonry">
            @forelse ($galeris as $foto)
                <div class="masonry-item">
                    <a href="{{ asset('storage/' . $foto->gambar) }}"
                       data-fancybox="gallery"
                       data-caption="<h4>{{ $foto->judul }}</h4><p>{{ $foto->deskripsi }}</p>">
                        <div class="gallery-card">
                            <img src="{{ asset('storage/' . $foto->gambar) }}" alt="{{ $foto->judul }}" loading="lazy">
                            <div class="gallery-text">
                                <h5>{{ $foto->judul }}</h5>
                                <p>{{ $foto->deskripsi }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p style="color: #aaa; text-align: center;">Belum ada foto di galeri.</p>
            @endforelse
        </div>
    </div>

    <!-- Tombol close manual, ikut nempel selama lightbox terbuka -->
    <button type="button" class="fancybox-close-btn" id="fancyboxCloseBtn" aria-label="Tutup">
        &times;
    </button>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        const closeBtn = document.getElementById("fancyboxCloseBtn");

        Fancybox.bind("[data-fancybox]", {
            Images: { fit: "contain", zoom: true },
            Panzoom: { maxScale: 2 },
            Thumbs: false,
            Toolbar: { display: { left: [], middle: [], right: ["close"] } },
            showClass: "f-fadeSlowIn",
            hideClass: "f-fadeSlowOut",
            on: {
                ready: () => closeBtn.classList.add("active"),
                destroy: () => closeBtn.classList.remove("active"),
            },
        });

        closeBtn.addEventListener("click", () => Fancybox.close());
    </script>
@endpush
