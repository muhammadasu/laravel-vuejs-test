<?php

namespace App\Http\Requests\Property;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class updatePropertyRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'county'        => 'required|string',
            'country'       => 'required|string',
            'town'          => 'required|string',
            'postcode'      => 'required|string',
            'description'   => 'required|string',
            'address'       => 'required|string',
            'image'         => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'bedrooms'      => 'required|integer',
            'bathrooms'     => 'required|integer',
            'price'         => 'required|integer',
            'property_type' => 'required|integer|exists:property_types,id',
            'type'          => 'required|string',
        ];
    }


    /**
     * Failed Validation response
     *
     * @param Validator $validator [description]
     *
     * @return object
     */
    public function failedValidation(Validator $validator): object
    {
        throw new HttpResponseException(
            ApiResponse::validationFailure(
                'Error',
                $validator->errors()
            )
        );
    }
}
