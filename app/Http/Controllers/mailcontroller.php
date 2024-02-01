<?php

namespace App\Http\Controllers;

use App\Mail\mymail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mailcontroller extends Controller
{
    public function mail(request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'firstname' => 'required|string',
        ]);
        $emailData = [
            'firstname' => $request->input('firstname'),
        ];

        Mail::to($request->input('email'))->send(new mymail($emailData));

        return response()->json([
            'status' => true,
            'message' => 'Email will be sent'
        ]);
    }


}
