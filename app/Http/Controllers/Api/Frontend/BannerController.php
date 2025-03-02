<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class BannerController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $banners = Banner::select('id', 'title', 'link', 'image_path', 'page_key', 'is_mobile')->active()->mobile()
            ->when($request->page_key, fn($query) => $query->where('page_key', $request->page_key))
            ->orderBy('created_at', 'desc')
            ->get();

        return sendResponse(true, 'Banners retrieved successfully', $banners);
    }
}
