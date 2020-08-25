<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => "required",
            "price" => "required|integer",
            "quantity" => "required|integer",
            "author" => "required|exists:authors,id",
            "publisher" => "required|exists:publishers,id",
            "warehouse" => "required|exists:warehouses,id"
        ];
    }
}
