<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function send($value='')
    {   
        Mail::to('aga@gmail.com')->send(new TestMail());
        return view('testmailresult');
    }
} 
