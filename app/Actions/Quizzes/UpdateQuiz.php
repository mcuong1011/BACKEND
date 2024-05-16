<?php

namespace App\Actions\Quizzes;

use App\Actions\Questions\CreateQuestion;
use App\Actions\Questions\UpdateQuestion;
use App\Models\Question;
use App\Models\Quiz;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateQuiz
{
    use AsAction;

    public function rules(): array
    {
        return [
            'title' => 'string',
            'description' => 'string',
            'slug' => 'string',
            'questions' => 'array',
        ];
    }

    public function handle(Quiz $quiz, $data)
    {
        $quiz->update($data);
        if (isset($data['questions'])) {
            $questions = $data['questions'];
            collect($questions)->each(function ($question) use ($quiz) {
                if (!isset($question['id'])) {
                    CreateQuestion::run($question, $quiz);
                    return;
                }
                UpdateQuestion::run(Question::findOrFail($question['id']), $question);
            });
        }
        return $quiz;
    }

    public function asController(ActionRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only(["title", "description", "slug", "questions"]);

        $quiz = Quiz::findOrFail($request->route('id'));
        $quiz = $this->handle($quiz, $data);
        $quiz->load('questions.options');
        return response()->json(["quiz" => $quiz]);
    }

}
