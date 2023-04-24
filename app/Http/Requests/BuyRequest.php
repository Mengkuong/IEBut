<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyRequest extends FormRequest
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
            'name_seller' => ['required'],
            'price_buy' => ['required'],
            'shares' => ['required'],
            'phone_number_buyer' => ['required'],
            'phone_number_seller' => ['required'],
            'date_buy' => ['required'],
//            'buy_form' => ['required'],
        ];
    }
}
