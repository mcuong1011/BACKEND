<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Test;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $query = Quiz::whereHas('questions')
            ->withCount('questions')
            ->when(auth()->guest() || !auth()->user()->is_admin, function ($query) {
                return $query->where('published', 1);
            })
            ->get();

        $public_quizzes = $query->where('public', 1);
        $registered_only_quizzes = $query->where('public', 0);

        return view('home', compact('public_quizzes', 'registered_only_quizzes'));
    }

    public function show(Quiz $quiz, Request $request)
    {
        $test = Test::query()
            ->where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->first();
        if ($test && $this->isSubmitedTest($test)) {

            return redirect()->route('results.show', $test);
        } else {
            if ($test === null) {
                $test = Test::create([
                    'user_id' => auth()->id(),
                    'quiz_id' => $quiz->id,
                    'result' => 0,
                    'ip_address' => request()->ip(),
                ]);
            }
        }
        $totalSecondsLeft = now()->diffInSeconds($test->created_at->addMinutes($quiz->limited_time));
        $minutesLeft = intdiv($totalSecondsLeft, 60);
        $secondsLeft = $totalSecondsLeft % 60;
        if ($minutesLeft <= 0 && $secondsLeft <= 0) {
            $test->update([
                'result' => $test->hasCorrectAnswer()->count(),
                'time_spent' => $minutesLeft
            ]);
            return redirect()->route('results.show', $test);
        }
        $questions = $quiz->questions()->with('options')->get();
        return view('front.quizzes.show', compact('quiz', 'questions', 'test', 'minutesLeft', 'secondsLeft'));
    }

    public function isSubmitedTest(Test $test)
    {
        return $test->time_spent !== null;
    }
}
