<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
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
        $category = $this->route('category');
        $categoryId = $category instanceof Category ? (int) $category->id : (int) $category;

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->ignore($categoryId)
                    ->whereNull('deleted_at'),
            ],
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
