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
        Schema::create('nilai', function (Blueprint $table): void {
            $table->increments('id_nilai');
            $table->string('nis', 10)->nullable();
            $table->unsignedInteger('id_mapel')->nullable();
            $table->integer('semester')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();

            // DESIGN LIMITATION: Database existing tidak memiliki foreign key constraint
            // pada kolom nis (→ siswa.nis) dan id_mapel (→ mapel.id_mapel).
            // FK tidak ditambahkan agar migration merepresentasikan schema existing secara akurat.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
