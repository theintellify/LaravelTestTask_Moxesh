<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisingSectionUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'stadium_id' => 'required|exists:stadiums,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'sometimes|nullable|mimes:jpg,jpeg,png,mp4,mp3|max:10240',
            'status' => 'required|in:active,inactive',
            // Add any other validation rules as needed
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name must not exceed :max characters.',
            'description.string' => 'The description must be a string.',
            'status.required' => 'The status field is required.',
            'status.in' => 'Invalid status. Please select either active or inactive.',
            // Add custom messages for other rules as needed
        ];
    }
}
