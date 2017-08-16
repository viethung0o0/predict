<?php

namespace App\Service;

use App\Repositories\TeamRepository;
use App\Repositories\EventRepository;
use App\Criteria\SlugCriteria;
use App\Models\FootballPrediction;

class FootballPredictPositionService
{
    /** @var  TeamRepository */
    private $teamRepo;

    /** @var  TeamRepository */
    private $eventRepo;

    /**
     * TeamService constructor.
     *
     * @param TeamRepository $teamRepo TeamRepository
     *
     * @return void
     */
    public function __construct(TeamRepository $teamRepo, EventRepository $eventRepo)
    {
        $this->teamRepo = $teamRepo;
        $this->eventRepo = $eventRepo;
    }

    /**
     * Create a team
     *
     * @param string $eventSlug Slug
     *
     * @return Team
     */
    public function getDataWhenShow(string $eventSlug)
    {
        $teams = $this->teamRepo->all([
            'id',
            'name'
        ])->pluck('name', 'id');

        return compact('teams');
    }

    public function createPredict(string $eventSlug, array $data)
    {
        $event = $this->eventRepo->pushCriteria(new SlugCriteria($eventSlug))->first(['id']);

        //Set data for 1st
        $input1st = [
            'user_id' => currentLoginUser()->id ?? 1,
            'event_id' => $event->id,
            'type' => FootballPrediction::POSITION_PREDICT_TYPE,
            'position' => 1,
            'team_1' => $data[1]['team_1']['team_id'],
            'team_2' => $data[1]['team_2']['team_id'],
            'score_1' => $data[1]['team_1']['score'],
            'score_2' => $data[1]['team_2']['score'],
            'same_respondent_number' => $data['same_respondent_number']
        ];
        dd($input1st, $data);
    }
}