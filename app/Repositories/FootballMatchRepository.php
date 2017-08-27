<?php

namespace App\Repositories;

use App\Models\FootballMatch;
use Carbon\Carbon;

/**
 * Class PredictionRepository
 *
 * @package App\Repositories
 * @version August 13, 2017, 9:05 am UTC
 */
class FootballMatchRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FootballMatch::class;
    }

    public function checkInforValid($footballMatchId, $eventID, $item)
    {
        return $this->scopeQuery(function ($query) use ($eventID, $item) {
            return $query->where('team_1_id', $item[0])
                ->where('team_2_id', $item[1])
                ->where('event_id', $eventID)
                ->where('expired_at', '>=', Carbon::now());
        })->findWithoutFail($footballMatchId, ['id']);
    }
}

