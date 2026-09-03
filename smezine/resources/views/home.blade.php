@extends('layouts.app')

@section('title', 'Beranda - Mading SMK N 1 Dukuhturi')

@section('content')
    <header class="hero">
        <div class="slide active">
            <img
                src="image/ps.jpg"
                alt="Seni"
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
        <div class="slide">
            <img
                src="https://discover.therookies.co/content/images/size/w1000/2024/04/Almecija_Sophie_blender-project.jpeg"
                alt="3D"
            />
            <div class="hero-content">
                <span class="badge">Workshop</span>
                <h1>Belajar 3D Game Art</h1>
                <p>Pelatihan gratis Blender untuk pemula di Multimedia.</p>
                <a href="#" class="btn-join"
                    >Daftar Sekarang</a
                >
            </div>
        </div>
        <div class="dots">
            <div class="dot active"></div>
            <div class="dot"></div>
        </div>
    </header>

    <div class="container">
        <div class="section-title">
            <h2>Berita & Artikel</h2>
            <p>Informasi terbaru seputar kegiatan sekolah.</p>
        </div>

        @if($latestBerita->count())
            <div class="grid-wrapper">
                {{-- Berita paling baru jadi featured card gede --}}
                <div style="display: flex; flex-direction: column; gap: 20px">
                    @php $featured = $latestBerita->first(); @endphp
                    <a href="{{ route('berita.show', $featured->id) }}" class="card card-featured" style="text-decoration: none; color: inherit;">
                        <img
                            src="{{ $featured->gambar ? asset('storage/' . $featured->gambar) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
                            class="card-img-top"
                            style="height: 100%; object-fit: cover;"
                        />
                        <div class="card-body">
                            <h3 class="card-title">{{ $featured->judul }}</h3>
                            <p class="card-text">{{ Str::limit($featured->deskripsi, 100) }}</p>
                            <br />
                            <span class="btn-join">Baca Selengkapnya</span>
                        </div>
                    </a>
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