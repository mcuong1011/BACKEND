<?php

namespace App\Actions\Options;

use App\Models\Option;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\WithAttributes;

class UpdateOption
{
    use AsAction;
    use WithAttributes;

    public function rules(): array
    {
        return [
            'id' => 'exists:options,id',
            'text' => 'string',
            'correct' => 'boolean',
        ];
    }

    public function handle($data): Collection|Option|Model|null
    {
        $this->fill($data);
        $input = new Fluent($this->validateAttributes());
//        $input->id or input["id"]
        return Option::updateOrCreate([
            "id" => $input['id']
        ], [
            "text" => $input['text'],
            "correct" => (bool)$input['correct']
        ]);
    }
}
