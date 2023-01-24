<?php

namespace App\Console\Commands;

use Illuminate\Console\Command; 
use Scraper;
use App\Models\Vacancy;


class ScrapeVacanciesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:vacancies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scrape it vacancies from another websites';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    { 
        Vacancy::all()->each->delete();

        Scraper::scrape();

        $this->info('The command was successful!');
    }
}
