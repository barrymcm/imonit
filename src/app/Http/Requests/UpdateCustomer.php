<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:100',
            'dob' => 'required|date|nullable',
            'gender' => [
                'required',
                Rule::in('male', 'female'),
            ],
            'phone' => 'required|string',
            'address_1' => 'required|string',
            'address_2' => 'required|string',
            'address_3' => 'string|nullable',
            'city' => 'required|string',
            'county' => 'required|string',
            'post_code' => 'required|string',
            'country' => 'required|string',
        ];
    }
}
