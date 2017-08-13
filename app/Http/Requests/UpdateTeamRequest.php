<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Admin;

class UpdateAdminRequest extends FormRequest
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
        $adminID = $this->route('admin_management');

        $rules = array_merge(Admin::$updateRules, [
            'username' => "required|unique:admins,username,$adminID|max:255",
            'email' => "required|email|unique:admins,email,$adminID|max:255",
            'password' => 'confirmed|max:20'
        ]);

        return $rules;
    }
}
