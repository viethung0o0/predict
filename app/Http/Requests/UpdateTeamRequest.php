<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Team;

class UpdateTeamRequest extends FormRequest
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
        $teamID = $this->route('team_management');

        $rules = array_merge(Team::$updateRules, [
            'name' => "required|unique:teams,name,$teamID|max:255",
        ]);

        return $rules;
    }
}
