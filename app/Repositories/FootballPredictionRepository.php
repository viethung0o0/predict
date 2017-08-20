<?php

namespace App\Repositories;

use App\Models\FootballPrediction;

/**
 * Class PredictionRepository
 *
 * @package App\Repositories
 * @version August 13, 2017, 9:05 am UTC
 */
class FootballPredictionRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FootballPrediction::class;
    }
}

