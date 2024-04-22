<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
  public function store(Request $request)
  {
    DB::beginTransaction();
    try {
      $validated = $request->validate([
        'title' => 'required|max:255',
        'email' => 'required|email',
        'body' => 'required',
      ]);

      Contact::create($validated);

      $adminEmail = config('mail.admin');
      Mail::to($adminEmail)->send(new ContactForm($validated));

      Mail::to($validated['email'])->send(new ContactForm($validated));
      DB::commit();
      return back()->with('message', 'メールをお送りしました');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withErrors('メール送信に失敗しました。');
    }
  }
}

//   public function store(Request $request)
//   {
//     $contact = new Contact();

//     $inputs = request()->validate([
//       'title' => 'required|max:255',
//       'eamil' => 'required',
//       'body' => 'required',
//     ]);

//     $contact->create($inputs);

//     $admin = config('mail.admin');
//     Mail::to($admin)->send(new ContactForm($inputs));

//     $email = $inputs['email'];
//     Mail::to($email)->send(new ContactForm($inputs));

//     $request->session()->flash('message', 'メールをお送りしました');
//     return back();
//   }
