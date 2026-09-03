@extends('layouts.app')

@section('title', $berita->judul . ' - Mading')

@push('styles')
    <style>
        .article-wrapper {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #aaa;
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 20px;
            transition: 0.2s;
        }
        .back-link:hover { color: #fff; }
        .article-title {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 10px;
        }
        .article-meta {
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 25px;
        }
        .article-img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #333;
            margin-bottom: 30px;
        }
        .article-body {
            color: #dcdcdc;
            font-size: 1.05rem;
            line-height: 1.9;
            white-space: pre-line;
        }
        .related-section {
            margin-top: 60px;
            border-top: 1px solid #333;
            padding-top: 30px;
        }
        .related-title {
            color: #fff;
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .related-card {
            background: #1e1e1e;
            border: 1px solid #333;
            border-radius: 10px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s ease;
        }
        .related-card:hover { transform: translateY(-4px); }
        .related-card img { width: 100%; height: 120px; object-fit: cover; }
        .related-card h4 { color: #fff; font-size: 0.95rem; margin: 10px 12px; }
    </style>
@endpush

@section('content')
    <div class="article-wrapper">
        <a href="{{ route('berita.index') }}" class="back-link">&larr; Kembali ke Berita</a>

        <h1 class="article-title">{{ $berita->judul }}</h1>
        <p class="article-meta">Dipublikasikan {{ $berita->created_at->translatedFormat('d F Y') }}</p>

        @if($berita->gambar)
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="article-img">
        @endif

        <div class="article-body">{{ $berita->deskripsi }}</div>

        @if($lainnya->count())
            <div class="related-section">
                <h3 class="related-title">Berita Lainnya</h3>
                <div class="related-grid">
                    @foreach($lainnya as $item)
                        <a href="{{ route('berita.show', $item->id) }}" class="related-card">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/300x150?text=No+Image' }}" alt="{{ $item->judul }}">
                            <h4>{{ $item->judul }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
