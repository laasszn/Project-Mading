<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\TentangSlide1;
use Illuminate\Support\Facades\Schema;

class TentangController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::orderBy('urutan')->orderBy('created_at')->get();

        // kelompokin sesuai jabatan, kalau kategorinya kosong tebak dari nama jabatan
        $ketuaUmum = $this->cari($anggotas, 'ketua_umum', fn($j) => $j === 'ketua umum');
        $ketua = $this->cari($anggotas, 'ketua', fn($j) => in_array($j, ['ketua 1', 'ketua 2']));
        $sekBen = $this->cari($anggotas, 'sekretaris_bendahara', fn($j) => in_array($j, ['sekretaris 1', 'sekretaris 2', 'bendahara 1', 'bendahara 2', 'sekretaris', 'bendahara']));
        $pdd = $this->cari($anggotas, 'pdd', fn($j) => str_contains($j, 'pdd'));

        $alreadyIds = collect([$ketuaUmum, $ketua, $sekBen, $pdd])->flatten()->pluck('id')->filter();
        $lainnya = $anggotas->whereNotIn('id', $alreadyIds)->values();

        // slide 1 dari tabel sendiri, sisanya dari anggota
        try {
            $slide1 = Schema::hasTable('tentang_slide1s') ? TentangSlide1::first() : null;
        } catch (\Throwable $e) {
            $slide1 = null;
        }

        $hero = $anggotas->where('kategori', 'hero')->first();
        $ketuaUmumSingle = $ketuaUmum->first();

        // slide 3 = semua kecuali ketua umum
        $slide3Members = $anggotas
            ->reject(fn($a) => $ketuaUmumSingle && $a->id === $ketuaUmumSingle->id)
            ->sortBy('urutan')->values();

        return view('tentang', compact('anggotas', 'ketuaUmum', 'ketua', 'sekBen', 'pdd', 'lainnya', 'hero', 'ketuaUmumSingle', 'slide3Members', 'slide1'));
    }

    // cari dulu by kategori, kalau gak ketemu baru by nama jabatan
    private function cari($anggotas, string $kategori, callable $tebak)
    {
        $ketemu = $anggotas->where('kategori', $kategori)->values();
        if ($ketemu->isNotEmpty()) {
            return $ketemu;
        }

        return $anggotas->filter(fn($a) => $tebak(strtolower(trim($a->jabatan))))->values();
    }
}
