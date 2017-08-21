<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\EventRepository;

class EventComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $events;

    /**
     * Create a new profile composer.
     *
     * @param  EventRepository $events EventRepository
     *
     * @return void
     */
    public function __construct(EventRepository $events)
    {
        // Dependencies automatically resolved by service container...
        $this->events = $events;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('events', $this->events->all(['id', 'name', 'slug']));
    }
}