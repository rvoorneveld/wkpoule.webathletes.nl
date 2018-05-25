<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Game;
use App\Predictions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Feeds;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', [
            'todaysGames' => Game::where('date', Carbon::today()->toDateString())->get()->all(),
            'upcommingGames' => Game::limit(5)->get(),
            'showFillPredictionsBox' => (Predictions::where('userId', Auth::id())->count() == Game::count()),
//            'feed' => $this->getFeedData(),
        ]);
    }

    protected function getFeedData(): array
    {
        return [
            'title' => ($feed = Feeds::make('https://www.voetbalkrant.com/nl/rss/nieuws'))->get_title(),
            'permalink' => $feed->get_permalink(),
            'items' => $feed->get_items(),
        ];
    }

}
