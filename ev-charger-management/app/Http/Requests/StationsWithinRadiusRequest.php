<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StationsWithinRadiusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
            'company_id' => 'required|exists:company,id',
        ];
    }
}