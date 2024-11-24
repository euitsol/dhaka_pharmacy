<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Models\TempFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class FeedbackController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('pharmacy');
    }

    public function index(): View
    {
        return view('pharmacy.feedback.index');
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
                    $to_path = 'feedback/pharmacy/' . str_replace(' ', '-', pharmacy()->name) . '/' . time() . '/' . $temp_file->filename;
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
        $fdk->creater()->associate(pharmacy());
        $fdk->save();
        flash()->addSuccess('Your feedback is submitted successfully. Thanks for being with us!');
        return redirect()->back();
    }
}
