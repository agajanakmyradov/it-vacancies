<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function follow(Request $request)
    {   
        $preference =  new Preference;
        $preference->user_id = Auth::user()->id;
        $preference->city = $request->input('city');
        $preference->category_id = $request->input('category_id');
        $preference->salary = $request->input('salary');
        $preference->experience = $request->input('experience');
        $preference->save();

       return redirect()->route('home')->with('success', 'Подпииска оформлена успешна');
    }
}
