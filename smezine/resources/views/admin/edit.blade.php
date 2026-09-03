@extends('layouts.app')

@section('title', 'Admin - Edit Berita')

@section('content')
<div class="container" style="max-width: 700px; margin: 40px auto; color: #fff;">
    <h2>Edit Berita</h2>
    <hr style="border-color: #333; margin-bottom: 20px;">

    @if ($errors->any())
        <div style="background: #dc3545; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #fff;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Judul Berita</label>
            <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #222; color: #fff; margin-top: 5px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Gambar Saat Ini</label><br>
            @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" width="150" style="border-radius: 6px; margin: 8px 0; object-fit: cover;">
            @else
                <p style="color: #777;">Tidak ada gambar</p>
            @endif
            <br>
            <label>Ganti Gambar (Kosongkan jika tidak ingin ganti)</label>
            <input type="file" name="gambar" accept="image/*" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #222; color: #fff; margin-top: 5px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label>Deskripsi / Isi Berita</label>
            <textarea name="deskripsi" rows="6" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #222; color: #fff; margin-top: 5px; box-sizing: border-box;">{{ old('deskripsi', $berita->deskripsi) }}</textarea>
        </div>

        <button type="submit" style="background: #ffc107; color: #000; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">Update Berita</button>
        <a href="{{ route('admin.berita.index') }}" style="color: #bbb; margin-left: 10px; text-decoration: none;">Batal</a>
    </form>
</div>
@endsection