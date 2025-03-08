<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\DataDeletionRequest;
use App\Mail\DataDeletionMail;
use App\Models\DataDeletionRequest as DataDeletionModel;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class DataDeletionController extends Controller
{
    private $df_resubmit_delay = 1;

    public function index(): View
    {
        return view('frontend.data_deletion');
    }

    public function submit(DataDeletionRequest $request): RedirectResponse
    {
        if (session()->has('df_submitted_at') && Carbon::now()->diffInMinutes(session('df_submitted_at')) < $this->df_resubmit_delay) {
            flash()->addWarning('Please wait ' . $this->df_resubmit_delay . ' minutes before resubmitting.');
            return redirect()->route('data_deletion')->withInput();
        }
        try {

            $mail_data['name'] = $request->name;
            $mail_data['email'] = $request->email;
            $mail_data['phone'] = $request->phone;
            $mail_data['reason'] = $request->reason;

            Mail::to(config('mail.contact_reciever_email'))->send(new DataDeletionMail($mail_data));
            session()->put('df_submitted_at', Carbon::now());
        } catch (\Exception $e) {
            flash()->addError('Something went wrong! please try again.');
            return redirect()->route('data_deletion')->withInput();
        }
        flash()->addSuccess('Your data deletion request has been submitted successfully.');
        return redirect()->route('data_deletion');
    }
}
