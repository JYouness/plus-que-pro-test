<?php

namespace App\Http\Requests\Movies;

use Illuminate\Foundation\Http\FormRequest;

abstract class MovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max: 50'],
            'original_title' => ['nullable', 'string', 'max:50'],
            'original_language' => ['required', 'string', 'in:en,fr,es,ar'],
            //'genres' => ['required', 'string', 'max: 50'],
            'release_date' => ['required', 'date:m/d/y'],
            'overview' => ['required', 'string'],
        ];
    }
}
