<?php

namespace App\Http\Requests\Courier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courierId = $this->route('courier')->id;

        return [
            'name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:20|unique:couriers,phone_number,' . $courierId,
            'vehicle_type' => 'sometimes|required|string|max:50',
            'level' => 'sometimes|required|integer|between:1,5',
            'is_active' => 'boolean'
        ];
    }
}