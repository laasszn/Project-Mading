<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // 1. Tampilan Publik -> resources/views/berita.blade.php
    public function index()
    {
        $beritas = Berita::latest()->get();
        return view('berita', compact('beritas'));
    }

    // 1b. Tampilan Detail Artikel -> resources/views/berita-show.blade.php
    public function show(string $id)
    {
        $berita = Berita::findOrFail($id);

        // Berita lain buat rekomendasi di bawah artikel
        $lainnya = Berita::where('id', '!=', $berita->id)->latest()->take(3)->get();

        return view('berita-show', compact('berita', 'lainnya'));
    }

    // 2. Tabel Admin -> resources/views/admin/berita.blade.php
    public function adminIndex()
    {
        $beritas = Berita::latest()->get();
        return view('admin.berita', compact('beritas'));
    }

    // 3. Form Tambah Berita -> resources/views/admin/create.blade.php
    public function create()
    {
        return view('admin.create');
    }

    // Simpan Berita Baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    // 4. Form Edit Berita -> resources/views/admin/edit.blade.php
    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.edit', compact('berita'));
    }

    // Update Berita
    public function update(Request $request, string $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // Hapus Berita
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}