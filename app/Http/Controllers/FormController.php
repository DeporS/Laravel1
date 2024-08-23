<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers;
use App\Models\Post;
use App\Mail\MailTest;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    
    public function show(): View
    {
        return view('form');
    }

    public function validateForm(Request $request)
    { 
        $validatedData = $request->validate([
            'name' => 'required|alpha|max:255',
            'surname' => 'required|alpha|max:255',
            'email' => 'required|email|max:255'
        ]);

        Mail::to($request->email)->send(new MailTest([
            'name' => $request->name,
        ]));

        $post = new Post;
        $post->name = $request->name;
        $post->surname = $request->surname;
        $post->email = $request->email;
        $post->save();

        return view('formSent');
        
    }
    
}
