<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
    ];

    // tulisan waktu kayak "5 jam yang lalu"
    public function getWaktuTampilAttribute(): string
    {
        $hours = (int) $this->created_at->diffInHours();

        if ($hours < 1) {
            $minutes = (int) $this->created_at->diffInMinutes();
            return $minutes < 1 ? 'Baru saja' : $minutes.' menit yang lalu';
        }

        if ($hours < 24) {
            return $hours.' jam yang lalu';
        }

        return (int) $this->created_at->diffInDays().' hari yang lalu';
    }

    // versi jam aslinya, misal "14:30 WIB"
    public function getJamTampilAttribute(): string
    {
        if ((int) $this->created_at->diffInHours() < 24) {
            return $this->created_at->format('H:i').' WIB';
        }
        return (int) $this->created_at->diffInDays().' hari yang lalu';
    }
}
