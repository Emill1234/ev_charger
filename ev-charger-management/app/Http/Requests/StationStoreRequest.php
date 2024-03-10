<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StationStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'company_id' => 'required|exists:company,id',
            'address' => 'required|string|max:255',
        ];
    }
}