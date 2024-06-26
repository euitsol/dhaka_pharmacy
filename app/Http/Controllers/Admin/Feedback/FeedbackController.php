<?php

namespace App\Http\Controllers\Admin\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class FeedbackController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function list(): View
    {
        $data['feedbacks'] = Feedback::with('openedBy')->orderBy('status', 'desc')->latest()->get();
        return view('admin.feedback.list', $data);
    }
    public function details($id): View
    {
        $fdk = Feedback::findOrFail($id);
        $fdk->status = 0;
        $fdk->opened_by = admin()->id;
        $fdk->updater()->associate(admin());
        $fdk->update();
        $data['feedback'] = $fdk;
        return view('admin.feedback.details', $data);
    }

    public function view_or_download($file_url)
    {
        $file_url = decrypt($file_url);
        if (Storage::exists('public/' . $file_url)) {
            $fileExtension = pathinfo($file_url, PATHINFO_EXTENSION);

            if (strtolower($fileExtension) === 'pdf') {
                return response()->file(storage_path('app/public/' . $file_url), [
                    'Content-Disposition' => 'inline; filename="' . basename($file_url) . '"'
                ]);
            } else {
                return response()->download(storage_path('app/public/' . $file_url), basename($file_url));
            }
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
