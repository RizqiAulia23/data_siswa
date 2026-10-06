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
        Schema::create('siswa', function (Blueprint $table): void {
            $table->string('nis', 10)->primary();
            $table->string('nama', 100);
            $table->text('alamat')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nomor_hp', 15)->nullable();
            $table->string('agama', 30)->nullable();
            $table->string('jenis_kelamin', 1)->nullable();
        });

        // POSTGRESQL-SPECIFIC: Menambahkan check constraint cek_jk (jenis_kelamin IN ('L', 'P')) sesuai schema PostgreSQL existing
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE siswa ADD CONSTRAINT cek_jk CHECK (jenis_kelamin::text = ANY (ARRAY['L'::character varying, 'P'::character varying]::text[]))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
