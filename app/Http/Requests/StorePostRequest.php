<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => 'required',
            'status' => 'required',
            'amount' => 'required',
            'order' => 'nullable|integer',
            'order_date' => 'required',
            'share_holders_json' => 'nullable',
            'content' => 'nullable',
            'categories' => 'required'
        ];
    }
}
