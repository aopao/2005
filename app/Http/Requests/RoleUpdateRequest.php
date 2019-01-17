<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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
            'name' => 'required',
            'display_name' => 'required',
            'guard_name' => 'required',
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
            'name.required' => '唯一标识符不能为空',
            'display_name.required' => '名称不能为空',
        ];
    }
}
