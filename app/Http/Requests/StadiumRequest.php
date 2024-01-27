<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StadiumRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'file' => 'required|file|max:10240', // Adjust max file size as needed (in kilobytes)
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
            'file.required' => 'The 3D object file is required.',
            'file.file' => 'Invalid file.',
            'file.max' => 'File size must not exceed :max kilobytes.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'file' => $this->validateFileType($this->file('file')),
        ]);
    }

    protected function validateFileType($file)
    {
        // If the file is null, consider it valid (not required to be present when not updating)
        if ($file === null || !$file instanceof UploadedFile) {
            return null;
        }

        $allowedExtensions = ['obj', 'stl', 'gltf', 'fbx'];

        if ($file->isValid() && in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
            return $file;
        }

        return null;
    }
}
