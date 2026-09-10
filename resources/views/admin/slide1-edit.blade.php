@extends('layouts.app')

@section('title', 'Atur Slide 1 - Admin')

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
            max-width: 640px;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .admin-title {
            color: white;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
        }
        .admin-subtitle {
            color: #aaa;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 22px;
        }
        .form-group { margin-bottom: 18px; }
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
            box-sizing: border-box;
        }
        .form-control:focus { border-color: #0d6efd; }
        textarea.form-control { min-height: 120px; resize: vertical; }
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
        .btn-group { display: flex; gap: 15px; margin-top: 28px; }
        .btn-submit {
            flex: 2;
            padding: 12px;
            background: #0d6efd;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-submit:hover { background: #0b5ed7; transform: translateY(-2px); }
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
        .preview-box {
            display:flex; gap:14px; align-items:center; background:#151515; border:1px solid #333; border-radius:8px; padding:12px; margin-bottom:4px;
        }
        .preview-box img { width:84px; height:84px; object-fit:cover; border-radius:10px; border:2px solid #0d6efd; }
    </style>
@endpush

@section('content')
    <div class="admin-wrapper">
        <div class="admin-card">
            <h2 class="admin-title"><i class="fa-solid fa-pen-to-square" style="color:#0d6efd;"></i> Atur Slide 1</h2>

            @if(session('warning'))
                <div style="background: #ffc107; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #000;">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('success'))
                <div style="background: #198754; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #fff;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background: #dc3545; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #fff;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($slide1) && $slide1 && $slide1->foto)
                <div class="preview-box">
                    <img src="{{ asset('storage/' . $slide1->foto) }}" alt="Preview Slide 1">
                    <div style="flex:1;">
                        <div style="color:#0d6efd; font-size:0.78rem; font-weight:700; letter-spacing:0.6px; text-transform:uppercase;">Foto Saat Ini</div>
                        <div style="color:#fff; font-weight:600; font-size:0.9rem; margin-top:2px; word-break:break-word;">{{ $slide1->judul ?? '—' }}</div>
                        <div style="color:#888; font-size:0.82rem; margin-top:2px;">Kosongkan file jika tidak ingin ganti foto</div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.slide1.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Judul <span style="color:#dc3545;">*</span></label>
                    <input type="text" name="judul" class="form-control" placeholder="Contoh: LITERASI & KREATIFITAS DIGITAL TINGGI HANYA DI SMEZINE." value="{{ old('judul', $slide1->judul ?? '') }}" required maxlength="255">
                    <div class="help-text">Judul utama Slide 1 (akan otomatis highlight kata terakhir / SMEZINE.)</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi <span style="color:#dc3545;">*</span></label>
                    <textarea name="deskripsi" class="form-control" placeholder="Tulis deskripsi singkat tentang Smezine..." required>{{ old('deskripsi', $slide1->deskripsi ?? '') }}</textarea>
                    <div class="help-text">Paragraf di bawah judul Slide 1</div>
                </div>

                <div class="form-group">
                    <label class="form-label">File Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                    <div class="help-text">Opsional. Format: jpeg, png, jpg, gif, webp. Maks 5MB (mengikuti batas server). Jika foto gagal di-upload, judul & deskripsi tetap tersimpan.</div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('admin.anggota.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Slide 1</button>
                </div>
            </form>
        </div>
    </div>
@endsection
