<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'specifications' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|max:2048';
        } else {
            $rules['image'] = 'nullable|image|max:2048';
        }

        return $rules;
    }
}