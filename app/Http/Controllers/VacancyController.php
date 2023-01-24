<?php

namespace App\Http\Controllers;


use App\Filters\JobFilter;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Vacancy;
use App\Mail\RecommendedVacancies;
use Illuminate\Support\Facades\Mail;
use App\Models\Preference;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{
    public function index(JobFilter $request)
    {
        $vacancies = Job::filter($request)->paginate(10);
        $categories = Category::all();

        return view('vacancy.index', compact(['vacancies', 'categories']));
    }

    public function send()
    {    
        $preferences = Preference::all();

        foreach ($preferences as $preference) {
                $user = User::find($preference->user_id);
                $vacancies = $this->filter($preference);

                if(count($vacancies) > 0) {
                    Mail::to($user->email)->send(new RecommendedVacancies($vacancies));
                }
          }  
          

        
        return 'done';
        
    }

    public function recommended()
    {
        $preference = Preference::where('user_id', Auth::user()->id)->first();
        $vacancies = $this->filter($preference);

        return view('vacancy.recommended', compact('vacancies'));
    }

    public function filter($preference)
    {
        $vacancies = Vacancy::all();

        if($preference->city !== null) {
            $vacancies = $vacancies->where('city', $preference->city);
        } 

        if($preference->category_id !== null) {
            $vacancies = $vacancies->where('category_id', $preference->category_id);
        }
        
        if($preference->experience !== null) {
            $vacancies = $vacancies->where('experience', '>=', $preference->experience);
        }

        if($preference->salary !== null) {
            $vacancies = $vacancies->where('salary', '>=', $preference->salary);
        }


        return $vacancies;
    }
}
