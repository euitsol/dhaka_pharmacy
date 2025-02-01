<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;


class ContactPageController extends Controller
{
    private $cf_resubmit_delay = 1;


    public function contact(): View
    {
        return view('frontend.contact');
    }

    public function contact_submit(ContactRequest $request): RedirectResponse{

        if(session()->has('cf_submitted_at') && Carbon::now()->diffInMinutes(session('cf_submitted_at')) < $this->cf_resubmit_delay) {
            flash()->addWarning('Please wait '.$this->cf_resubmit_delay.' minutes before resubmitting.');
            return redirect()->route('contact_us')->withInput();
        }
        try {
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->message = $request->message;
            $contact->phone = $request->phone;
            $contact->save();

            $mail_data['message'] = $contact->message;
            $mail_data['name'] = $contact->name;
            $mail_data['email'] = $contact->email;
            $mail_data['phone'] = $contact->phone;

            Mail::to('noreply@dhakapharmacy.com.bd')->send(new ContactMail($mail_data));
            session()->put('cf_submitted_at', Carbon::now());
        } catch (\Exception $e) {
            // flash()->addError($e->getMessage());
            flash()->addError('Something went wrong! please try again.');
            return redirect()->route('contact_us')->withInput();
        }
        flash()->addSuccess('Your message has been sent successfully.');
        return redirect()->route('contact_us');
    }
}
