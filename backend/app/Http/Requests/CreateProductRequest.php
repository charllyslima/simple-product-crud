<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'picture' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    // Validar se é uma imagem em base64
                    if (!preg_match('/^data:image\/(jpeg|png|jpg|gif);base64,[A-Za-z0-9+\/=]+$/i', $value)) {
                        $fail('The ' . $attribute . ' is not a valid base64 encoded image.');
                    }
                }
            ],
            'situation' => 'boolean',
        ];
    }
}
