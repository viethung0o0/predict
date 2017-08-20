<?php

namespace App\Repositories;

use App\Models\Prediction;

/**
 * Class PredictionRepository
 *
 * @package App\Repositories
 * @version August 13, 2017, 9:05 am UTC
 */
class PredictionRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Prediction::class;
    }
}

