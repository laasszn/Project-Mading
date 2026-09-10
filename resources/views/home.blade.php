@extends('layouts.app')

@section('title', 'Beranda - Mading SMK N 1 Dukuhturi')

@push('styles')
    <style>
        /* karya di home */
        .home-karya-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 21px;
            max-width: 1040px;
            margin: 0 auto 60px;
        }
        .home-karya-card {
            position: relative;
            border-radius: 13px;
            overflow: hidden;
            background: #1e1e1e;
            border: 1px solid #333;
            aspect-ratio: 4 / 3;
            display: block;
            text-decoration: none;
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .home-karya-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.6);
        }
        .home-karya-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            filter: brightness(0.88);
            transition: transform 0.5s ease, filter 0.3s ease;
        }
        .home-karya-card:hover img {
            transform: scale(1.05);
            filter: brightness(1);
        }
        .home-karya-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.55) 38%, transparent 68%);
            z-index: 1;
            pointer-events: none;
        }
        .home-karya-text {
            position: absolute;
            bottom: 14px;
            left: 14px;
            right: 14px;
            z-index: 2;
            text-shadow: 0 2px 8px rgba(0,0,0,0.8);
        }
        .home-karya-text h5 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.32;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .home-karya-text p {
            margin-top: 4px;
            font-size: 0.78rem;
            color: #cccccc;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            opacity: 0.92;
        }
        @media (max-width: 992px) {
            .home-karya-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .home-karya-grid { grid-template-columns: 1fr; }
            .home-karya-card { aspect-ratio: 16 / 10; }
        }

        /* light mode */
        html[data-theme="light"] .home-karya-card {
            background: #ffffff;
            border-color: rgba(15, 23, 42, 0.12);
            box-shadow: 0 6px 22px rgba(15, 23, 42, 0.1);
        }
        html[data-theme="light"] .home-karya-card img { filter: none; }
        html[data-theme="light"] .home-karya-card:hover { border-color: var(--accent-red); }
    </style>
@endpush

@section('content')
    <header class="hero">
        @if(isset($sliderBeritas) && $sliderBeritas->isNotEmpty())
            @foreach ($sliderBeritas as $index => $item)
                <div class="slide {{ $index === 0 ? 'active' : '' }}">
                    <img
                        src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
                        alt="{{ $item->judul }}"
                    />
                    <div class="hero-content">
                        <span class="badge">{{ $index===0?'Terbaru':'Berita' }}</span>
                        <h1>{{ Str::limit($item->judul, 65) }}</h1>
                        <p>
                            {{ Str::limit($item->deskripsi, 110) }}
                        </p>
                        <a href="{{ route('berita.show', $item->id) }}" class="btn-join"
                            >Baca Selengkapnya</a
                        >
                    </div>
                </div>
            @endforeach
            <div class="dots">
                @foreach($sliderBeritas as $index => $item)
                    <div class="dot {{ $index===0?'active':'' }}"></div>
                @endforeach
            </div>
        @else
            <div class="slide active">
                <img src="{{ asset('image/ps.jpg') }}" alt="Hero">
                <div class="hero-content">
                    <span class="badge">Featured</span>
                    <h1>Pameran Seni Digital 2026</h1>
                    <p>Karya Fajar Tirta Hidayat memenangkan kompetisi nasional.</p>
                    <a href="{{ url('/berita') }}" class="btn-join">Baca Selengkapnya</a>
                </div>
            </div>
            <div class="dots">
                <div class="dot active"></div>
            </div>
        @endif
    </header>

    <div class="container">
        {{-- berita terbaru --}}
        <div class="section-header-row">
            <div class="section-title" style="margin-bottom:0">
                <h2>Berita Terbaru</h2>
                <p style="margin:0; color: var(--text-muted); font-size:0.9rem;">Informasi terbaru seputar kegiatan sekolah.</p>
            </div>
            <a href="{{ route('berita.index') }}" style="color: var(--primary); font-weight:600; white-space:nowrap;">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @php
            $beritasHome = $latestBeritas ?? $latestBerita ?? collect();
        @endphp

        @if($beritasHome->count())
            <div class="home-latest-grid">
                @foreach ($beritasHome as $berita)
                    <a href="{{ route('berita.show', $berita->id) }}" class="home-news-card">
                        <div class="thumb">
                            <img src="{{ $berita->gambar ? asset('storage/'.$berita->gambar) : 'https://via.placeholder.com/400x220?text=No+Image' }}" alt="{{ $berita->judul }}">
                        </div>
                        <div class="body">
                            <span class="meta">
                                <i class="fa-regular fa-clock"></i> {{ $berita->waktu_tampil }}
                            </span>
                            <h3>{{ Str::limit($berita->judul, 55) }}</h3>
                            <p>{{ Str::limit($berita->deskripsi, 80) }}</p>
                            <div class="foot">
                                <span style="color:#aaa; font-size:0.75rem;">Berita</span>
                                <span class="read">Baca <i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p style="color: #aaa; text-align: center; padding: 40px 0;">Belum ada berita yang diterbitkan.</p>
        @endif

        {{-- karya terbaru --}}
        <div class="section-header-row" style="margin-top: 48px;">
            <div class="section-title" style="margin-bottom:0">
                <h2>Karya Terbaru</h2>
                <p style="margin:0; color: var(--text-muted); font-size:0.9rem;">Kumpulan karya dan dokumentasi terbaru dari galeri.</p>
            </div>
            <a href="{{ route('galeri') }}" style="color: var(--primary); font-weight:600; white-space:nowrap;">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @php
            $galerisHome = $latestGaleris ?? collect();
        @endphp

        @if($galerisHome->count())
            <div class="home-karya-grid">
                @foreach ($galerisHome as $foto)
                    <a href="{{ route('galeri') }}" class="home-karya-card" title="{{ $foto->judul }}">
                        <img src="{{ $foto->gambar ? asset('storage/' . $foto->gambar) : 'https://via.placeholder.com/400x300?text=No+Image' }}" alt="{{ $foto->judul }}" loading="lazy">
                        <div class="home-karya-text">
                            <h5>{{ $foto->judul }}</h5>
                            @if($foto->deskripsi)
                                <p>{{ Str::limit($foto->deskripsi, 80) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p style="color: #aaa; text-align: center; padding: 30px 0 50px;">Belum ada karya di galeri.</p>
        @endif
    </div>
@endsection
