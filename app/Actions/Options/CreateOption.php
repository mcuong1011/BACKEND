<?php

namespace App\Actions\Options;

use App\Models\Option;
use App\Models\Question;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateOption
{
    use AsAction, WithAttributes;

    public function handle($optionInput, Question $question = null)
    {
//        $this->validateAttributes();
//       use to validate the attributes
        $option = Option::create([
            "text" => $optionInput['text'],
            "correct" => $optionInput['correct']
        ]);
        $question?->options()->save($option);
        return $option;
    }
}
