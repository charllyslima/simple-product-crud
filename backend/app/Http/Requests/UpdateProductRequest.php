<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'picture' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!$this->isBase64Image($value) && !$this->isExistingImage($value)) {
                        $fail('The ' . $attribute . ' must be a valid base64 encoded image or a valid existing image reference.');
                    }
                }
            ],
            'situation' => 'boolean',
        ];
    }

    protected function isBase64Image($value): false|int
    {
        return preg_match('/^data:image\/(jpeg|png|jpg|gif);base64,[A-Za-z0-9+\/=]+$/i', $value);
    }

    protected function isExistingImage($value): bool
    {
        // Assume that the $value is a filename and check if it exists in your storage.
        // Adjust the logic to match how you store and reference images.
        return file_exists(storage_path('app/private/pictures/' . $value));
    }
}
