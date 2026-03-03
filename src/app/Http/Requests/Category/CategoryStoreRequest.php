<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,NULL,id,deleted_at,NULL',
            'parent_id' => 'nullable|integer|exists:categories,id',
        ];
    }

    /**
     * Prepare the data for validation.
     * Sanitize input to prevent XSS attacks
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => strip_tags($this->input('name')),
            ]);
        }

        if ($this->has('slug')) {
            $this->merge([
                'slug' => strip_tags($this->input('slug')),
            ]);
        }

        if ($this->has('parent_id')) {
            $parentId = $this->input('parent_id');
            $this->merge([
                'parent_id' => $parentId !== null ? (int) $parentId : null,
            ]);
        }
    }
}
