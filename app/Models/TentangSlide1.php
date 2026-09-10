<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TentangSlide1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
    ];

    // foto slide 1, kalau kosong pakai gambar bawaan
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/'.$this->foto);
        }
        return 'https://www.pngmart.com/files/4/Haikyuu-PNG-Photos.png';
    }
}
