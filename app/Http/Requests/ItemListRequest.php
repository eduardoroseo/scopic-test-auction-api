<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemListRequest extends FormRequest
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
            'search' => 'sometimes|nullable|string',
            'orderByPrice' => [
                'sometimes',
                'nullable',
                Rule::in('asc', 'desc')
            ]
        ];
    }

    public function messages()
    {
        return [
            'orderByPrice.in' => 'The selected order by price must to be \'asc\' or \'desc\'.'
        ];
    }
}
