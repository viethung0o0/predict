<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class FootballPredictRequest extends FormRequest
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
        if ($this->has('score')) {
            return $this->getRuleFootballByDay();
        }

        return $this->getRuleFootballChampion();

    }

    public function formatErrors(Validator $validator)
    {
        session()->flash('error', 'Data invalid');
        return parent::formatErrors($validator); // TODO: Change the autogenerated stub
    }

    public function attributes()
    {
        return [
            '1.team_1.team_id' => 'Team A',
            '1.team_1.score' => 'Score A',
            '1.team_2.team_id' => 'Team B',
            '1.team_2.score' => 'Score B',
            '3.team_1.team_id' => 'Team A',
            '3.team_1.score' => 'Score A',
            '3.team_2.team_id' => 'Team B',
            '3.team_2.score' => 'Score B',
            'same_respondent_number' => 'Number of predictions'
        ];
    }

    private function getRuleFootballByDay()
    {
        return [
            'score.*' => 'required',
            'score.*.*' => 'required|integer|min:0',
            'same_respondent_number' => 'required'
        ];
    }

    private function getRuleFootballChampion()
    {
        return [
            '1.team_1.team_id' => 'required|different:1.team_2.team_id|integer|min:0',
            '1.team_1.score' => 'required',
            '1.team_2.team_id' => 'required|integer|min:0',
            '1.team_2.score' => 'required',
            '3.team_1.team_id' => 'required|different:3.team_2.team_id|integer|min:0|predict_footbal_unique',
            '3.team_1.score' => 'required',
            '3.team_2.team_id' => 'required|integer|min:0|predict_footbal_unique',
            '3.team_2.score' => 'required',
            'same_respondent_number' => 'required'
        ];
    }
}
