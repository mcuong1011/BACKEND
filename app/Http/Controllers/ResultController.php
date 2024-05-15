<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Test;

class ResultController extends APIController
{
    public function show($id)
    {
        $test = Test::find($id);
        $questions_count = $test->quiz->questions->count();
        $results = Answer::where('test_id', $test->id)
            ->with('question.options')
            ->get();
        if (!$test->quiz->public) {
            $leaderboard = Test::query()
                ->where('quiz_id', $test->quiz_id)
                ->whereHas('user')
                ->with(['user' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->orderBy('result', 'desc')
                ->orderBy('time_spent')
                ->get();
            return $this->responseSuccess([
                "test" => $test,
                "questions_count" => $questions_count,
                "results" => $results,
                "leaderboard" => $leaderboard
            ]);
        }
        return $this->responseSuccess([
            "test" => $test,
            "questions_count" => $questions_count,
            "results" => $results
        ]);
    }
}
