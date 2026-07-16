<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageSuggestionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'language' => ['required', 'string', 'max:100'],
        ]);

        $suggestion = $request->user()->languageSuggestions()->create($data);

        return response()->json(['message' => 'Thanks for the suggestion!', 'data' => $suggestion], 201);
    }
}
