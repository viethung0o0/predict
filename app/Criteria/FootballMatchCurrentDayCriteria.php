<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon\Carbon;

/**
 * Class PositionPredictionCriteria
 *
 * @package namespace App\Criteria;
 */
class FootballMatchCurrentDayCriteria implements CriteriaInterface
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
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
        $model = $model->where('event_id', $this->data['event_id'])
            ->whereDate('time', Carbon::now());

        return $model;
    }
}

