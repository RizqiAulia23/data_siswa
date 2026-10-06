<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mapel', function (Blueprint $table): void {
            $table->increments('id_mapel');
            $table->string('kode_mapel', 50)->unique('mapel_kode_mapel_key');
            $table->string('nama_mapel', 100);
            $table->string('kategori', 50)->nullable();
            $table->integer('jumlah_jam');
            $table->integer('nilai_kktp')->nullable();
            $table->boolean('aktif')->nullable()->default(true);
            $table->text('deskripsi')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->integer('semester')->nullable();

            $table->index('kategori', 'idx_kategori_mapel');
            $table->index('kode_mapel', 'idx_kode_mapel');
            $table->index('nama_mapel', 'idx_nama_mapel');
        });

        // POSTGRESQL-SPECIFIC: Menambahkan check constraint cek_jumlah_jam (jumlah_jam > 0) sesuai schema PostgreSQL existing
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE mapel ADD CONSTRAINT cek_jumlah_jam CHECK (jumlah_jam > 0)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel');
    }
};
