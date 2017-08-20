<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    const POSITION_PREDICT_TYPE = 1;

    const DAY_PREDICT_TYPE = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'predictions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'prediction_id',
        'status',
        'same_respondent_number',
        'date',
        'type'
    ];
}
