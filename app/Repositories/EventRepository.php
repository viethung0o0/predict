<?php

namespace App\Repositories;

use App\Models\Event;

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
class EventRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Event::class;
    }
}

