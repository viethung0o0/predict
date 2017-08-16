<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FootballPrediction extends Model
{

    const POSITION_PREDICT_TYPE = 1;

    const DAY_PREDICT_TYPE = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'football_predictions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'team_1',
        'score_1',
        'team_2',
        'score_2',
        'status',
        'same_respondent_number',
        'date',
    ];
}
