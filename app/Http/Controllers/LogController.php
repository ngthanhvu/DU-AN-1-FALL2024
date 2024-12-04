<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Users;

class LogController extends Controller
{
    public function index()
    {
        // return response()->json(
        //     Log::latest()->get()
        // );

        $logs = Log::latest()->get();

        foreach ($logs as $log) {
            $log->user_name = $log->user_id ? Users::find($log->user_id)->name : null;
        }

        return response()->json($logs);
    }
}
