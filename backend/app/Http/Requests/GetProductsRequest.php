<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class GetProductsRequest extends FormRequest
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
            'page' => 'integer|min:0',
            'limit' => 'integer|min:0|max:50',
            'name' => 'string|max:20|min:1',
            'from_variant_price' => 'numeric|min:0',
            'to_variant_price' => 'numeric|min:0|after_or_equal:from_variant_price',
            'valid_from' => 'date',
            'valid_to' => 'date|after:valid_from',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => [
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ],
        ], JsonResponse::HTTP_BAD_REQUEST));
    }
}
