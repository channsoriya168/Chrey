<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:products,code',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price_percent' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'size' => 'required|in:តូច,មធ្យម,ធំ',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'ឈ្មោះផលិតផលត្រូវបានទាមទារ។',
            'code.required' => 'លេខកូដផលិតផលត្រូវបានទាមទារ។',
            'code.unique' => 'លេខកូដផលិតផលត្រូវតែមានតែមួយគត់។',
            'price.required' => 'តម្លៃត្រូវបានទាមទារ។',
            'price.numeric' => 'តម្លៃត្រូវតែជាលេខ។',
            'stock.required' => 'ចំនួនស្តុកត្រូវបានទាមទារ។',
            'stock.integer' => 'ចំនួនស្តុកត្រូវតែជាចំនួនគត់។',
            'size.required' => 'ទំហំត្រូវបានទាមទារ។',
            'size.in' => 'ទំហំត្រូវតែមានតែមួយក្នុងចំណោម: តូច, មធ្យម, ធំ។',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'images.*.max' => 'Each image must not exceed 2048 kilobytes.',
        ];
    }
}
