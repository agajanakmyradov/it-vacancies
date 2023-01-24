<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
                [
                    'title' => 'Frontend',
                ],
                [
                    'title' => 'Backend',
                ],
                [
                    'title' => 'Fullstack',
                ],
                [
                    'title' => '.NET',
                ],
                [
                    'title' => 'python',
                ],
                [
                    'title' => 'ASP.NET',
                ],
                [
                    'title' => 'Assembler',
                ],
                [
                    'title' => 'C#',
                ],
                [
                    'title' => 'C++',
                ],
                [
                    'title' => 'Delphi',
                ],
                [
                    'title' => 'Java',
                ],
                [
                    'title' => 'JavaScript',
                ],
                [
                    'title' => 'PHP',
                ],
                [
                    'title' => 'Ruby',
                ],
                [
                    'title' => 'Scala',
                ],
                [
                    'title' => 'SQL',
                ],
                [
                    'title' => 'Typescript',
                ],                
            ]);
    }
}
