<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealershipCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'domain' => 'required|unique:domains',
            'url' => 'required|url',
            'locations' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'domain' => $this->domain . '.' . config('tenancy.central_domains')[0],
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
