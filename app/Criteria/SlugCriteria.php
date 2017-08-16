<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SlugCriteriaCriteria
 *
 * @package namespace App\Criteria;
 */
class SlugCriteria implements CriteriaInterface
{
    private $slug;

    public function __construct($slug)
    {
        $this->slug = $slug;
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
        $model->where('slug', $this->slug);
        return $model;
    }
}
