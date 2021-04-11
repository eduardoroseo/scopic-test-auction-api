<?php

namespace App\Http\Requests;

use App\Models\AutoBidConfig;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class SaveAutoBidConfigRequest extends FormRequest
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
            'auto_bidding_max_amount' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $autoBidConfig = AutoBidConfig::where('user_id', $this->user()->id)->first();

                    if ($autoBidConfig && $value <= $autoBidConfig->auto_bidding_current_amount) {
                        $fail('The '.
                            Str::of($attribute)->replace('_', ' ').
                            ' must to be higher than used current amount.');
                    }
                },
            ]
        ];
    }
}
