<?php

namespace App\Http\Controllers;


use App\Filters\JobFilter;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Vacancy;

class HomeController extends Controller
{
    public function index(JobFilter $request)
    {
        $vacancies = Vacancy::filter($request)->latest()->paginate(10);
        $categories = Category::all();

        return view('vacancy.index', compact(['vacancies', 'categories']));
    }
}
