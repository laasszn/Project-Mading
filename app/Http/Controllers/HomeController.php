<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;

class HomeController extends Controller
{
    public function index()
    {
        // Slider butuh 3 berita terbaru, latestBerita/Beritas untuk section Berita Terbaru
        $sliderBeritas = Berita::latest()->take(3)->get();
        $latestBeritas = Berita::latest()->take(6)->get();
        // Sediakan alias singular untuk kompatibilitas blade lama
        $latestBerita = $latestBeritas;

        // Karya Terbaru diambil dari galeri
        $latestGaleris = Galeri::latest()->take(6)->get();

        return view('home', compact('sliderBeritas', 'latestBeritas', 'latestBerita', 'latestGaleris'));
    }
}
