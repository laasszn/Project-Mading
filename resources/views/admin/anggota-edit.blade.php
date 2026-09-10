@extends('layouts.app')

@section('title', 'Admin - Edit Anggota')

@section('content')
<div class="container admin-form" style="max-width: 700px; margin: 40px auto; color: #fff;">
    <h2 class="admin-page-title">Edit Anggota</h2>
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

    <form action="{{ route('admin.anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $anggota->nama) }}" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #222; color: #fff; margin-top: 5px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Jabatan / Divisi</label>
            <input type="text" name="jabatan" value="{{ old('jabatan', $anggota->jabatan) }}" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #222; color: #fff; margin-top: 5px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px; display:grid; grid-template-columns: 1fr 120px; gap:14px;">
            <div>
                <label>Kategori</label>
                <select name="kategori" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #222; color: #fff; margin-top: 5px; box-sizing: border-box;">
                    <option value="divisi" {{ old('kategori', $anggota->kategori)=='divisi'?'selected':'' }}>divisi — Slide 3</option>
                    <option value="pdd" {{ old('kategori', $anggota->kategori)=='pdd'?'selected':'' }}>pdd — Slide 3</option>
                    <option value="sekretaris_bendahara" {{ old('kategori', $anggota->kategori)=='sekretaris_bendahara'?'selected':'' }}>sekretaris_bendahara — Slide 3</option>
                    <option value="ketua" {{ old('kategori', $anggota->kategori)=='ketua'?'selected':'' }}>ketua — Slide 3</option>
                    <option value="ketua_umum" {{ old('kategori', $anggota->kategori)=='ketua_umum'?'selected':'' }}>ketua_umum — Slide 2</option>
                    @if($anggota->kategori === 'hero')
                        <option value="hero" selected>hero — Slide 1 (legacy)</option>
                    @endif
                </select>
                @if($anggota->kategori === 'hero')
                    <div style="color:#ffc107; font-size:0.8rem; margin-top:6px;">Kategori hero sudah tidak dipakai — Slide 1 sekarang pakai form terpisah. Silakan ubah ke divisi/ lainnya.</div>
                @endif
            </div>
            <div>
                <label>Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', $anggota->urutan) }}" min="0" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #222; color: #fff; margin-top: 5px; box-sizing: border-box;">
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Foto Saat Ini</label><br>
            <img src="{{ $anggota->foto ? asset('storage/' . $anggota->foto) : $anggota->foto_url }}" alt="{{ $anggota->nama }}" width="100" height="100" style="border-radius: 12px; border:2px solid #0d6efd; margin: 8px 0; object-fit: cover; background:#000;">
            <br>
            <label>Ganti Foto (Kosongkan jika tidak ingin ganti)</label>
            <input type="file" name="foto" accept="image/*" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #444; background: #222; color: #fff; margin-top: 5px; box-sizing: border-box;">
        </div>

        <button type="submit" style="background: #ffc107; color: #000; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">Update Anggota</button>
        <a href="{{ route('admin.anggota.index') }}" style="color: #bbb; margin-left: 10px; text-decoration: none;">Batal</a>
    </form>
</div>
@endsection
