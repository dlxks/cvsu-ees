<?php

namespace App\Http\Controllers;

use App\Models\ChatLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $chatLogs = ChatLog::orderBy('created_at', 'desc')->paginate(10);
        return Inertia::render('Admin/ChatLog/Index', [
            'chatLogs' => $chatLogs
        ]);
    }
}
