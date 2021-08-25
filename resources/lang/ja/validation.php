<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeは正しいURLではありません。',
    'after'                => ':attributeは:date以降の日付にしてください。',
    'after_or_equal'       => ':attributeは:date以降の日付にしてください。',
    'alpha'                => ':attributeは英字のみにしてください。',
    'alpha_dash'           => ':attributeは英数字とハイフンのみにしてください。',
    'alpha_num'            => ':attributeは英数字のみにしてください。',
    'array'                => ':attributeは配列にしてください。',
    'before'               => ':attributeは:date以前の日付にしてください。',
    'before_or_equal'      => ':attributeは:date以前の日付にしてください。',
    'numeric' => ':attributeは数値で入力してください。',
    'between'              => [
        'file'    => ':attributeは:min〜:max KBまでのファイルにしてください。',
        'string'  => ':attributeは:min〜:max文字にしてください。',
        'array'   => ':attributeは:min〜:max個までにしてください。',
    ],
    'boolean'              => ':attributeはtrueかfalseにしてください。',
    'confirmed'            => ':attributeは確認用項目と一致していません。',
    'date'                 => ':attributeは正しい日付ではありません。',
    'date_format'          => ':attributeは":format"書式と一致していません。',
    'different'            => ':attributeは:otherと違うものにしてください。',
    'digits'               => ':attributeは:digits桁にしてください',
    'digits_between'       => ':attributeは:min〜:max桁にしてください。',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attributeを正しいメールアドレスにしてください。',
    'exists'               => '選択された:attributeは正しくありません。',
    'file'                 => ':attributeはファイルを選択してください。',
    'filled'               => ':attributeは必須です。',
    'image'                => ':attributeは画像にしてください。',
    'in'                   => '選択された:attributeは正しくありません。',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attributeは整数にしてください。',
    'ip'                   => ':attributeを正しいIPアドレスにしてください。',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attributeは:max以下にしてください。',
        'file'    => ':attributeは:max KB以下のファイルにしてください。.',
        'string'  => ':attributeは:max文字以下にしてください。',
        'array'   => ':attributeは:max個以下にしてください。',
    ],
    'mimes'                => ':attributeは:valuesタイプのファイルにしてください。',
    'mimetypes'            => ':attributeは:valuesタイプのファイルにしてください。',
    'min'                  => [
        'numeric' => ':attributeは:min以上にしてください。',
        'file'    => ':attributeは:min KB以上のファイルにしてください。.',
        'string'  => ':attributeは:min文字以上にしてください。',
        'array'   => ':attributeは:min個以上にしてください。',
    ],
    'not_in'               => '選択された:attributeは正しくありません。',
    'numeric'              => ':attributeは数字にしてください。',
    'regex'                => ':attributeの書式が正しくありません。',
    'required'             => ':attributeは必須です。',
    'required_if'          => ':otherが:valueの時、:attributeは必須です。',
    'required_unless'      => ':otherが:valueでない時、:attributeは必須です。',
    'required_with'        => ':valuesが存在する時、:attributeは必須です。',
    'required_with_all'    => ':valuesが存在する時、:attributeは必須です。',
    'required_without'     => ':valuesが存在しない時、:attributeは必須です。',
    'required_without_all' => ':valuesが存在しない時、:attributeは必須です。',
    'same'                 => ':attributeと:otherは一致していません。',
    'size'                 => [
        'numeric' => ':attributeは:sizeにしてください。',
        'file'    => ':attributeは:size KBにしてください。.',
        'string'  => ':attribute:size文字にしてください。',
        'array'   => ':attributeは:size個にしてください。',
    ],
    'string'               => ':attributeは文字列にしてください。',
    'timezone'             => ':attributeは正しいタイムゾーンをしていしてください。',
    'unique'               => ':attributeは既に存在します。',
    'uploaded'             => ':attributeのアップロードに失敗しました。',
    'url'                  => ':attributeを正しい書式にしてください。',
    'katakana'             => ':attributeはカタカナを入力してください。',
    'pref'             => ':attributeまで入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        // 'attribute-name' => [
        //     'rule-name' => 'custom-message',
        // ],
    ],

    'values' => [
        // 'free_flg' => [
        //     '0' => '「有料」',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => '名前',
        'kana' => 'カタカナ',
        'tel' => '電話番号',
        'pref' => '住所（都道府県）',
        'email' => 'メールアドレス',
        'birthday' => '生年月日',
        'first_kana' => 'メイ',
        'nick_name' => 'ニックネーム',
        'u_unique_code' => 'ユーザーネーム',
        'gender' => '性別',
        'birthday_year' => '年',
        'birthday_month' => '月',
        'birthday_day' => '日',
        'zip_code_1' => '郵便番号',
        'zip_code_2' => '郵便番号',
        'address_locality' => '市区町村',
        'address_street' => '番地',
        'address_extended' => '建物名',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード（確認）',
        'password_current' => '現在のパスワード',
        'password_new' => '新しいパスワード',
        'password_new_confirmation' => '新しいパスワード（確認）',
        'order.message_card_flg' => 'メッセージカード',
        'order.message' => 'メッセージ',
        'order.message_from' => '差出人名',
        'order.delivery_date' => 'お届け日',
        'order.card_id' => 'お支払いカード',
        'destination_name' => 'お届け先',
        'destination_zip_code_1' => '郵便番号',
        'destination_zip_code_2' => '郵便番号',
        'destination_address_region' => '都道府県',
        'destination_address_locality' => '市区町村',
        'destination_address_street' => '番地',
        'destination_address_extended' => '建物名',
        'product_orderer_information.last_name' => '姓',
        'product_orderer_information.first_name' => '名',
        'product_orderer_information.last_kana' => 'セイ',
        'product_orderer_information.first_kana' => 'メイ',
        'product_orderer_information.tel_num' => '電話番号',
        'product_orderer_information.zip_code_1' => '郵便番号',
        'product_orderer_information.zip_code_2' => '郵便番号',
        'product_orderer_information.address_region' => '都道府県',
        'product_orderer_information.address_locality' => '市区町村',
        'product_orderer_information.address_street' => '番地',
        'product_orderer_information.address_extended' => '建物名',
        'start_datetime' => '開始日時',
        'end_datetime' => '終了日時',
        'max_number' => '最大人数',
        'image' => '画像',
        'price' => '価格',
        'body' => 'コメントの入力',
    ],

];
