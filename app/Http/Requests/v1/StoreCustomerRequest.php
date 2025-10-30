<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method mixed input(string $key = null, mixed $default = null)
 * @method void merge(array $input)
 */
class StoreCustomerRequest extends FormRequest
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
            'name' => ['required'],
            'type' => ['required', Rule::in(['Individual', 'individual', 'Business', 'business'])],
            'email' => ['required', 'email', Rule::unique('customers', 'email')],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'postal_code' => ['required'], 
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'postal_code' => $this->input('postalCode'),
        ]);
    }
}
