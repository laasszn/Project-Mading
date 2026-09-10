<?php

namespace App\Http\Controllers;

use App\Models\TentangSlide1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TentangSlide1Controller extends Controller
{
    public function edit()
    {
        try {
            if (!Schema::hasTable('tentang_slide1s')) {
                // tabelnya belum ada, kasih form kosong aja
                $slide1 = null;
                return view('admin.slide1-edit', compact('slide1'))->with('warning', 'Tabel tentang_slide1s belum ada. Jalankan php artisan migrate.');
            }
            $slide1 = TentangSlide1::first();
        } catch (\Throwable $e) {
            Log::error('Slide1 edit error: '.$e->getMessage());
            $slide1 = null;
        }
        return view('admin.slide1-edit', compact('slide1'));
    }

    public function update(Request $request)
    {
        try {
            // kalau fotonya rusak, judul + deskripsi tetap disimpan
            $fotoWarning = null;
            $sertakanFoto = false;
            $fotoFile = $request->file('foto');
            if ($fotoFile instanceof \Illuminate\Http\UploadedFile) {
                $err = $fotoFile->getError();
                if ($err === UPLOAD_ERR_OK) {
                    $sertakanFoto = true;
                } elseif ($err !== UPLOAD_ERR_NO_FILE) {
                    $fotoWarning = 'Foto tidak tersimpan (' . match ((int) $err) {
                        UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'ukuran foto melebihi batas server, gunakan foto <= 2MB',
                        UPLOAD_ERR_PARTIAL => 'upload terputus, silakan coba lagi',
                        UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => 'folder upload sementara server bermasalah, hubungi admin server',
                        UPLOAD_ERR_EXTENSION => 'upload dihentikan oleh ekstensi server',
                        default => 'gagal di-upload (kode error ' . $err . ')',
                    } . '). Judul & deskripsi tetap disimpan.';
                    Log::warning('Slide1 foto upload error: code=' . $err);
                }
            } elseif (!is_null($fotoFile)) {
                $sertakanFoto = true;
            }

            $aturan = [
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:5000',
            ];
            $payload = $request->only(['judul', 'deskripsi']);
            if ($sertakanFoto) {
                $aturan['foto'] = 'image|mimes:jpeg,png,jpg,gif,webp|max:5120';
                $payload['foto'] = $fotoFile;
            }

            $validator = Validator::make($payload, $aturan, [
                'judul.required' => 'Judul wajib diisi.',
                'judul.max' => 'Judul maksimal 255 karakter.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'deskripsi.max' => 'Deskripsi maksimal 5000 karakter.',
                'foto.image' => 'File harus berupa gambar.',
                'foto.mimes' => 'Format foto harus jpeg, png, jpg, gif, atau webp.',
                'foto.max' => 'Ukuran foto maksimal 5MB.',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if (!Schema::hasTable('tentang_slide1s')) {
                return back()->withErrors(['db' => 'Tabel tentang_slide1s belum ada. Jalankan: php artisan migrate --force'])->withInput();
            }

            $slide1 = TentangSlide1::first();
            $data = $request->only(['judul', 'deskripsi']);

            if ($sertakanFoto) {
                try {
                    // hapus foto lama biar gak numpuk
                    if ($slide1 && $slide1->foto && Storage::disk('public')->exists($slide1->foto)) {
                        Storage::disk('public')->delete($slide1->foto);
                    }
                    Storage::disk('public')->makeDirectory('tentang_slide1');
                    $data['foto'] = $fotoFile->store('tentang_slide1', 'public');
                } catch (\Throwable $fe) {
                    Log::error('Slide1 foto store error: '.$fe->getMessage());
                    return back()->withErrors(['foto' => 'Gagal menyimpan foto: '.$fe->getMessage()])->withInput();
                }
            }

            if ($slide1) {
                $slide1->update($data);
            } else {
                TentangSlide1::create($data);
            }

            if ($fotoWarning) {
                return redirect()->route('admin.anggota.index')
                    ->with('success', 'Slide 1 berhasil diperbarui (judul & deskripsi tersimpan, tanpa foto baru).')
                    ->with('warning', $fotoWarning);
            }

            return redirect()->route('admin.anggota.index')->with('success', 'Slide 1 berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $ve) {
            throw $ve;
        } catch (\Throwable $e) {
            Log::error('Slide1 update error: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'Gagal menyimpan Slide 1: '.$e->getMessage()])->withInput();
        }
    }
}
