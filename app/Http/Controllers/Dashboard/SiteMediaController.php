<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteMediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:4096',
        ]);

        $userId = auth()->id();
        $path = $request->file('file')->store("sites/{$userId}", 'public');

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }
}
