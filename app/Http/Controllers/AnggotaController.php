<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\TentangSlide1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function adminIndex()
    {
        $anggotas = Anggota::orderBy('urutan')->orderBy('created_at')->get();
        $hero = Anggota::where('kategori', 'hero')->first();
        $ketuaUmum = Anggota::where('kategori', 'ketua_umum')->first();

        try {
            $slide1 = Schema::hasTable('tentang_slide1s') ? TentangSlide1::first() : null;
        } catch (\Throwable $e) {
            $slide1 = null;
        }

        return view('admin.anggota', compact('anggotas', 'hero', 'ketuaUmum', 'slide1'));
    }

    public function create()
    {
        return view('admin.anggota-create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'urutan' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $data['urutan'] ??= 0;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('anggota', 'public');
        }

        Anggota::create($data);
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('admin.anggota-edit', compact('anggota'));
    }

    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:50',
            'urutan' => 'nullable|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $data['urutan'] ??= 0;

        if ($request->hasFile('foto')) {
            $this->hapusGambar($anggota->foto);
            $data['foto'] = $request->file('foto')->store('anggota', 'public');
        }

        $anggota->update($data);
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $this->hapusGambar($anggota->foto);
        $anggota->delete();
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }

    // hapus file lama biar gak numpuk
    private function hapusGambar(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
