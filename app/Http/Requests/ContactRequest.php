<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name_top' => 'required',
            'name_bottom' => 'required',
            // 'name_sub_top' => 'required',
            // 'name_sub_top' => [ function ($attribute, $value, $fail) {
            //                   if (preg_match('/[^ァ-ンー]/u', $value) !== 0) {
            //                    return $fail('カタカナで入力してください');
            //                     }
            //                   }
            //                 ],
            // 'name_sub_bottom' => 'required',
            // 'name_sub_bottom' => [ function ($attribute, $value, $fail) {
            //                   if (preg_match('/[^ァ-ンー]/u', $value) !== 0) {
            //                    return $fail('カタカナで入力してください');
            //                     }
            //                   }
            //                 ],
            'mail' => 'required',
            // 'mail' => 'required | confirmed',
            // 'type' => 'not_in:select',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_top.required' => '姓を入力してください',
            'name_bottom.required' => '名を入力してください',
            // 'name_sub_top.required' => 'フリガナ セイを入力してください',
            // 'name_sub_bottom.required' => 'フリガナ メイを入力してください',
            'mail.required' => 'メールアドレスを入力してください',
            // 'mail.confirmed' => '確認用メールアドレスが一致しません',
            // 'type.not_in' => 'お問い合わせ種類が選択されていません。',
            'content.required' => 'お問い合わせを入力してください',
        ];
    }
}
