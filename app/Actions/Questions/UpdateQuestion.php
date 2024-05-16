<?php

namespace App\Actions\Questions;

use App\Actions\Options\UpdateOption;
use App\Models\Question;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateQuestion
{
    use AsAction;

    public function rules(): array
    {
        return [
            'question.text' => 'string',
            'question.answer_explanation' => 'nullable|string',
            'options' => 'array',
        ];
    }

    public function handle(Question $question, $data)
    {
        $question->updateOrInsert([
            'text' => $data['question']['text'],
            'answer_explanation' => $data['question']['answer_explanation'],
        ]);
        $options = $data['options'];
        collect($options)->each(function ($option) use ($question) {
            UpdateOption::run($option)->question()->associate($question)->save();
        });
        return $question;
    }

    public function asController(ActionRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only(["question", "options"]);
        $question = Question::findOrFail($request->route('id'));
        $question = $this->handle($question, $data);
        $question->load('options');
        return response()->json(["questions" => $question]);
    }
}
