<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id('id_program');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('theme_color')->default('blue');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('programs')->insert([
            [
                'nama' => 'Tokutei Ginou (SSW)',
                'deskripsi' => 'Program penyaluran tenaga kerja terampil (Specified Skilled Worker) ke Jepang dengan standar kelulusan minimal N4.',
                'theme_color' => 'rose',
                'is_active' => 'true',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Magang (Ginou Jisshusei)',
                'deskripsi' => 'Program pelatihan kerja (magang) sambil praktik kerja industri di perusahaan Jepang dengan durasi kontrak 3 tahun.',
                'theme_color' => 'blue',
                'is_active' => 'true',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Engineering',
                'deskripsi' => 'Program jalur profesional untuk lulusan D3/S1 di bidang IT, mesin, arsitektur yang menuntut skill khusus tinggi.',
                'theme_color' => 'emerald',
                'is_active' => 'false',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Program Persiapan N5',
                'deskripsi' => 'Program persiapan intensif untuk sertifikasi bahasa Jepang tingkat N5.',
                'theme_color' => 'indigo',
                'is_active' => 'true',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
