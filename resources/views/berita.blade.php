@extends('layouts.app')

@section('title', 'Berita - Mading SMK N 1 Dukuhturi')

@push('styles')
    <style>
        body { background-image: none !important; background-color: #121212 !important; opacity: 1 !important; transform: none !important; }

        .berita-hero-header { text-align: center; margin-bottom: 40px; }
        .berita-hero-header h1 {
            color: #fff; font-weight: 700; font-size: 2.2rem; margin-bottom: 10px;
        }
        .berita-hero-header p { color: #999; }

        /* Golden ratio φ = 1.618 — semua ukuran turunan φ */
        /* Featured article besar di atas — grid 1.618:1 (golden) */
        .featured-article {
            display: grid;
            grid-template-columns: 1.618fr 1fr; /* φ : 1 golden */
            gap: 0;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 13px; /* 8*φ */
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            margin-bottom: 34px; /* 21*φ ≈34 */
            max-width: 1040px;
            margin-left: auto;
            margin-right: auto;
            transition: border-color 0.3s ease, transform 0.3s ease;
        }
        .featured-article:hover { border-color: var(--primary); transform: translateY(-3px); }
        .featured-article .img-wrap {
            position: relative;
            aspect-ratio: 1.618 / 1; /* golden rectangle anti crop */
            overflow: hidden;
            background: #0f0f0f;
        }
        .featured-article .img-wrap img { width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; }
        .featured-tag {
            position: absolute; top: 13px; left: 13px; /* 8*φ */
            background: var(--primary); color: #fff; font-size: 0.6875rem; font-weight: 700;
            padding: 4px 12px; border-radius: 30px; text-transform: uppercase; letter-spacing: 0.5px;
            z-index: 2;
        }
        .featured-body { padding: 21px 21px 21px 34px; /* 13*φ=21, 21*φ=34 */ display: flex; flex-direction: column; justify-content: center; gap: 8px; }
        .featured-body .meta { color: #888; font-size: 0.75rem; margin-bottom: 4px; display: flex; align-items: center; gap: 6px; }
        .featured-body h2 { color: #fff; font-size: 1.45rem; /* dikecilin dari 1.6 tapi ratio φ ke body */ font-weight: 700; line-height: 1.32; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .featured-body p { color: #b0b0b0; line-height: 1.618; /* φ */ margin-bottom: 14px; font-size: 0.875rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .featured-body .read-more { color: var(--primary); font-weight: 600; font-size: 0.8125rem; display: inline-flex; align-items: center; gap: 6px; }
        .featured-article:hover .read-more { gap: 10px; }

        /* Grid berita lainnya — golden spacing 21px */
        .berita-section-title { color: #fff; font-size: 1.18rem; font-weight: 700; margin-bottom: 21px; border-left: 4px solid var(--primary); padding-left: 13px; max-width: 1040px; margin-left: auto; margin-right: auto; }
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); /* 260 ≈ 160*φ, lebih kecil proporsional */
            gap: 21px; /* 13*φ */
            max-width: 1040px;
            margin: 0 auto;
        }
        .news-card {
            background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 13px; overflow: hidden;
            text-decoration: none; color: inherit; display: flex; flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 14px 28px rgba(0,0,0,0.5); border-color: var(--primary); }
        .news-card .thumb {
            aspect-ratio: 1.618 / 1; /* golden, bukan fixed 190px biar tidak ke-crop */
            overflow: hidden;
            background: #0f0f0f;
        }
        .news-card .thumb img { width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform 0.5s ease; display: block; }
        .news-card:hover .thumb img { transform: scale(1.05); }
        .news-card .body { padding: 13px 13px 14px; /* 8*φ */ flex-grow: 1; display: flex; flex-direction: column; gap: 4px; }
        .news-card .meta { color: #777; font-size: 0.6875rem; margin-bottom: 2px; display: flex; align-items: center; gap: 5px; }
        .news-card h3 { color: #fff; font-size: 0.9375rem; font-weight: 700; line-height: 1.35; margin-bottom: 2px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: calc(1.35em * 2); }
        .news-card p { color: #999; font-size: 0.8125rem; line-height: 1.6; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: calc(1.6em * 2); }

        .empty-state { text-align: center; color: #888; padding: 60px 20px; }

        @media (max-width: 992px) {
            .featured-article { grid-template-columns: 1.2fr 1fr; }
            .news-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .featured-article { grid-template-columns: 1fr; }
            .featured-article .img-wrap { aspect-ratio: 1.618 / 1; }
            .featured-body { padding: 18px; }
            .news-grid { grid-template-columns: 1fr; }
        }
    </style>
@endpush

@section('content')
    <div class="ambient-bg">
        <div class="light-blob-1"></div>
        <div class="light-blob-2"></div>
    </div>

    <div class="container" style="padding-top: 40px; padding-bottom: 80px;">
        <div class="berita-hero-header">
            <h1>Berita & Artikel</h1>
            <p>Update terbaru seputar kegiatan Ekstrakurikuler Mading Smezine.</p>
        </div>

        @if($beritas->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-newspaper" style="font-size: 2.5rem; margin-bottom: 15px; display: block;"></i>
                Belum ada berita yang diterbitkan.
            </div>
        @else
            {{-- Berita paling baru ditampilkan besar sebagai headline --}}
            @php $headline = $beritas->first(); @endphp
            <a href="{{ route('berita.show', $headline->id) }}" class="featured-article">
                <div class="img-wrap">
                    <span class="featured-tag">Terbaru</span>
                    <img src="{{ $headline->gambar ? asset('storage/' . $headline->gambar) : 'https://via.placeholder.com/700x450?text=No+Image' }}" alt="{{ $headline->judul }}">
                </div>
                <div class="featured-body">
                    <span class="meta"><i class="fa-regular fa-clock"></i> {{ $headline->waktu_tampil }}</span>
                    <h2>{{ $headline->judul }}</h2>
                    <p>{{ Str::limit($headline->deskripsi, 180) }}</p>
                    <span class="read-more">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>

            @if($beritas->skip(1)->isNotEmpty())
                <h3 class="berita-section-title">Berita Lainnya</h3>

                <div class="news-grid">
                    @foreach($beritas->skip(1) as $berita)
                        <a href="{{ route('berita.show', $berita->id) }}" class="news-card">
                            <div class="thumb">
                                <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://via.placeholder.com/400x220?text=No+Image' }}" alt="{{ $berita->judul }}">
                            </div>
                            <div class="body">
                                <span class="meta"><i class="fa-regular fa-clock"></i> {{ $berita->waktu_tampil }}</span>
                                <h3>{{ $berita->judul }}</h3>
                                <p>{{ Str::limit($berita->deskripsi, 90) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
@endsection
