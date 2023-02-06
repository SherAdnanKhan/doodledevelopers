<?php

namespace App\Http\Requests\HearAboutUs;

use Illuminate\Foundation\Http\FormRequest;

class CreateHearAboutUsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:hear_about_us_platforms',
            'label'=> 'required|string|max:255|unique:hear_about_us_platforms'
        ];
    }
}
