<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MultiplicationTableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'size' => 'required|integer|between:1,100',
        ];
    }
}
