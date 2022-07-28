<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostOrderRequest extends FormRequest
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
            //
            'acctId' => 'required',
            'conid' => 'required|numeric',
            'orderType' => 'required',
            'side' => 'required',
            'quantity' => 'required|numeric',
            'tif' => 'required',
            'price' => 'nullable|numeric|required_if:orderType,LMT,STP,STOP_LIMIT',
            'auxPrice' => 'nullable|numeric|required_if:orderType,STOP_LIMIT',
            'outside_rth' => 'boolean|required'
        ];
    }
}