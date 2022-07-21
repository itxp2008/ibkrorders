<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'symbol' => 'required',
            'conid' => 'required',
            'sec' => 'required',
            'info' => 'required',
            'type' => 'required',
            'bar' => 'required',
            'side' => 'required',
            'qty' => 'required|numeric',
            'stop' => 'required|numeric',
            'limit' => 'required_if:type,STOP-LIMIT|nullable|numeric',
            'trailing' => 'required|boolean',
            'stop_offset' => 'required_if:trailing,1|nullable|numeric',
            'limit_offset' => 'required_if:trailing,1|required_if:type,STOP-LIMIT|nullable|numeric'
        ];
    }
}
