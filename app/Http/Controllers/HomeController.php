<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;

class HomeController extends Controller
{
    public function index()
    {
        // buat slider + list berita + galeri di home
        $sliderBeritas = Berita::latest()->take(3)->get();
        $latestBeritas = Berita::latest()->take(6)->get();
        $latestBerita = $latestBeritas;
        $latestGaleris = Galeri::latest()->take(6)->get();

        return view('home', compact('sliderBeritas', 'latestBeritas', 'latestBerita', 'latestGaleris'));
    }
}
