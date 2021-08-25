<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|max:70',
            'image' => 'image|nullable',
            'body' => 'required',
            'start_datetime' => 'required',
            'ticket_price' => 'integer|nullable',

        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'タイトルの入力は必須です。',
            'start_datetime.required' => 'スタート時間の入力は必須です。',
            'body.required' => '内容の入力は必須です。'
        ];
    }
}
