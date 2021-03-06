<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
            'nickname' => 'between:0,18',//验证昵称
        ];
    }

    /**
     * 自定义错误类型
     *
     * @return array
     */
    public function messages()
    {
        return [
            'mobile.required' => '手机号码不能为空',
            'mobile.regex' => '手机号码不合法',
            'password.required' => '密码不能为空',
        ];
    }
}
