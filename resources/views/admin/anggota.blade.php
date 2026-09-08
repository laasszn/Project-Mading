@extends('layouts.app')

@section('title', 'Admin - Kelola Anggota')

@section('content')
<div class="container" style="max-width: 1000px; margin: 40px auto; color: #fff;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Kelola Anggota (Panel Admin)</h2>
        <a href="{{ route('admin.anggota.create') }}" style="background: #0d6efd; color: #fff; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold;">
            + Tambah Anggota
        </a>
    </div>

    @if(session('success'))
        <div style="background: #198754; color: #fff; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div style="background: #ffc107; color: #000; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('warning') }}
        </div>
    @endif

    {{-- Kelola khusus Slide 1 & Slide 2 — Slide 1 sekarang pakai tabel tentang_slide1s (judul, deskripsi, foto) --}}
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-bottom:20px;">
        {{-- Slide 1: Judul, Deskripsi, Foto --}}
        <div style="background:#1e1e1e; border:1px solid #333; border-radius:8px; padding:16px; display:flex; gap:14px; align-items:center;">
            <div style="flex-shrink:0;">
                @if(isset($slide1) && $slide1 && $slide1->foto)
                    <img src="{{ asset('storage/' . $slide1->foto) }}" alt="Slide 1" style="width:84px; height:84px; object-fit:cover; border-radius:10px; border:2px solid #0d6efd;">
                @else
                    <div style="width:84px; height:84px; border-radius:10px; background:#2a2a2a; border:2px dashed #444; display:flex; align-items:center; justify-content:center; color:#888; font-size:1.4rem;"><i class="fa-solid fa-image"></i></div>
                @endif
            </div>
            <div style="flex:1; min-width:0;">
                <div style="font-size:0.78rem; color:#0d6efd; font-weight:700; letter-spacing:0.6px; text-transform:uppercase;">Slide 1 — Intro</div>
                <div style="font-weight:700; color:#fff; margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">@if(isset($slide1) && $slide1 && $slide1->judul) {{ Str::limit($slide1->judul, 38) }} @else Belum diatur @endif</div>
                <div style="font-size:0.85rem; color:#aaa; margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">@if(isset($slide1) && $slide1 && $slide1->deskripsi) {{ Str::limit($slide1->deskripsi, 48) }} @else Judul, deskripsi & foto hero @endif</div>
            </div>
            <div>
                <a href="{{ route('admin.slide1.edit') }}" style="background:@if(isset($slide1) && $slide1) #ffc107; color:#000; @else #0d6efd; color:#fff; @endif padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:700; font-size:0.85rem; display:inline-flex; align-items:center; gap:6px; white-space:nowrap;">
                    @if(isset($slide1) && $slide1)<i class="fa-solid fa-pen"></i> Edit Slide 1 @else <i class="fa-solid fa-plus"></i> Atur Slide 1 @endif
                </a>
            </div>
        </div>
        {{-- Slide 2 Ketua Umum --}}
        <div style="background:#1e1e1e; border:1px solid #333; border-radius:8px; padding:16px; display:flex; gap:14px; align-items:center;">
            <div style="flex-shrink:0;">
                @if(isset($ketuaUmum) && $ketuaUmum && $ketuaUmum->foto)
                    <img src="{{ asset('storage/' . $ketuaUmum->foto) }}" alt="Ketua" style="width:84px; height:84px; object-fit:cover; border-radius:50%; border:2px solid #0d6efd;">
                @elseif(isset($ketuaUmum) && $ketuaUmum)
                    <img src="{{ $ketuaUmum->foto_url }}" alt="Ketua" style="width:84px; height:84px; object-fit:cover; border-radius:50%; border:2px solid #0d6efd;">
                @else
                    <div style="width:84px; height:84px; border-radius:50%; background:#2a2a2a; border:2px dashed #444; display:flex; align-items:center; justify-content:center; color:#888; font-size:1.4rem;"><i class="fa-solid fa-user-tie"></i></div>
                @endif
            </div>
            <div style="flex:1;">
                <div style="font-size:0.78rem; color:#0d6efd; font-weight:700; letter-spacing:0.6px; text-transform:uppercase;">Slide 2 — Ketua Umum</div>
                <div style="font-weight:700; color:#fff; margin-top:2px;">@if(isset($ketuaUmum) && $ketuaUmum) {{ $ketuaUmum->nama }} @else Belum diatur @endif</div>
                <div style="font-size:0.85rem; color:#aaa; margin-top:2px;">@if(isset($ketuaUmum) && $ketuaUmum) {{ $ketuaUmum->jabatan }} @else Kategori: ketua_umum @endif</div>
            </div>
            <div>
                @if(isset($ketuaUmum) && $ketuaUmum)
                    <a href="{{ route('admin.anggota.edit', $ketuaUmum->id) }}" style="background:#ffc107; color:#000; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:700; font-size:0.85rem; display:inline-flex; align-items:center; gap:6px;"><i class="fa-solid fa-pen"></i> Edit</a>
                @else
                    <a href="{{ route('admin.anggota.create') }}?kategori=ketua_umum" style="background:#0d6efd; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:700; font-size:0.85rem; display:inline-flex; align-items:center; gap:6px;"><i class="fa-solid fa-plus"></i> Atur</a>
                @endif
            </div>
        </div>
    </div>
    <div style="background:#1a1a1a; border:1px solid #333; border-radius:8px; padding:12px 16px; margin-bottom:20px; color:#aaa; font-size:0.85rem;">
        <i class="fa-solid fa-circle-info" style="color:#0d6efd;"></i> <strong style="color:#fff;">Slide 1</strong> (judul, deskripsi, foto) diatur lewat tombol <strong style="color:#fff;">Atur / Edit Slide 1</strong> di atas — bukan tambah anggota. <strong style="color:#fff;">Slide 2</strong> tetap dari Ketua Umum. Semua anggota Slide 3 ada di tabel bawah.
    </div>

    <table style="width: 100%; border-collapse: collapse; background: #1e1e1e; border-radius: 8px; overflow: hidden;">
        <thead>
            <tr style="background: #2a2a2a; text-align: left;">
                <th style="padding: 12px 15px;">Foto</th>
                <th style="padding: 12px 15px;">Nama</th>
                <th style="padding: 12px 15px;">Jabatan</th>
                <th style="padding: 12px 15px;">Kategori</th>
                <th style="padding: 12px 15px; text-align: center;">Urutan</th>
                <th style="padding: 12px 15px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($anggotas as $item)
                <tr style="border-bottom: 1px solid #333;">
                    <td style="padding: 12px 15px;">
                        <img src="{{ $item->foto ? asset('storage/' . $item->foto) : $item->foto_url }}" alt="{{ $item->nama }}" width="56" height="56" style="object-fit: cover; border-radius: 50%; border: 2px solid #0d6efd; background:#000;">
                    </td>
                    <td style="padding: 12px 15px; font-weight: 600;">{{ $item->nama }}</td>
                    <td style="padding: 12px 15px; color: #aaa;">{{ $item->jabatan }}</td>
                    <td style="padding: 12px 15px; color: #aaa; text-transform: capitalize;">{{ str_replace('_',' ', $item->kategori) }}</td>
                    <td style="padding: 12px 15px; text-align: center; color: #aaa;">{{ $item->urutan }}</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('admin.anggota.edit', $item->id) }}" style="background: #ffc107; color: #000; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem;">Edit</a>
                            <form action="{{ route('admin.anggota.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #dc3545; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 0.85rem;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #aaa;">Belum ada anggota. Silakan tambahkan anggota baru.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
