<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Prediction;

/**
 * Class SlugCriteriaCriteria
 *
 * @package namespace App\Criteria;
 */
class FootballPredictionCriteria implements CriteriaInterface
{
    private $eventID;
    private $userID;

    public function __construct($eventID, $userID)
    {
        $this->eventID = $eventID;
        $this->userID = $userID;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('event_id', $this->eventID)
            ->where('user_id', $this->userID)
            ->where('type', Prediction::POSITION_PREDICT_TYPE);

        return $model;
    }
}

