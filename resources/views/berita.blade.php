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

        /* Featured article besar di atas */
        .featured-article {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 0;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 16px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            margin-bottom: 50px;
            transition: border-color 0.3s ease, transform 0.3s ease;
        }
        .featured-article:hover { border-color: var(--primary); transform: translateY(-3px); }
        .featured-article .img-wrap { position: relative; min-height: 320px; overflow: hidden; }
        .featured-article .img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .featured-tag {
            position: absolute; top: 18px; left: 18px;
            background: var(--primary); color: #fff; font-size: 0.75rem; font-weight: 700;
            padding: 5px 14px; border-radius: 30px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .featured-body { padding: 35px; display: flex; flex-direction: column; justify-content: center; }
        .featured-body .meta { color: #888; font-size: 0.8rem; margin-bottom: 12px; }
        .featured-body h2 { color: #fff; font-size: 1.6rem; font-weight: 700; line-height: 1.3; margin-bottom: 15px; }
        .featured-body p { color: #b0b0b0; line-height: 1.7; margin-bottom: 20px; }
        .featured-body .read-more { color: var(--primary); font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 6px; }
        .featured-article:hover .read-more { gap: 10px; }

        /* Grid berita lainnya */
        .berita-section-title { color: #fff; font-size: 1.3rem; font-weight: 700; margin-bottom: 20px; border-left: 4px solid var(--primary); padding-left: 12px; }
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }
        .news-card {
            background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 14px; overflow: hidden;
            text-decoration: none; color: inherit; display: flex; flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .news-card:hover { transform: translateY(-6px); box-shadow: 0 15px 30px rgba(0,0,0,0.5); border-color: var(--primary); }
        .news-card .thumb { height: 190px; overflow: hidden; }
        .news-card .thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .news-card:hover .thumb img { transform: scale(1.08); }
        .news-card .body { padding: 18px; flex-grow: 1; display: flex; flex-direction: column; }
        .news-card .meta { color: #777; font-size: 0.75rem; margin-bottom: 8px; }
        .news-card h3 { color: #fff; font-size: 1.05rem; font-weight: 700; line-height: 1.4; margin-bottom: 10px; }
        .news-card p { color: #999; font-size: 0.88rem; line-height: 1.6; flex-grow: 1; }

        .empty-state { text-align: center; color: #888; padding: 60px 20px; }

        @media (max-width: 768px) {
            .featured-article { grid-template-columns: 1fr; }
            .featured-article .img-wrap { min-height: 220px; }
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
                    <span class="meta">{{ $headline->created_at->translatedFormat('d F Y') }}</span>
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
                                <span class="meta">{{ $berita->created_at->translatedFormat('d F Y') }}</span>
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
