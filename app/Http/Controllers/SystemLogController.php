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
}
