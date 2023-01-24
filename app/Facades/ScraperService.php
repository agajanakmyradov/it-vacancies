<?php 

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ScraperService extends Facade
{
	protected static function getFacadeAccessor() { return 'Scraper';}

}