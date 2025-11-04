<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method mixed input(string $key = null, mixed $default = null)
 * @method void merge(array $input)
 * @method string method()
 */
class UpdateCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        
        if ($method == 'PUT') {
            return [
                'name' => ['required'],
                'type' => ['required', Rule::in(['Individual', 'individual', 'Business', 'business'])],
                'email' => ['required', 'email', Rule::unique('customers', 'email')],
                'address' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'postal_code' => ['required'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'required'],
                'type' => ['sometimes', 'required', Rule::in(['Individual', 'individual', 'Business', 'business'])],
                'email' => ['sometimes', 'required', 'email', Rule::unique('customers', 'email')],
                'address' => ['sometimes', 'required'],
                'city' => ['sometimes', 'required'],
                'state' => ['sometimes', 'required'],
                'postal_code' => ['sometimes', 'required'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->input('postalCode')) {
            $this->merge([
                'postal_code' => $this->input('postalCode'),
            ]);
        }
    }
}
