<?php

namespace App\Actions\Quizzes;

use App\Models\Quiz;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowQuiz
{
    use AsAction;

    public function handle($id)
    {
        return Quiz::findOrFail($id)->with('questions.options');
    }

    public function asController($id): \Illuminate\Http\JsonResponse
    {
        $quiz = $this->handle($id);
        return response()->json(["quiz" => $quiz]);
    }
}
