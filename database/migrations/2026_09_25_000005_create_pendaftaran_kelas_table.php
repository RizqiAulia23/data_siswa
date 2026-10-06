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
        Schema::create('pendaftaran_kelas', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nis', 10)->nullable();
            $table->unsignedInteger('id_kelas')->nullable();
            $table->string('tahun', 4)->nullable();

            $table->foreign('nis', 'pendaftaran_kelas_nis_fkey')
                ->references('nis')
                ->on('siswa')
                ->onUpdate('no action')
                ->onDelete('no action');

            $table->foreign('id_kelas', 'pendaftaran_kelas_id_kelas_fkey')
                ->references('id_kelas')
                ->on('kelas')
                ->onUpdate('no action')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_kelas');
    }
};
