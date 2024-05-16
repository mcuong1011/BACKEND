<?php

namespace App\Actions\Tests;

use App\Models\Test;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RegisterTest
{
    use AsAction;

    public function rules()
    {
        return ['quiz_id' => 'required|exists:quizzes,id'];
    }

    public function handle($quizId)
    {
        return Test::create([
            'quiz_id' => $quizId,
            'user_id' => auth()->id(),
        ]);
    }

    public function asController(ActionRequest $actionRequest): \Illuminate\Http\JsonResponse
    {
        $test = $this->handle($actionRequest->quiz_id);
        return response()->json(['test' => $test]);
    }
}
