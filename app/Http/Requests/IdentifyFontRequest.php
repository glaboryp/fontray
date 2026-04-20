<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdentifyFontRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|file|mimes:jpg,jpeg,png,gif,bmp,webp,pdf|max:10240',
        ];
    }
}
