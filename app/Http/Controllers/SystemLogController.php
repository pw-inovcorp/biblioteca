<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemLog;

class SystemLogController extends Controller
{
    //
    public function index()
    {
        $logs = SystemLog::with('user')
            ->orderBy('data_hora', 'desc')
            ->paginate(10);

        return view('/logs/index', ['logs' => $logs]);
    }

    public function show($id)
    {
        $log = SystemLog::with('user')->findOrFail($id);
        return view('/logs/show', ['log' => $log]);
    }

    public function search() {
        $search = request()->query('search','');
        $logs = SystemLog::with('user')
            ->where('alteracao', 'LIKE', "%{$search}%")
            ->orWhere('modulo', 'LIKE', "%{$search}%")
            ->orWhere('data_hora', 'LIKE', "%{$search}%")
            ->orWhereHas('user', fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10)
            ->withQueryString();

        return view('logs/index', ['logs' => $logs]);
    }
}
