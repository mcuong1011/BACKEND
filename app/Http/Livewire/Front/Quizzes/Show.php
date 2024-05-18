<?php

namespace App\Http\Livewire\Front\Quizzes;

use App\Models\Question;
use App\Models\Option;
use App\Models\Quiz;
use App\Models\Test;
use App\Models\Answer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class Show extends Component
{
    public Quiz $quiz;

    public Collection $questions;
    public int $questionCount;
    public Collection $questionsState;
    public int $currentPage = 1;
    public int $currentQuestionsIndex = 1;
    public int $minutesLeft;
    public int $secondsLeft;
    public array $answersOfQuestions = [];
    public $anwsers;

    public Test $test;

    public function mount()
    {
        $this->questions->each(function ($question) {
            $this->answersOfQuestions[$question->id] = Answer::query()
                ->where('question_id', $question->id)
                ->where('test_id', $this->test->id)
                ->where('user_id', auth()->id())->first()->option_id ?? null;
        });
    }

    public function updating()
    {
    }

    public function updatedAnswersOfQuestions($value, $questionId)
    {
        Answer::updateOrCreate([
            'user_id' => auth()->id(),
            'test_id' => $this->test->id,
            'question_id' => $questionId,
        ], [
            'option_id' => $value,
            'correct' => Option::find($value)->correct
        ]);
    }

    public
    function getQuestionsCountProperty(): int
    {
        return $this->questions->count();
    }

    public
    function submit()
    {
        $test = Test::updateOrCreate([
            'user_id' => auth()->id(),
            'quiz_id' => $this->quiz->id,
        ], [
            'result' => 0,
            'ip_address' => request()->ip(),
        ]);
        Test::where('user_id', auth()->id())
            ->where('quiz_id', $this->quiz->id)
            ->update([
                'result' => $test->hasCorrectAnswer()->count(),
                'time_spent' => $this->quiz->limited_time - now()->diffInMinutes($test->created_at->addMinutes($this->quiz->limited_time)),
            ]);
        return to_route('results.show', ['test' => $test]);
    }

    public
    function render(): View
    {
        return view('livewire.front.quizzes.show');
    }
}
