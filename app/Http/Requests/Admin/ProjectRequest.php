<?php

namespace App\Http\Requests\Admin;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:50', Rule::unique('projects')->ignore($this?->project?->id)],
        ];
    }
}
