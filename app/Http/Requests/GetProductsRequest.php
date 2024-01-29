<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        ];
    }
}
