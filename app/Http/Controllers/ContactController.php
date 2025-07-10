<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        return view('common.contact');
    }

    public function store(Request $request)
    {
        // 验证表单数据
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Please enter your name',
            'name.max' => 'Name cannot exceed 255 characters',
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email address',
            'email.max' => 'Email cannot exceed 255 characters',
            'subject.required' => 'Please enter a subject',
            'subject.max' => 'Subject cannot exceed 255 characters',
            'message.required' => 'Please enter your message',
            'message.max' => 'Message cannot exceed 2000 characters',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // 保存到数据库
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => Contact::STATUS_PENDING,
            ]);

            return back()->with('success', 'Thank you for your message! We will get back to you soon.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Submission failed, please try again later')
                ->withInput();
        }
    }
}
