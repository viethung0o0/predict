<?php

namespace App\Repositories;

use App\Models\Event;

/**
 * Class EventRepository
 *
 * @package App\Repositories
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

