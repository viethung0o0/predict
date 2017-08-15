<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class FootballController extends Controller
{
    public function __construct()
    {
    }

    public function predictChampion()
    {
        return view('frontend.football');
    }

    public function predictWinByDay()
    {

    }
}