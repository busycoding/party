<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserUpdateRequest extends Request
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
//https://stackoverflow.com/questions/53756328/how-to-update-only-one-input-in-laravel-form

        return [
            'name'     => 'required|max:255',
            // email,' . $this->route("users") special case to ignore the email on update
            //You need to specify the user ID so the validator knows it needs to ignore the entry with that ID when checking the entries for uniqueness
            //'email|required|unique:users,email,' . $this->route("users"),
            'email'    => 'email|required|max:255|unique:users,email,' . $this->route("user"),
            //'password' => 'sometimes|required|string|min:6',
            //'passwordConfirm' => 'sometimes|required_with:password|same:password',
            //'password' => 'sometimes|required_with:password_confirmation|confirmed'
            //'password' => 'sometimes|required|string|min:6',
            //'password_confirmation' => 'sometimes|required_with:password|same:password',
            'password'              => 'sometimes|required_with:password_confirmation',
'password_confirmation' => 'sometimes|required_with:password|same:password',

        ];
    }
}
