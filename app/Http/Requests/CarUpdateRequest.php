<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CarUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'owner' => 'required|string|max:255',
            'registration_number' => 'required|regex:/^[A-Z]{2}\d{4}[A-Z]{2}$/',
            'color' => 'required|string|max:255',
            'vin_code' => 'required|regex:/^[A-HJ-NPR-Z0-9]{17}$/',
            'make' => 'required|string|max:255',
            'car_model' => 'required|string|max:255',
            'year' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'owner.required' => 'The "Name" field is required.',
            'owner.string' => 'The "Name" field must be a string.',
            'owner.max' => 'The "Name" field cannot be longer than 255 characters.',
            'registration_number.required' => 'The "Registration number" field is required.',
            'registration_number.regex' => 'Invalid registration number format.',
            'color.required' => 'The "Color" field is required.',
            'color.string' => 'The "Color" field must be a string.',
            'color.max' => 'The "Color" field cannot be longer than 255 characters.',
            'vin_code.required' => 'The "VIN code" field is required.',
            'vin_code.regex' => 'Invalid VIN code format.',
            'make.required' => 'The "Make" field is required.',
            'make.string' => 'The "Make" field must be a string.',
            'make.max' => 'The "Make" field cannot be longer than 255 characters.',
            'car_model.required' => 'The "Car Model" field is required.',
            'car_model.string' => 'The "Car Model" field must be a string.',
            'car_model.max' => 'The "Car Model" field cannot be longer than 255 characters.',
            'year.required' => 'The "Model Year" field is required.',
            'year.string' => 'The "Model Year" field must be a integer.',
        ];
    }
}
