<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;


class ContactController extends Controller
{
    
    public function create()
    {
        return view('contact.create');
    }
    
    public function store(Request $request)
    {
        
        $inputs = request()->validate([
            'title'=> 'required|max:255',
            'body' => 'required|max:600',
            'email'=> 'required|max:250'
        ]);
        
        Contact::create($inputs);
        
        //mailのメソッド
        Mail::to(config('mail.admin'))->send(new ContactForm($inputs));
        Mail::to($inputs['email'])->send(new ContactForm($inputs));
        
        return back()->with('message','お問合せをメールで送信しましたのでご確認くださいませ');
    }
}
