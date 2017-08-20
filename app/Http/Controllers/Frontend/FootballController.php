<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\FootballPredictPositionService;
use Exception;

class FootballController extends Controller
{

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
            //
        }

        return view('frontend.football', $data);
    }

    public function predictPosition(Request $request, $eventSlug)
    {
        try {
            $data = $request->only([
                1,
                3,
                'same_respondent_number'
            ]);
            $this->predictService->predictFootball($eventSlug, $data, [
                'position' => [1, 2]
            ]);
        } catch (Exception $ex) {
            //
        }

        return back();
    }

    public function showPredictWinByDay()
    {

    }
}
