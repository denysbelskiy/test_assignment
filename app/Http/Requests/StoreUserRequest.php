<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|email:rfc,dns|unique:users,email|max:250',
            'phone' => 'required|string|regex:/^380\d{9}$/|unique:users,phone',
            'position_id' => 'required|integer|exists:positions,id',
            'photo' => [
                'required',
                'mimes:jpg,jpeg',
                'max:5120',
                Rule::dimensions()
                    ->minHeight(70)
                    ->minWidth(70),
            ],
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'The phone format is invalid',
            'position_id.exists' => 'Selected position id does not exist',
            'photo.mimes' => 'Only JPEG and JPG formats are allowed.',
            'photo.max' => 'The image size must not exceed 5MB.',
            'photo.dimensions' => 'The image must be at least 70x70 pixels.',
        ];
    }
}
