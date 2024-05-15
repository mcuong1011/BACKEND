<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Answer;
use App\Models\Option;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends APIController
{
    public function store(Request $request)
    {
        // bắt đầu làm bài thi
        $data = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
        ]);
        $test = Test::create([
            'quiz_id' => $data['quiz_id'],
            'user_id' => auth()->id(),
        ]);
        return $this->responseSuccess(["test" => $test, "message" => "Bắt đầu làm bài thi"]);
        // tính kết quả
    }

    /**
     * @throws ApiException
     */
    public function submitTest(Request $request)
    {
        $data = $request->validate([
            'test_id' => 'required|exists:tests,id',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.option_id' => 'required|exists:options,id',
        ]);
        try {
            $test = Test::find($data["test_id"]);
            $result = $this->calculateResult($data["answers"], $test);
            $test->result = $result;
            $test->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
            throw new ApiException("Có lỗi xảy ra khi nộp bài, vui lòng thử lại");
        }
        return $this->responseSuccess(["message" => "Nộp bài thành công", "test" => Test::find($data["test_id"])]);
    }

    private function calculateResult($answers, $test)
    {
        $result = 0;
        foreach ($answers as $answer) {
            if (Option::find($answer["option_id"])->correct) {
                $result++;
                Answer::updateOrCreate(
                    [
                        'question_id' => $answer["question_id"],
                        'option_id' => $answer["option_id"]
                    ],
                    [
                        'user_id' => auth()->id(),
                        'test_id' => $test->id,
                        'correct' => true,
                    ]
                );
            } else {
                Answer::updateOrCreate(
                    [
                        'question_id' => $answer["question_id"],
                        'option_id' => $answer["option_id"]
                    ],
                    [
                        'user_id' => auth()->id(),
                        'test_id' => $test->id,
                        'correct' => false,
                    ]
                );
            }
        }
        return $result;
    }

    public function getMyResults()
    {
        $tests = Test::where('user_id', auth()->id())
            ->with(['quiz' => function ($query) {
                $query->select('id', 'title', 'description');
                $query->withCount('questions')
                    ->with('questions.options');
            }])
            ->withCount('answers')
            ->orderBy('created_at', 'desc')
            ->get();
        return $this->responseSuccess(["tests" => $tests]);
    }

    public function getLeaderBoard($quiz_id = 0)
    {
        $tests = Test::query()
            ->whereHas('user')
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }, 'quiz' => function ($query) {
                $query->select('id', 'title');
                $query->withCount('questions');
            }])
            ->when($quiz_id > 0, function ($query) use ($quiz_id) {
                $query->where('quiz_id', $quiz_id);
            })
            ->orderBy('result', 'desc')
            ->orderBy('time_spent')
            ->get();
    }
}
