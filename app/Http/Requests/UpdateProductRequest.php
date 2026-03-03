<?php

namespace App\Http\Requests;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'stocks' => 'required|array|min:1',
            'stocks.*.size' => 'required|string',
            'stocks.*.color' => 'required|string',
            'stocks.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('keywords.name'),
            'description' => __('keywords.description'),
            'price' => __('keywords.price'),
            'category_id' => __('keywords.category'),
            'image' => __('keywords.image'),
        ];
    }
}
