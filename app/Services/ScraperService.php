<?php

namespace App\Services;

use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Vacancy;
use App\Models\Category;
use App\Http\Controllers\VacancyController;


class ScraperService 
{
   public function scrape()
    {   
        set_time_limit(0);
        $cateories = Category::all();

        foreach ($cateories as $category) {
            $this->scrapeJooble($category->title, $category->id);
            $this->scrapeJobsUa($category->title, $category->id);
            $this->scrapeWorkUaPages($category->title, $category->id);
        }

        return 'done';

    }

    public function scrapeWorkUaPages($category, $category_id)
    {   
        set_time_limit(0);
        $client = new Client();
        $position = $category == 'C++' ? 'c%2B%2B': $category;
        $crawler = $client->request('GET', 'https://www.work.ua/jobs-' . $position . '/?days=122');

        if (preg_match('#job-link#su', $crawler->html())) {
            
            $this->saveWorkVac($crawler, $category_id);

            if (preg_match('#<ul[^>]+?class\s*?=\s*?["\']pagination\shidden-xs["\'][^>]*?#', $crawler->html())) {
                $flag = true;
                
                while($flag) {
                    sleep(rand(1,4));
                   $li =  $crawler->filter('#pjax-job-list > nav > ul.pagination.hidden-xs > li.active')->nextAll();

                   if (preg_match('#<a[^>]+?>#su', $li->html())) {
                      sleep(rand(1,4));
                      $link = $li->filter('a')->attr('href');
                      $crawler = $client->request('GET', 'https://www.work.ua' . $link);
                      $this->saveWorkVac($crawler, $category_id);
                   } else {
                      $flag = false;                  
                   }
                }
            }
            
        } else {
            echo false;
        } 
       
    }

    private function saveWorkVac($crawler, $category_id)
    {  
        $crawler->filter('.job-link')->each(function ($node) use ($category_id) {
            //get link
            $link = 'https://www.work.ua' . $node->filter('h2 > a')->attr('href');

            $client2 = new Client();
            $vac = $client2->request('GET', $link);

            //get title
            $title = $vac->filter('#h1-name')->text();

            //get salary
            $infoBlock =  $vac->filter('#center > div > div.row.row-print > div.col-md-8.col-left > div:nth-child(3) > div.card.wordwrap > p:nth-child(4)'); 
            $salary = null;

            if (preg_match('# грн#su', $infoBlock->html())) {
               $salary = $vac->filter('#center > div > div.row.row-print > div.col-md-8.col-left > div:nth-child(3) > div.card.wordwrap > p:nth-child(4) > b')->html();
                preg_match_all("#\d+#", $salary, $matches);
                $salary =  $matches[0][0] .  '000';

            }

            //get city
            $loc = $vac->filter('#center > div > div.row.row-print > div.col-md-8.col-left > div:nth-child(3) > div.card.wordwrap');
            $city = '';

            if (preg_match('#glyphicon-remote#su', $loc->html())) {
                $arr = explode(',',trim($loc->filter('span.glyphicon-remote')->ancestors()->text()));
                $city = $arr[0];
            } else {
                $arr = explode(',',trim($loc->filter('span.glyphicon-map-marker')->ancestors()->text()));
               $city = $arr[0];
            }

            //get experience
            $experience = '';

            if (preg_match('#glyphicon-tick#su', $loc->html())) {
                $str = $loc->filter('span.glyphicon-tick')->ancestors()->text();
             
                if (preg_match('#Досвід\sроботи\sвід\s(\d+)#su', $str)) {
                    preg_match('#Досвід\sроботи\sвід\s(\d+)#su', $str, $res);
                    $experience = $res[1];
                } else {
                    $experience = 0;
                }
         
            }

            //get company name
            $company_name = '';

            if (preg_match('#glyphicon-company#su', $loc->html())) {
                $arr = explode(',',trim($loc->filter('span.glyphicon-company')->ancestors()->text()));
                $company_name = $arr[0];
            }
            
            $vacancy = new Vacancy;
            $vacancy->title = $title;
            $vacancy->link = $link;
            $vacancy->city = $city;
            $vacancy->salary = $salary;
            $vacancy->experience = $experience;
            $vacancy->company_name = $company_name;
            $vacancy->category_id = $category_id;
            $vacancy->save();
       
        }); 
    }

    private function scrapeJooble($position, $category_id)
    {   
        set_time_limit(0);
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', 'https://ua.jooble.org/SearchResult?date=8&ukw=' . $position);

        $crawler->filter('.FxQpvm')->each(function ($node) use ($category_id) {   
            //get title
            $title = $node->filter('h2')->text();
            
            //get link
            $link = $node->filter('h2 > a')->attr('href');
             

            //get salary
            $salary = null;
            $currency = null;

            if(preg_match('#<p[^>]+?class\s*?=\s*?"jNebTl"[^>]*?>#su', $node->html())) {
                $payment = $node->filter('p.jNebTl')->text();
                preg_match('#(\d+)\s(\d+)#su', $payment, $res);
                $salary = $res[1] . $res[2];

                if(preg_match('#\$|€|грн#su', $payment)) {
                    preg_match('#(\$|€|грн)#su', $payment, $res);
                    $currency = $res[1];

                    if ($currency == '$') {
                       $salary = $this->exchangeCurrency($salary, 'USD');
                    } elseif ($currency == '€') {
                        $salary = $this->exchangeCurrency($salary, 'EUR');
                    }
                }
            }

            //get city
            $arr = explode(',',trim($node->filter('.caption')->text()));
            $city = $arr[0];

            //experience
            $experience = null;

            //get company name
            $company_name = null;

            if (preg_match('#<p[^>]+?class\s*?=\s*?"Ya0gV9"[^>]*?#su', $node->html())) {
                 $company_name =  $node->filter('p.Ya0gV9')->text();
            }

            $vacancy = new Vacancy;
            $vacancy->title = $title;
            $vacancy->link = $link;
            $vacancy->city = $city;
            $vacancy->salary = $salary;
            $vacancy->experience = $experience;
            $vacancy->company_name = $company_name;
            $vacancy->category_id = $category_id;
            $vacancy->save();
        });
  
    }

    private function scrapeJobsUa($position, $category_id)
    {   
        set_time_limit(0);
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', 'https://jobs.ua/vacancy/rabota-' . $position . '?period=7');

        if (preg_match('#<div[^>]+?class\s*?=\s*?"b-message\sb-message__attention"[^>]*?>#su', $crawler->html())) {
            echo false;
        } else {
            $crawler->filter('li.js-item_list')->each(function ($node) use ($category_id) {
                //get title
                $title = $node->filter('div.b-vacancy__top h3 a')->text();

                //get link
                $link = $node->filter('a.b-vacancy__top__title')->attr('href');

                //get salary
                $salary = null;
                $currency = null;

                if (preg_match('#<span[^>]+?class\s*?=\s*?"b-vacancy__top__pay"[^>]*?>#su', $node->html())) {
                    $payment = $node->filter('span.b-vacancy__top__pay')->text();
                    preg_match('#(\d+)\s(\d+)#su', $payment, $res);
                    $salary = $res[1] . $res[2];

                    if(preg_match('#\$|&euro;|грн#su', $payment)) {
                        preg_match('#(\$|&euro;|грн)#su', $payment, $res);
                        $currency = $res[1];
                    }

                }

                //get city
                $city = $node->filter('a.link__hidden')->text();

                //get experience
                $experience = null;

                //get company name
                $company_name  = $node->filter('div.b-vacancy__tech > span:nth-child(1) > span')->text();

                if (preg_match('#(?|<span[^>]+?class\s*?=\s*?"black-text"[^>]*?>.*від\s(.+?)\sроків|<span[^>]+?class\s*?=\s*?"black-text"[^>]*?>.*від\s(року))#su', $node->html(), $res)) {
                    $experience = $this->getDigit($res[1]);
                }

                $vacancy = new Vacancy;
                $vacancy->title = $title;
                $vacancy->link = $link;
                $vacancy->city = $city;
                $vacancy->salary = $salary;
                $vacancy->experience = $experience;
                $vacancy->company_name = $company_name;
                $vacancy->category_id = $category_id;
                $vacancy->save();

                //echo $category_id;

           });

        }

        

    }

    private function getDigit($str) {
        $digits = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $tran = ['року', 'двох', 'трьох', 'чотирьох', "п'яти", 'шести', 'семи', 'вісім', "дев'яти"];

        if (in_array($str, $tran)) {
            $key = array_search($str, $tran);
            return $digits[$key];
        } else {
            return 'null';
        }
        
    }

    private function exchangeCurrency($amount) {
        $url = 'https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11';
        $courses = json_decode(file_get_contents($url));

        foreach ($courses as $course) {

            if ($course->ccy == 'USD') {
                $cost = $course->buy;
                break;
            }

        }

        return floor($amount * 0.001 * $cost) * 1000;

    }
}