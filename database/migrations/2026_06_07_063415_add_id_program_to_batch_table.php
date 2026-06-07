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
        Schema::table('batch', function (Blueprint $table) {
            $table->unsignedBigInteger('id_program')->nullable()->after('nama_program');
            $table->foreign('id_program')->references('id_program')->on('programs')->onDelete('set null');
        });

        // Migrate data
        $batches = \Illuminate\Support\Facades\DB::table('batch')->get();
        foreach ($batches as $batch) {
            $program = \Illuminate\Support\Facades\DB::table('programs')->where('nama', $batch->nama_program)->first();
            if ($program) {
                \Illuminate\Support\Facades\DB::table('batch')->where('id_batch', $batch->id_batch)->update(['id_program' => $program->id_program]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batch', function (Blueprint $table) {
            $table->dropForeign(['id_program']);
            $table->dropColumn('id_program');
        });
    }
};
