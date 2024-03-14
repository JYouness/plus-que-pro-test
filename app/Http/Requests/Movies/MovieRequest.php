<?php

declare(strict_types=1);

namespace App\Http\Requests\Movies;

use App\Models\MovieGenre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class MovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max: 50'],
            'original_title' => ['nullable', 'string', 'max:50'],
            'original_language' => ['required', 'string', 'in:en,fr,es,ar'],
            'genre_ids' => ['required', 'array', 'min:1', 'max:5', Rule::exists(MovieGenre::class, 'tmbd_id')],
            'release_date' => ['required', 'date:m/d/y'],
            'overview' => ['required', 'string'],
        ];
    }
}
