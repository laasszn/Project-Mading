<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\TentangSlide1;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::orderBy('urutan')->orderBy('created_at')->get();

        // Group khusus sesuai struktur organisasi (classic) + manga 3-slide
        $ketuaUmum = $anggotas->where('kategori', 'ketua_umum')->values();
        if ($ketuaUmum->isEmpty()) {
            $ketuaUmum = $anggotas->filter(fn($a) => strtolower(trim($a->jabatan)) === 'ketua umum')->values();
        }

        $ketua = $anggotas->where('kategori', 'ketua')->values();
        if ($ketua->isEmpty()) {
            $ketua = $anggotas->filter(fn($a) => in_array(strtolower(trim($a->jabatan)), ['ketua 1', 'ketua 2']))->values();
        }

        $sekBen = $anggotas->where('kategori', 'sekretaris_bendahara')->values();
        if ($sekBen->isEmpty()) {
            $sekBen = $anggotas->filter(fn($a) => in_array(strtolower(trim($a->jabatan)), ['sekretaris 1','sekretaris 2','bendahara 1','bendahara 2','sekretaris','bendahara']))->values();
        }

        $pdd = $anggotas->where('kategori', 'pdd')->values();
        if ($pdd->isEmpty()) {
            $pdd = $anggotas->filter(fn($a) => str_contains(strtolower($a->jabatan), 'pdd'))->values();
        }

        $alreadyIds = collect([$ketuaUmum, $ketua, $sekBen, $pdd])->flatten()->pluck('id')->filter();
        $lainnya = $anggotas->whereNotIn('id', $alreadyIds)->values();

        // Untuk manga fullpage 3-slide (kode baru)
        // Slide 1: ambil dari tabel tentang_slide1s (judul, deskripsi, foto) — bukan dari Anggota
        try {
            $slide1 = \Illuminate\Support\Facades\Schema::hasTable('tentang_slide1s') ? TentangSlide1::first() : null;
        } catch (\Throwable $e) {
            $slide1 = null;
        }
        // fallback hero tetap diambil untuk kompatibilitas lama, tapi tidak lagi dipakai untuk Slide 1
        $hero = $anggotas->where('kategori', 'hero')->first();
        // Slide 2 Ketua Umum single
        $ketuaUmumSingle = $ketuaUmum->first();
        // Slide 3: semua anggota kecuali ketua umum single (Slide 1 sekarang terpisah, tidak lagi filter hero)
        $slide3Members = $anggotas
            ->reject(fn($a) => $ketuaUmumSingle && $a->id === $ketuaUmumSingle->id)
            ->values();

        // Jika slide3Members masih kosong dan DB kosong, maka akan tampil empty state di view
        // Untuk kompatibilitas, juga kirim slide3 yang diurutkan urutan
        $slide3Members = $slide3Members->sortBy('urutan')->values();

        return view('tentang', compact('anggotas', 'ketuaUmum', 'ketua', 'sekBen', 'pdd', 'lainnya', 'hero', 'ketuaUmumSingle', 'slide3Members', 'slide1'));
    }
}
