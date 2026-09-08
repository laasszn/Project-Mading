<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tentang_slide1s', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable(); // path storage/tentang_slide1/...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tentang_slide1s');
    }
};
