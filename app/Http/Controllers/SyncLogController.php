<?php

namespace App\Http\Controllers;

use App\Models\SyncLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SyncLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $syncLogs = SyncLog::with('admin')->orderBy('created_at', 'desc')->paginate(10);
        return Inertia::render('Admin/SyncLog/Index', [
            'syncLogs' => $syncLogs
        ]);
    }
}
