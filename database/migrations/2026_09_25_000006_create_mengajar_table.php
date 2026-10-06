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
        Schema::create('mengajar', function (Blueprint $table): void {
            $table->increments('id_mengajar');
            $table->unsignedInteger('id_guru')->nullable();
            $table->unsignedInteger('id_mapel')->nullable();
            $table->unsignedInteger('id_kelas')->nullable();
            $table->string('tahun_ajaran', 9)->nullable();

            // DESIGN LIMITATION: Database existing tidak memiliki foreign key constraint
            // pada kolom id_guru, id_mapel, id_kelas.
            // FK tidak ditambahkan agar migration merepresentasikan schema existing secara akurat.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mengajar');
    }
};
