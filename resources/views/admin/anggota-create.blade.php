@extends('layouts.app')

@section('title', 'Tambah Anggota - Admin')

@push('styles')
    <style>
        .admin-wrapper {
            padding: 40px 20px;
            min-height: 70vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .admin-card {
            background: #1e1e1e;
            border: 1px solid #333;
            width: 100%;
            max-width: 600px;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .admin-title {
            color: white;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
            border-bottom: 1px solid #333;
            padding-bottom: 15px;
        }
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            color: #ccc;
            margin-bottom: 8px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            background: #121212;
            border: 1px solid #444;
            color: white;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        .form-control:focus { border-color: var(--primary); }
        textarea.form-control { min-height: 100px; resize: vertical; }
        input[type="file"].form-control { padding: 9px 12px; color: #888; }
        input[type="file"]::-webkit-file-upload-button {
            background: #333;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
            font-family: 'Poppins', sans-serif;
        }
        input[type="file"]::-webkit-file-upload-button:hover { background: #444; }
        .help-text { color: #888; font-size: 0.8rem; margin-top: 6px; }
        .btn-group { display: flex; gap: 15px; margin-top: 30px; }
        .btn-submit {
            flex: 2;
            padding: 12px;
            background: var(--primary);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-submit:hover { background: #147ce5; transform: translateY(-2px); }
        .btn-cancel {
            flex: 1;
            padding: 12px;
            background: #333;
            color: white;
            text-align: center;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .btn-cancel:hover { background: #444; transform: translateY(-2px); color: white; }
        .form-select {
            width: 100%;
            padding: 12px;
            background: #121212;
            border: 1px solid #444;
            color: white;
            border-radius: 8px;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }
        .form-select:focus { border-color: var(--primary); }
    </style>
@endpush

@section('content')
    <div class="admin-wrapper">
        <div class="admin-card">
            <h2 class="admin-title"><i class="fa-solid fa-user-plus"></i> Tambah Anggota</h2>

            @if ($errors->any())
                <div style="background: #dc3545; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #fff;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.anggota.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Akhmad Kasifatul Fikri" value="{{ old('nama') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jabatan / Divisi</label>
                    <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Divisi Jurnalistik, Sekretaris, Tim PDD, Ketua Umum" value="{{ old('jabatan') }}" required>
                </div>

                <div class="form-group" style="display:grid; grid-template-columns: 1fr 110px; gap:14px;">
                    <div>
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="divisi" {{ old('kategori', request('kategori'))=='divisi'?'selected':'' }}>divisi — Slide 3</option>
                            <option value="pdd" {{ old('kategori', request('kategori'))=='pdd'?'selected':'' }}>pdd — Slide 3</option>
                            <option value="sekretaris_bendahara" {{ old('kategori', request('kategori'))=='sekretaris_bendahara'?'selected':'' }}>sekretaris_bendahara — Slide 3</option>
                            <option value="ketua" {{ old('kategori', request('kategori'))=='ketua'?'selected':'' }}>ketua — Slide 3</option>
                            <option value="ketua_umum" {{ old('kategori', request('kategori'))=='ketua_umum'?'selected':'' }}>ketua_umum — Slide 2</option>
                        </select>
                        <div class="help-text">Slide 1 sekarang diatur terpisah (judul, deskripsi, foto) — bukan dari sini. Selain ketua_umum → otomatis Slide 3</div>
                    </div>
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-control" placeholder="0" value="{{ old('urutan', 0) }}" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <div class="help-text">Opsional. Kosong = avatar inisial. Max 2MB.</div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('admin.anggota.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>
@endsection
