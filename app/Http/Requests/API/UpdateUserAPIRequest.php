<?php

namespace App\Http\Requests\API;

use App\User;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserAPIRequest extends APIRequest
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
        $rules = User::$editRules;
        $rules['email'] = 'required|unique:users,email,'.$this->route('id');
        $rules['user_name'] = 'required|unique:users,user_name,'.$this->route('id');
        $rules['identification_number'] = 'required|unique:users,identification_number,'.$this->route('id');

        return $rules;
    }
}
