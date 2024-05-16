<?php

namespace App\Actions\Quizzes;

use App\Models\Quiz;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateQuiz
{
    use AsAction;

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'string',
            'slug' => 'required|string',
        ];
    }

    public function handle($data)
    {
        return Quiz::create($data);
    }

    public function asController(ActionRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only(array_keys($this->rules()));
        $quiz = $this->handle($data);
        return response()->json(["quiz" => $quiz]);
    }
}
