<?php

namespace App\Actions\Quizzes;

use App\Models\Quiz;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowQuizzes
{

    use AsAction;
    public function handle(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Quiz::whereHas('questions')
            ->withCount('questions')
            ->get();
    }

    public function asController(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "quizzes" => $this->handle(),
        ]);
    }

}
