<?php

namespace App\Http\Requests;

use App\Models\Job;
use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         //從MyJobController store copy
         return [
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:5000',
            'description' => 'required|string',
            'experience' => 'required|in:' .implode(',', Job::$experience),
            'category' => 'required|in:' .implode(',', Job::$category),

            //'in:' . implode(',', Job::$experience): 這表示 'experience' 字段的值必須是在指定的選項中。具體的選項來自 Job::$experience，
            //這裡使用了 implode(',', Job::$experience) 來將 Job::$experience數組中的值轉換為以逗號分隔的字串。
            //這樣，驗證規則就是要求 'experience' 字段的值必須是 Job::$experience 中的其中一個。 
        ];
    }
}
