<?php

namespace App\Support;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Log;

class ActivityLogHelper
{
    public static function log(string $aktivitas, ?string $jenis = null): void
    {
        try {
            LogAktivitas::create([
                'aktivitas' => substr($aktivitas, 0, 100),
                'jenis_aktivitas' => $jenis ? substr($jenis, 0, 10) : null,
                'waktu' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Activity log failed: '.$e->getMessage(), [
                'aktivitas' => $aktivitas,
                'jenis' => $jenis,
            ]);
        }
    }
}
