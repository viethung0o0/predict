<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Service\PredictService;
use App\Service\FootballPredictPositionService;
use Exception;
use App\Repositories\Traits\EloquentTransactional;
use App\Http\Requests\FootballPredictRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PredictController extends Controller
{

    use EloquentTransactional;
    private $predictService;

    public function __construct(
        PredictService $predictService
    ) {
        $this->predictService = $predictService;
    }

    public function showPredict($eventSlug)
    {
        try {
            $event = $this->predictService->getEventBySlug($eventSlug, [
                'id',
                'type',
                'prize_value',
                'end_time_at'
            ]);

            $result = $this->predictService->getPredictDataByType($event);
        } catch (NotFoundHttpException $ex) {
            abort('404', $ex->getMessage());
        } catch (ModelNotFoundException $ex) {
            abort('404', 'Page not found');
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return redirect()->to('/');
        }

        return view($result['view'], $result['data']);
    }

    public function predict(FootballPredictRequest $request, $eventSlug) {
        try {
            $this->beginTransaction();

            $this->predictService->predict($eventSlug, $request->all());

            $this->commit();
            session()->flash('success', 'Football successfully predicted');
        } catch (Exception $ex) {
            session()->flash('error', 'Football predict error');
            $this->rollback();
            //
        }

        return back();
    }
}
