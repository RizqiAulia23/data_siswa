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
        Schema::create('guru', function (Blueprint $table): void {
            $table->increments('id_guru');
            $table->string('nip', 20)->nullable()->unique('nip_unique');
            $table->string('nama', 100)->nullable();
            $table->char('jenis_kelamin', 1)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->decimal('gaji', 10, 2)->nullable();
            $table->boolean('aktif')->nullable()->default(true);
            $table->string('nomor_hp', 15)->nullable();

            $table->index('nama', 'idx_guru_nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
