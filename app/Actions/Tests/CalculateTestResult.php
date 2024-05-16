<?php

namespace App\Actions\Tests;

use App\Models\Answer;
use App\Models\Option;
use App\Models\Test;
use Lorisleiva\Actions\Concerns\AsAction;

class CalculateTestResult
{
    use AsAction;

    private function handle($answers, Test $test)
    {
        $result = 0;
        foreach ($answers as $answer) {
            if (Option::find($answer["option_id"])->correct) {
                $result++;
                Answer::updateOrCreate(
                    [
                        'question_id' => $answer["question_id"],
                        'option_id' => $answer["option_id"]
                    ],
                    [
                        'user_id' => auth()->id(),
                        'test_id' => $test->id,
                        'correct' => true,
                    ]
                );
            } else {
                Answer::updateOrCreate(
                    [
                        'question_id' => $answer["question_id"],
                        'option_id' => $answer["option_id"]
                    ],
                    [
                        'user_id' => auth()->id(),
                        'test_id' => $test->id,
                        'correct' => false,
                    ]
                );
            }
        }
        return $result;
    }

}
