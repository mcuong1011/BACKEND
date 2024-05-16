<?php

namespace App\Actions\Questions;

use App\Actions\Options\CreateOption;
use App\Models\Question;
use App\Models\Quiz;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateQuestion
{
    use AsAction;
    use WithAttributes;

    public function handle($input, Quiz $quiz)
    {
        $question = Question::create([
            'text' => $input['question']['text'],
            'answer_explanation' => $input['question']['answer_explanation'],
        ]);
        $options = $input['options'];
        collect($options)->each(function ($option) use ($question) {
            CreateOption::run($option, $question);
        });
        $quiz->questions()->save($question);
        $question->load('options');
        return $question;
    }

    public function rules(): array
    {
        return [
            'question' => ['required'],
            'question.text' => ['required', 'string'],
            'question.answer_explanation' => ['nullable', 'string'],
            'options' => ['required', 'array'],
            'options.*.text' => ['required', 'string'],
            'options.*.correct' => ['required', 'boolean'],
            'quiz_id' => ['required', 'exists:quizzes,id'],
        ];
    }

    public function asController(ActionRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only(["question", "options", "quiz_id"]);
        $quiz = Quiz::find($data['quiz_id']);
        $question = $this->handle($data, $quiz);
        return response()->json(["questions" => $question]);
    }
}
