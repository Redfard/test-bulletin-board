<?php

namespace App\Http\Requests;


class CreateAdvertRequest extends FormRequest
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
            'title'       => 'required|max:200',
            'description' => 'required|max:1000',
            'photos'      => 'required|array|max:3',
            'price'       => 'required|numeric',
        ];
    }
}
