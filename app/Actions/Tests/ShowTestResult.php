<?php

namespace App\Actions\Tests;

use App\Models\Test;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowTestResult
{
    use AsAction;

    public function handle()
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
        return $tests;
    }

    public function asController()
    {
        return response()->json(["tests" => $this->handle()]);
    }
}
