<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuggestionMail;

class SuggestionController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'suggestion' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'suggestion' => $request->suggestion,
        ];

        Mail::to('razzymuhammad@gmail.com')->send(new SuggestionMail($data));

        return redirect()->back()->with('success', 'Terima kasih! Saran Anda telah dikirim.');
    }
}