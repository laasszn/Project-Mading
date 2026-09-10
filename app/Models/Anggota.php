<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'kategori',
        'foto',
        'urutan',
    ];

    // foto anggota, kalau kosong pakai avatar tulisan nama aja
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/'.$this->foto);
        }
        // ketua umum biru, sisanya abu
        $bg = str_contains(strtolower($this->jabatan), 'ketua umum') ? '2997ff' : '333';
        $name = urlencode($this->nama);
        return "https://ui-avatars.com/api/?name={$name}&background={$bg}&color=fff&size=256";
    }
}
