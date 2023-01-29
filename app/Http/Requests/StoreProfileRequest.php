<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:20|unique:profiles',
            'img' => 'nullable|string|url|max:255',
            'address' => 'nullable|string|max:25',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'zipcode' => 'nullable|string|max:20',
            'available' => 'boolean',
            'friends' => 'nullable|array',
        ];
    }
}
