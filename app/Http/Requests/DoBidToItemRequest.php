<?php

namespace App\Http\Requests;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class DoBidToItemRequest extends FormRequest
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
            'bid_price' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($this->item->price > $value) {
                        $fail('The '.
                            str_replace('_', ' ', $attribute) .
                            ' must to be greater than current bid.');
                    }
                }
            ],
            'auto_bidding' => [
                'sometimes',
                'accepted'
            ]
        ];
    }
}
