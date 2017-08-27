<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FootballMatch extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'football_matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_1_id',
        'team_2_id',
        'event_id',
        'time',
        'expired_at'
    ];

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team_1_id', 'id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team_2_id', 'id');
    }
}

