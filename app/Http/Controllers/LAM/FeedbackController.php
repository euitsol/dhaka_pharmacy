<?php

namespace App\Http\Controllers\LAM;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Models\TempFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class FeedbackController extends Controller
{
    public function __construct()
    {
        return $this->middleware('lam');
    }

    public function index(): View
    {
        return view('local_area_manager.feedback.index');
    }
    public function store(FeedbackRequest $req): RedirectResponse
    {
        $files = [];
        $fdk = new Feedback();
        if (!empty($req['files'])) {
            foreach ($req['files'] as $file) {
                $temp_file = TempFile::findOrFail($file);
                if ($temp_file) {
                    $from_path = 'public/' . $temp_file->path . '/' . $temp_file->filename;
                    $to_path = 'feedback/local_area_manager/' . str_replace(' ', '-', lam()->name) . '/' . time() . '/' . $temp_file->filename;
                    Storage::move($from_path, 'public/' . $to_path);
                    array_push($files, $to_path);
                    Storage::deleteDirectory('public/' . $temp_file->path);
                    $temp_file->forceDelete();
                }
            }
        }
        $fdk->files = json_encode($files);
        $fdk->subject = $req->subject;
        $fdk->description = $req->description;
        $fdk->creater()->associate(lam());
        $fdk->save();
        flash()->addSuccess('Your feedback is submitted successfully. Thanks for being with us!');
        return redirect()->back();
    }
}
