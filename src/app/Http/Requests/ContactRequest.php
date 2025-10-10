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
             'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'gender' => 'required|in:0,1,2',
            'email' => 'required|email|max:255',
            'tel' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'message' => 'required|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'last_name.required' => '姓は必須項目です。',
            'first_name.required' => '名は必須項目です。',
            'gender.required' => '性別を選択してください。',
            'email.required' => 'メールアドレスは必須項目です。',
            'tel.required' => '電話番号は必須項目です。',
            'address.required' => '住所は必須項目です。',
            'category_id.required' => 'お問い合わせの種類を選択してください。',
            'message.required' => 'お問い合わせ内容を入力してください。',
        ];
    }
}
