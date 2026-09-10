<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan'); // mis: Ketua Umum, Ketua 1, Sekretaris 1, Koord. PDD, etc
            $table->string('kategori')->default('pengurus'); // kelompok: pimpinan, pengurus, pdd, divisi
            $table->string('foto')->nullable(); // path storage/anggota/...
            $table->integer('urutan')->default(0); // urutan tampil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
