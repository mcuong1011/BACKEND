<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends APIController
{
    public function index()
    {
        $quiz = Quiz::whereHas('questions')
            ->withCount('questions')
            ->get();
        return $this->responseSuccess([
            "quizzes" => $quiz,
        ]);
    }

    public function show($id)
    {
        $quiz = Quiz::findOrFail($id)->with('questions.options');
        return $this->responseSuccess([
            'quiz' => Quiz::with('questions.options')->find($id)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'slug' => 'required|string',
        ]);
        return $this->responseSuccess(["quiz" => Quiz::create($data)]);
    }

    public function edit(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string',
            'description' => 'string',
            'slug' => 'string',
        ]);
        $quiz = Quiz::findOrFail($id);
        $quiz->update($data);
        $this->responseSuccess($quiz);
    }
}
