<?php

namespace App\Http\Requests\Courier;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:couriers,phone_number|max:20',
            'vehicle_type' => 'required|string|max:50',
            'level' => 'required|integer|between:1,5',
            'is_active' => 'boolean'
        ];
    }
}