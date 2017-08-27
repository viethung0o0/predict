<?php

namespace App\Service;

use App\Repositories\TeamRepository;
use App\Repositories\EventRepository;
use App\Repositories\FootballMatchRepository;
use App\Repositories\FootballPredictionRepository;
use App\Criteria\SlugCriteria;
use App\Models\Prediction;
use App\Repositories\PredictionRepository;
use App\Criteria\FootballMatchCurrentDayCriteria;
use App\Criteria\PositionPredictionCriteria;
use App\Criteria\FootballPredictionCriteria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    private $footballMatchRepo;


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
        FootballPredictionRepository $footballPredictionRepo,
        FootballMatchRepository $footballMatchRepository
    ) {
        $this->teamRepo = $teamRepo;
        $this->eventRepo = $eventRepo;
        $this->predictionRepo = $predictionRepo;
        $this->footballPredictionRepo = $footballPredictionRepo;
        $this->footballMatchRepo = $footballMatchRepository;
    }

    /**
     * Create a team
     *
     * @param string $eventSlug Slug
     *
     * @return array
     */
    public function getDataChampion($event, array $positions = [])
    {
        $data['event'] = $event;
        $data['teams'] = $this->teamRepo->all([
            'id',
            'name'
        ])->pluck('name', 'id')->prepend('Select', '');

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
                'prediction_id' => $prediction->id,
                'user_id' => $userID,
                'position' => $positions
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

    /**
     * Create a team
     *
     * @param string $eventSlug Slug
     *
     * @return array
     */
    public function getDataByCurrentDay($event)
    {
        $data['event'] = $event;

        $data['matches'] = $this->footballMatchRepo->with([
            'team1' => function ($query) {
                $query->select(['id', 'name']);
            },
            'team2' => function ($query) {
                $query->select(['id', 'name']);
            },
        ])->pushCriteria(new FootballMatchCurrentDayCriteria([
            'event_id' => $event->id
        ]))->all([
            'id',
            'team_1_id',
            'team_2_id',
            'time'
        ]);

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
                'prediction_id' => $prediction->id,
                'user_id' => $userID,
            ]))->all([
                'team_1',
                'team_2',
                'score_1',
                'score_2',
                'football_match_id',
            ])->keyBy('football_match_id')->toArray();

            $data['sameRespondentNumber'] = $prediction->same_respondent_number;
        }


        return $data;
    }


    public function predictFootball($event, array $data, array $params)
    {
        $prediction = $this->createOrNewPrediction(
            $event->id,
            array_merge($data, $params)
        );

        $this->deletePositionPrediction($prediction->id, $params);

        $this->insertFootballPrediction($prediction, $data);
    }

    public function predictFootballWithCurrentDay($event, array $data)
    {
        $prediction = $this->createOrNewPrediction(
            $event->id,
            $data
        );

        foreach ($data['score'] as $footballMatchId => $item) {
            if ($this->footballMatchRepo->checkInforValid($footballMatchId, $event->id, array_keys($item))) {
                $team1 = key($item);
                $keys = array_keys($item);
                $team2 = end($keys);
                $infor = [
                    'prediction_id' => $prediction->id,
                    'team_1' => $team1,
                    'team_2' => $team2,
                    'score_1' => $item[$team1],
                    'score_2' => $item[$team2],
                    'user_id' => currentLoginUser('web')->id,
                    'football_match_id' => $footballMatchId
                ];

                $this->footballPredictionRepo->updateOrCreate($infor, $infor);
            }
        }
    }

    public function deletePositionPrediction($predictionID, $data)
    {
        $params = [
            'user_id' => currentLoginUser('web')->id,
            'prediction_id' => $predictionID,
            'position' => $data['position'],
            'by_current_day' => $data['by_current_day'] ?? false
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

    public function createOrNewPrediction(int $eventID, array $params = [])
    {
        $userID = currentLoginUser('web')->id;

        $prediction = $this->predictionRepo->updateOrCreate([
            'event_id' => $eventID,
            'user_id' => $userID
        ], [
            'same_respondent_number' => $params['same_respondent_number'],
            'date' => Carbon::now()
        ]);

        return $prediction;
    }

    private function checkEventExpired(string $eventEndTime)
    {
        return Carbon::now()->greaterThan(Carbon::parse($eventEndTime));
    }

    public function getEventBySlug(string $eventSlug)
    {
        $event = $this->eventRepo->pushCriteria(new SlugCriteria($eventSlug))->first([
            'id',
            'prize_value',
            'end_time_at'
        ]);

        if (empty($event)) {
            throw new ModelNotFoundException();
        }

        if ($this->checkEventExpired($event->end_time_at)) {
            throw new NotFoundHttpException('Predictions football results have already expired');
        }

        return $event;
    }
}
