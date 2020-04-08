<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseApiRequest;

class SignupRequest extends BaseApiRequest
{

    /**
     * @return boolean
     */

    public function authorize()
    {
        return true;
    }

    /**
     * Declare all rules
     * 
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ];
    }
}
