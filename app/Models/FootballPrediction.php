<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FootballPrediction extends Model
{

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
        'team_1',
        'score_1',
        'team_2',
        'score_2',
        'prediction_id',
        'position',
        'football_match_id'
    ];
}

