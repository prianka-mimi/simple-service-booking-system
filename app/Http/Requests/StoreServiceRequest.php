<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required_with:price,description|required_without_all|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required_with:name,description|numeric|min:0',
            'status'      => 'nullable|in:' . implode(',', array_keys(Service::STATUS_LIST)),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required_with'        => 'The name field is required when price and description are present.',
            'name.required_without_all' => 'At least one of the name, price, and description fields is required.',
            'price.required_with'       => 'The price field is required when name and description are present.',
        ];
    }
}
