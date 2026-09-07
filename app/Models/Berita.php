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

    /**
     * Accessor untuk keterangan waktu dinamis:
     * - Jika umur berita < 24 jam  -> tampilkan jam (mis: "5 jam yang lalu" atau "Baru saja")
     * - Jika >= 24 jam             -> tampilkan "x hari yang lalu"
     * Dipakai di home, berita, dan berita-show via $berita->waktu_tampil
     */
    public function getWaktuTampilAttribute(): string
    {
        $hours = (int) $this->created_at->diffInHours();
        if ($hours < 24) {
            if ($hours < 1) {
                $minutes = (int) $this->created_at->diffInMinutes();
                if ($minutes < 1) {
                    return 'Baru saja';
                }
                return $minutes . ' menit yang lalu';
            }
            return $hours . ' jam yang lalu';
        }   

        $days = (int) $this->created_at->diffInDays();
        return $days . 'hari yang lalu'; 
    }

    /**
     * Alternatif jika ingin format jam literal (HH:MM) untuk <24 jam.
     * Tidak dipakai default, tapi tersedia jika desain ingin "14:30 WIB".
     */
    public function getJamTampilAttribute(): string
    {
        if ((int) $this->created_at->diffInHours() < 24) {
            return $this->created_at->format('H:i') . ' WIB';
        }
        return (int) $this->created_at->diffInDays() . ' hari yang lalu';
    }
}
