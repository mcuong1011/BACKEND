<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        Quiz::factory(20)->create()->each(function ($quiz) {
            $question = Question::factory(10)->create()->each(function ($question) {
                Option::factory(3)->create(['question_id' => $question->id]);
            });
            $quiz->questions()->attach($question);
        });
    }
}
