@extends('layouts.app')

@section('title', 'Tambah Berita - Admin')

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
        .form-group {
            margin-bottom: 20px;
        }
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
        .form-control:focus {
            border-color: var(--primary);
        }
        textarea.form-control {
            min-height: 120px;
            resize: vertical; /* Biar ukurannya cuma bisa ditarik ke bawah */
        }
        /* Styling khusus buat input file (gambar) */
        input[type="file"].form-control {
            padding: 9px 12px;
            color: #888;
        }
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
        input[type="file"]::-webkit-file-upload-button:hover {
            background: #444;
        }
        
        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
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
        .btn-submit:hover {
            background: #147ce5;
            transform: translateY(-2px);
        }
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
        .btn-cancel:hover {
            background: #444;
            transform: translateY(-2px);
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="admin-wrapper">
        <div class="admin-card">
            <h2 class="admin-title"><i class="fa-solid fa-pen-to-square"></i> Tambah Berita</h2>

            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" placeholder="Masukkan judul berita..." required>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" placeholder="Tulis isi berita di sini..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*" required>
                </div>

                <div class="btn-group">
                    <a href="{{ route('admin.berita.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
@endsection