<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Vacancy;
use App\Models\Category;
use App\Http\Controllers\VacancyController;
use Scraper;

class ScrapeController extends Controller
{   

    public function scrape()
    {   
        Scraper::scrape();
    }
    
}
