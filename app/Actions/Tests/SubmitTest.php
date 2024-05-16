<?php

namespace App\Actions\Tests;

use App\Exceptions\ApiException;
use App\Models\Test;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class SubmitTest
{
    use AsAction;

    public function rules()
    {
        return [
            'test_id' => 'required|exists:tests,id',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.option_id' => 'required|exists:options,id',
        ];
    }

    /**
     * @throws ApiException
     */
    public function handle($testId, $answers)
    {
        try {
            $test = Test::findOrFail($testId);
            $result = CalculateTestResult::run($answers, $test);
            $test->result = $result;
            $test->save();
        } catch (\Throwable $exception) {
            throw new ApiException("Có lỗi xảy ra khi nộp bài, vui lòng thử lại");
        }
        return $test;
    }

    /**
     * @throws ApiException
     */
    public function asController(ActionRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only(["test_id", "answers"]);
        $test = $this->handle($data['test_id'], $data['answers']);
        return response()->json(['test' => $test]);
    }

}
