<?php

namespace App\Repositories;

use App\Models\Team;

/**
 * Class AdminRepository
 *
 * @package App\Repositories
 * @version August 13, 2017, 9:05 am UTC
 *
 * @method Team findWithoutFail($id, $columns = ['*'])
 * @method Team find($id, $columns = ['*'])
 * @method Team first($columns = ['*'])
 */
class TeamRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'admin_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Team::class;
    }
}

