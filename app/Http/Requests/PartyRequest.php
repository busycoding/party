<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartyRequest extends FormRequest
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
        $rules = [
            'title'        => 'required',
            'slug'         => 'required|unique:companies',
            'description'  => 'required',
            'category_id'  => 'required',
            'image'        => 'mimes:jpg,jpeg,bmp,png'
        ];

        switch($this->method()) {
            case 'PUT':
            case 'PATCH':
                // do 'php artisan route:list' and you will see we are using the {party} placeholder
                $rules['slug'] = 'required|unique:companies,slug,' . $this->route('party');
                break;
        }

        return $rules;

    }
}
