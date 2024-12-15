<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
            'country_id'        => 'required',
            'timezone_id'       => 'required',
            'currency_id'       => 'required',
            'printer_id'        => 'required',
            'name'              => 'required',
            'code'              => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'zip_code'          => 'required',
            'address'           => 'required',
            'after_sell'        => 'required',
            'tax'               => 'required',
            'zakat'             => 'required',
            'sound'             => 'required',
            'currency_position' => 'required'
        ];
    }
}
