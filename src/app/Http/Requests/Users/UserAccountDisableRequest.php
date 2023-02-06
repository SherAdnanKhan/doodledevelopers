<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;


class UserAccountDisableRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id'
        ];
    }
}
