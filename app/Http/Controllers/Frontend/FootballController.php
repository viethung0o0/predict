<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\FootballPredictPositionService;
use Exception;
use App\Repositories\Traits\EloquentTransactional;
use App\Http\Requests\FootballPredictRequest;

class FootballController extends Controller
{

    use EloquentTransactional;
    private $predictService;

    public function __construct(FootballPredictPositionService $predictService)
    {
        $this->predictService = $predictService;
    }

    public function showPredictPosition($eventSlug)
    {
        try {
            $data = $this->predictService->getDataWhenShow($eventSlug);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            //
        }

        return view('frontend.football', $data);
    }

    public function predictPosition(FootballPredictRequest $request, $eventSlug)
    {
        try {
            $this->beginTransaction();

            $data = $request->only([
                1,
                3,
                'same_respondent_number'
            ]);
            $this->predictService->predictFootball($eventSlug, $data, [
                'position' => [1, 2]
            ]);

            $this->commit();
            session()->flash('success', 'Football successfully predicted');
        } catch (Exception $ex) {
            session()->flash('error', 'Football predict error');
            $this->rollback();
            //
        }

        return back();
    }

    public function showPredictWinByDay()
    {

    }
}
