<?php

namespace App\Service;

use App\Repositories\EventRepository;
use App\Criteria\SlugCriteria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\Event;

class PredictService
{
    /**
     * @var \App\Service\FootballPredictPositionService
     */
    private $eventRepo;

    /**
     * @var \App\Service\FootballPredictPositionService
     */
    private $footballPredictPositionService;


    /**
     * TeamService constructor.
     *
     * @param EventRepository                $teamRepo                       EventRepository
     * @param FootballPredictPositionService $footballPredictPositionService FootballPredictPositionService
     *
     * @return void
     */
    public function __construct(
        EventRepository $eventRepo,
        FootballPredictPositionService $footballPredictPositionService
    ) {
        $this->eventRepo = $eventRepo;
        $this->footballPredictPositionService = $footballPredictPositionService;
    }

    public function getEventBySlug(string $eventSlug, array $columns = ["*"])
    {
        $event = $this->eventRepo->pushCriteria(new SlugCriteria($eventSlug))->first($columns);

        if (empty($event)) {
            throw new ModelNotFoundException();
        }

        if ($this->checkEventExpired($event->end_time_at)) {
            throw new NotFoundHttpException('Predictions football results have already expired');
        }

        return $event;
    }

    public function getPredictDataByType($event)
    {
        switch ($event->type) {
            case Event::POSITION_PREDICT_TYPE :
                $result = $this->getChampionPredictionFootball($event);
                break;
            case Event::DAY_PREDICT_TYPE :
                $result = $this->getPredictionFootballWithCurrentDay($event);
                break;
            default:
                abort(500);
        };

        return $result;
    }

    public function predict(string $eventSlug, array $data)
    {
        $event = $this->eventRepo->pushCriteria(new SlugCriteria($eventSlug))->first([
            'id',
            'type',
            'prize_value',
            'end_time_at'
        ]);

        switch ($event->type) {
            case Event::POSITION_PREDICT_TYPE :
                $result = $this->predictFootballChampion($event, $data);
                break;
            case Event::DAY_PREDICT_TYPE :
                $result = $this->predictFootballByDay($event, $data);
                break;
            default:
                abort(500);
        };

        return $result;
    }

    private function predictFootballChampion($event, $data)
    {
        $data = array_only($data, [1, 3, 'same_respondent_number']);

        $this->footballPredictPositionService->predictFootball($event, $data, [
            'position' => [1, 2]
        ]);
    }

    private function predictFootballByDay($event, $data)
    {
        $data = array_only($data, ['score', 'same_respondent_number']);

        $this->footballPredictPositionService->predictFootballWithCurrentDay($event, $data);
    }

    private function getChampionPredictionFootball($event)
    {
        $data = $this->footballPredictPositionService->getDataChampion($event, [1, 3]);

        return [
            'view' => 'frontend.football',
            'data' => $data
        ];
    }

    private function getPredictionFootballWithCurrentDay($event)
    {
        $data = $this->footballPredictPositionService->getDataByCurrentDay($event);

        if ($data['matches']->isEmpty()) {
            abort(404, 'There are no football matches happening today');
        }

        return [
            'view' => 'frontend.football-day',
            'data' => $data
        ];
    }

    private function checkEventExpired(string $eventEndTime)
    {
        return Carbon::now()->greaterThan(Carbon::parse($eventEndTime));
    }
}
