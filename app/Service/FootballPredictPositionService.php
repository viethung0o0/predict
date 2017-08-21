<?php

namespace App\Service;

use App\Repositories\TeamRepository;
use App\Repositories\EventRepository;
use App\Repositories\FootballPredictionRepository;
use App\Criteria\SlugCriteria;
use App\Models\Prediction;
use App\Repositories\PredictionRepository;
use App\Criteria\PositionPredictionCriteria;
use App\Criteria\FootballPredictionCriteria;
use Carbon\Carbon;

class FootballPredictPositionService
{
    /** @var  TeamRepository */
    private $teamRepo;

    /** @var  TeamRepository */
    private $eventRepo;

    /** @var  PredictionRepository */
    private $predictionRepo;

    /** @var  PredictionRepository */
    private $footballPredictionRepo;


    /**
     * TeamService constructor.
     *
     * @param TeamRepository $teamRepo TeamRepository
     *
     * @return void
     */
    public function __construct(
        TeamRepository $teamRepo,
        EventRepository $eventRepo,
        PredictionRepository $predictionRepo,
        FootballPredictionRepository $footballPredictionRepo
    ) {
        $this->teamRepo = $teamRepo;
        $this->eventRepo = $eventRepo;
        $this->predictionRepo = $predictionRepo;
        $this->footballPredictionRepo = $footballPredictionRepo;
    }

    /**
     * Create a team
     *
     * @param string $eventSlug Slug
     *
     * @return array
     */
    public function getDataWhenShow(string $eventSlug)
    {
        $data['event'] = $this->eventRepo->pushCriteria(new SlugCriteria($eventSlug))->first(['id', 'prize_value']);

        $data['teams'] = $this->teamRepo->all([
            'id',
            'name'
        ])->pluck('name', 'id');

        if (auth()->guest()) {
            return $data;
        }

        $userID = currentLoginUser('web')->id;

        $prediction = $this->predictionRepo->pushCriteria(new FootballPredictionCriteria(
                $data['event']->id,
                $userID)
        )->first(['id', 'same_respondent_number']);

        if ($prediction) {
            $data['footballPredictions'] = $this->footballPredictionRepo->pushCriteria(new PositionPredictionCriteria([
                'prediction_id' => $prediction,
                'user_id' => $userID,
                'position' => [1, 3]
            ]))->all([
                'team_1',
                'team_2',
                'score_1',
                'score_2',
                'position',
            ])->keyBy('position')->toArray();

            $data['sameRespondentNumber'] = $prediction->same_respondent_number;
        }


        return $data;
    }

    public function predictFootball(string $eventSlug, array $data, array $params)
    {
        $event = $this->eventRepo->pushCriteria(new SlugCriteria($eventSlug))->first(['id']);

        $prediction = $this->createOrNewPrediction(
            $event->id,
            Prediction::POSITION_PREDICT_TYPE,
            array_merge($data, $params)
        );

        $this->deletePositionPrediction($prediction->id, $params);

        $this->insertFootballPrediction($prediction, $data);
    }

    public function deletePositionPrediction($predictionID, $data)
    {
        $params = [
            'user_id' => currentLoginUser('web')->id,
            'prediction_id' => $predictionID,
            'position' => $data['position']
        ];
        $ids = $this->footballPredictionRepo->pushCriteria(new PositionPredictionCriteria($params))
            ->all(['id'])
            ->pluck('id')
            ->toArray();

        if (!empty($ids)) {
            return $this->footballPredictionRepo->deletes($ids);
        }

        return 0;
    }

    public function insertFootballPrediction($prediction, $data)
    {
        //Set data for 1st
        $input1st = [
            'user_id' => currentLoginUser('web')->id,
            'position' => 1,
            'team_1' => $data[1]['team_1']['team_id'],
            'team_2' => $data[1]['team_2']['team_id'],
            'score_1' => $data[1]['team_1']['score'],
            'score_2' => $data[1]['team_2']['score'],
            'prediction_id' => $prediction->id
        ];

        //Set data for 1st
        $input3st = [
            'user_id' => currentLoginUser('web')->id,
            'position' => 3,
            'team_1' => $data[3]['team_1']['team_id'],
            'team_2' => $data[3]['team_2']['team_id'],
            'score_1' => $data[3]['team_1']['score'],
            'score_2' => $data[3]['team_2']['score'],
            'prediction_id' => $prediction->id
        ];

        $this->footballPredictionRepo->create($input1st);
        $this->footballPredictionRepo->create($input3st);
    }

    public function createOrNewPrediction(int $eventID, int $type, array $params = [])
    {
        $userID = currentLoginUser('web')->id;

        $prediction = $this->predictionRepo->firstOrCreate([
            'event_id' => $eventID,
            'user_id' => $userID,
            'type' => $type
        ], [
            'same_respondent_number' => $params['same_respondent_number'],
            'date' => Carbon::now()
        ]);

        return $prediction;
    }
}
