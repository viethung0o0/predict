<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Prediction;

/**
 * Class PositionPredictionCriteria
 *
 * @package namespace App\Criteria;
 */
class PositionPredictionCriteria implements CriteriaInterface
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
        $model->where('user_id', $this->data['user_id'])
            ->where('prediction_id', $this->data['prediction_id'])
            ->whereIn('position', $this->data['position']);

        return $model;
    }
}

