<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class LogAktivitasController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', LogAktivitas::class);

        $logs = LogAktivitas::latest('waktu')
            ->paginate(10);

        return view('log-aktivitas.index', compact('logs'));
    }

    public function show(LogAktivitas $log): View
    {
        $this->authorize('view', $log);

        return view('log-aktivitas.show', compact('log'));
    }
}
