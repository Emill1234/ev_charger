<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parent_company_id' => 'nullable|exists:company,id',
            'name' => 'required|string|max:255',
        ];
    }
}
