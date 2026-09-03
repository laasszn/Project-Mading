@extends('layouts.app')

@section('title', 'Admin - Kelola Berita')

@section('content')
<div class="container" style="max-width: 1000px; margin: 40px auto; color: #fff;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Kelola Berita (Panel Admin)</h2>
        <a href="{{ route('admin.berita.create') }}" style="background: #0d6efd; color: #fff; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold;">
            + Tambah Berita
        </a>
    </div>

    @if(session('success'))
        <div style="background: #198754; color: #fff; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; background: #1e1e1e; border-radius: 8px; overflow: hidden;">
        <thead>
            <tr style="background: #2a2a2a; text-align: left;">
                <th style="padding: 12px 15px;">Gambar</th>
                <th style="padding: 12px 15px;">Judul Berita</th>
                <th style="padding: 12px 15px;">Deskripsi Singkat</th>
                <th style="padding: 12px 15px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($beritas as $item)
                <tr style="border-bottom: 1px solid #333;">
                    <td style="padding: 12px 15px;">
                        <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/80x50' }}" width="80" height="50" style="object-fit: cover; border-radius: 4px;">
                    </td>
                    <td style="padding: 12px 15px; font-weight: 600;">{{ $item->judul }}</td>
                    <td style="padding: 12px 15px; color: #aaa;">{{ Str::limit($item->deskripsi, 60) }}</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('admin.berita.edit', $item->id) }}" style="background: #ffc107; color: #000; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem;">Edit</a>
                            
                            <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #dc3545; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 0.85rem;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #aaa;">Belum ada berita. Silakan tambahkan berita baru.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection