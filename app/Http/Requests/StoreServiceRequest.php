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
            'name'        => 'required_with:price,description|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required_with:name,description|numeric|min:0',
            'status'      => 'nullable|in:' . implode(',', array_keys(Service::STATUS_LIST)),
        ];
    }
}
