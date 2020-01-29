<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class WorkRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'type_id' => 'required|string|max:255',
            'single_price_min' => ['required_if:type_id,1','nullable','integer','min:1000',
                function($attribute, $value, $fail) {
                    if($value % 1000 !== 0){
                        return $fail($this->attributes()[$attribute].'は1000円単位で入力してください。');
                    }
                }],
            'single_price_max' => ['required_if:type_id,1','nullable','integer','gte:single_price_min',
                function($attribute, $value, $fail) {
                    if($value % 1000 !== 0){
                        return $fail($this->attributes()[$attribute].'は1000円単位で入力してください。');
                    }
                },'max:10000000'],
            'revenue_share_price' => ['required_if:type_id,2','nullable','integer','min:1000','max:10000000',
                function($attribute, $value, $fail) {
                    if($value % 1000 !== 0){
                        return $fail($this->attributes()[$attribute].'は1000円単位で入力してください。');
                    }
                }],
            'detail' => 'required|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'single_price_max.max' => ':attributeには10,000,000以下の数字を指定してください。',
            'revenue_share_price.max'  => ':attributeには10,000,000以下の数字を指定してください。'
        ];
    }
    
}
