<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BugReportController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
        ]);

        $report = $request->user()->bugReports()->create($data);

        return response()->json(['message' => 'Thanks for the report — we\'ll look into it.', 'data' => $report], 201);
    }
}
