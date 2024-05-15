<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends APIController
{
    // luu question
    public function store(Request $request)
    {
        $validator = [
            'question.text' => 'required|string',
            'question.answer_explanation' => 'nullable|string',
            'options' => 'required|array',
            'options.*.text' => 'required|string',
            'options.*.correct' => 'required|boolean',
            'quiz_id' => 'required|exists:quizzes,id'
        ];
        $data = $request->validate($validator);
        $question = Question::create([
            'text' => $data['question']['text'],
            'answer_explanation' => $data['question']['answer_explanation'],
        ]);
        $options = $data['options'];
        collect($options)->each(function ($option) use ($question) {
            $option = Option::create([
                "text" => $option['text'],
                "correct" => $option['correct']
            ]);
            $question->options()->save($option);
        });
        $question->save();
        $quiz = Quiz::find($data['quiz_id']);
        $quiz->questions()->save($question);
        $quiz->save();
        $question->load('options');
        return $this->responseSuccess(["questions" => $question]);
    }

    public function edit(Request $request, $id)
    {
        $validator = [
            'question.text' => 'required|string',
            'question.answer_explanation' => 'nullable|string',
            'options' => 'required|array',
            'options.*.id' => 'required|exists:options,id',
            'options.*.text' => 'required|string',
            'options.*.correct' => 'required|boolean',
        ];
        $data = $request->validate($validator);
        $question = Question::findOrFail($id);
        $question->update([
            'text' => $data['question']['text'],
            'answer_explanation' => $data['question']['answer_explanation'],
        ]);
        $options = $data['options'];
        $options->each(function ($option) use ($question) {
            $option = Option::updateOrCreate([
                "id" => $option['id']
            ], [
                "text" => $option['text'],
                "correct" => $option['correct']
            ]);
            $question->options()->save($option);
        });
        $question->save();
        return $this->responseSuccess(["question" => $question]);
    }
}
