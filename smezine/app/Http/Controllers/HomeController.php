<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 berita paling baru: 1 buat featured, 3 buat list kecil
        $latestBerita = Berita::latest()->take(4)->get();

        return view('home', compact('latestBerita'));
    }
}
