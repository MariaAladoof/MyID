<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        //  return auth()->check();
        return $this->user() !== null;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'national_id' => ['required', 'string', 'max:255', 'unique:subscribers,national_id'],

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم Subscriber مطلوب',
            'name.string' => 'الاسم يجب أن يكون نصًا',
            'name.min' => 'الاسم يجب أن يكون على الأقل 2 حروف',
            'name.max' => 'الاسم يجب أن لا يزيد عن 255 حرفًا',
            'national_id.required' => 'الرقم الوطني مطلوب',
            'national_id.string' => 'الرقم الوطني يجب أن يكون نصًا',
            'national_id.max' => 'الرقم الوطني يجب أن لا يزيد عن 255 حرفًا',
            'national_id.unique' => 'الرقم الوطني مستخدم بالفعل',

        ];
    }
}
