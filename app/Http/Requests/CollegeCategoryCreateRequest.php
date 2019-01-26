<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollegeCategoryCreateRequest extends FormRequest
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
            'name' => [
                'required',
            ],
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
            'name.required' => '院校类型不能为空',
        ];
    }
}
