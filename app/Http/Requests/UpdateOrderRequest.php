<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status'                  => ['required', Rule::in(OrderStatus::values())],
            'name'                    => 'required|string|max:255',
            'phone'                   => 'required|string|max:255',
            'email'                   => 'nullable|string|email|max:255',
            'delivery_address'        => 'nullable|string|max:255',
            'additional_requirements' => 'nullable|string|max:255',
            'total_price'             => 'nullable|numeric',
            'delivery_date'           => 'nullable|date',
        ];
    }
}
