<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 * @codeCoverageIgnore
 */
class OrderByPrescriptionController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120'
        ]);

        $file = $request->file('file');
        $uuid = Str::uuid();

        $path = $file->storeAs(
            'temp/prescriptions/' . $request->user()->id(),
            $uuid . '.' . $file->getClientOriginalExtension(),
            'public'
        );

        return response()->json([
            'uuid' => $uuid,
            'temporary_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'expires_at' => now()->addHours(2)
        ], 201);
    }
}
