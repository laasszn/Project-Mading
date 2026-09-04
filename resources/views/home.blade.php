@extends('layouts.app')

@section('title', 'Beranda - Mading SMK N 1 Dukuhturi')

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
                <img src="image/ps.jpg">
                <div class="hero-content">...</div>
            </div>
            <div class="dots">
                <div class="dot active"></div>
            </div>
        @endif

            />
            <div class="hero-content">
                <span class="badge">Featured</span>
                <h1>Pameran Seni Digital 2026</h1>
                <p>
                    Karya Fajar Tirta Hidayat memenangkan kompetisi
                    nasional.
                </p>
                <a href="{{ url('/berita') }}" class="btn-join"
                    >Baca Selengkapnya</a
                >
            </div>
        </div>
    </header>

    <div class="container">
        <div class="section-title">
            <h2>Berita & Artikel</h2>
            <p>Informasi terbaru seputar kegiatan sekolah.</p>
        </div>

        @if($latestBeritas->count())
            <div class="grid-wrapper">
                {{-- Berita paling baru jadi featured card gede --}}
                <div style="display: flex; flex-direction: column; gap: 20px">
                    @php $featured = $latestBerita->first(); @endphp
                    <div class="section-header-row">
                        <div class="section-title" style="margin-bottom:0">
                            <h2>Berita Terbaru</h2>
                        </div>

                        <a href="{{ route('berita.index') }}">
                            Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="home-latest-grid" style="margin-bottom: 60px">
                        @foreach ($latestBerita as $berita)
                            <a href="{{ route('berita.show', $berita->id) }}" class="home-news-card">
                                <div class="thumb"><img src="{{ $berita->gambar ? asset('storage/'.$berita->gambar) : 'https://via.placeholder.com/400x220' }}"></div>
                                <div class="body">
                                    <span class="meta">
                                        <i class="fa-regular fa-clock"></i> {{ $berita->created_at->diffForHumans() }}
                                    </span>
                                    <h3>{{ $berita->judul }}</h3>
                                    <p>{{ Str::limit($berita->deskripsi, 78) }}</p>
                                    <div class="foot">
                                        <span>Berita</span>
                                        <span class="read">Baca <i class="fa-solid fa-arrow-right"></i></span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 3 berita berikutnya jadi list kecil di samping --}}
                <div style="display: flex; flex-direction: column; gap: 20px">
                    @foreach($latestBerita->skip(1) as $item)
                        <a href="{{ route('berita.show', $item->id) }}" class="card" style="text-decoration: none; color: inherit;">
                            <img
                                src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/300x160?text=No+Image' }}"
                                class="card-img-top"
                                style="height: 160px"
                            />
                            <div class="card-body">
                                <span class="card-meta">{{ $item->created_at->translatedFormat('d F Y') }}</span>
                                <h4 class="card-title">{{ $item->judul }}</h4>
                                <p class="card-text">{{ Str::limit($item->deskripsi, 70) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <p style="color: #aaa; text-align: center;">Belum ada berita yang diterbitkan.</p>
        @endif

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/berita') }}" class="btn-join">Lihat Semua Berita</a>
        </div>
    </div>
@endsection