<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'ឈ្មោះផលិតផលត្រូវបានទាមទារ។',
            'name.max' => 'ឈ្មោះផលិតផលមិនអាចលើសពី 255 តួអក្សរ។',
            'code.required' => 'លេខកូដផលិតផលត្រូវបានទាមទារ។',
            'code.unique' => 'លេខកូដផលិតផលត្រូវតែមានតែមួយគត់។',
            'code.max' => 'លេខកូដផលិតផលមិនអាចលើសពី 255 តួអក្សរ។',
            'description.string' => 'ការពិពណ៌នាត្រូវតែជាអក្សរ។',
            'price.required' => 'តម្លៃត្រូវបានទាមទារ។',
            'price.numeric' => 'តម្លៃត្រូវតែជាលេខ។',
            'price.min' => 'តម្លៃត្រូវតែធំជាងឬស្មើ 0។',
            'discount_price_percent.numeric' => 'ភាគរយបញ្ចុះតម្លៃត្រូវតែជាលេខ។',
            'discount_price_percent.min' => 'ភាគរយបញ្ចុះតម្លៃត្រូវតែធំជាងឬស្មើ 0។',
            'discount_price_percent.max' => 'ភាគរយបញ្ចុះតម្លៃត្រូវតែតូចជាងឬស្មើ 100។',
            'stock.required' => 'ចំនួនស្តុកត្រូវបានទាមទារ។',
            'stock.integer' => 'ចំនួនស្តុកត្រូវតែជាចំនួនគត់។',
            'stock.min' => 'ចំនួនស្តុកត្រូវតែធំជាងឬស្មើ 0។',
            'size.required' => 'ទំហំត្រូវបានទាមទារ។',
            'size.in' => 'ទំហំត្រូវតែជា: តូច, មធ្យម, ឬធំ។',
            'images.*.image' => 'ឯកសារត្រូវតែជារូបភាព។',
            'images.*.mimes' => 'រូបភាពត្រូវតែមានប្រភេទ: jpeg, png, jpg, gif, svg, webp។',
            'images.*.max' => 'រូបភាពមិនអាចលើសពី 2MB។',
        ];
    }
}
