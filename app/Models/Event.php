<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    /**
     * Status is publish
     */
    const PUBLISH_STATUS = 1;

    /**
     * Status is draft
     */
    const DRAFT_STATUS = 2;

    /**
     * Status is stopped
     */
    const STOPPED_STATUS = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';
}
