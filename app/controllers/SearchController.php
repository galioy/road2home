<?php

use Trips\TripsProvider as TripsProvider;

class SearchController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => 'post']);
    }

    public function searchTrips()
    {
        $input = Input::all();
        $date = (empty($input['date']) ? date("Y-m-d") : $input['date']);
        $trips = TripsProvider::getSearchedTrips($input['search_route_from'], $input['search_route_to'], $date);
        $route_from = explode(',', $input['search_route_from']);
        $route_to = explode(',', $input['search_route_to']);

        return View::make('trips.trip_list')
            ->with('trips', $trips)
            ->with('search', true)
            ->with('route_from', $route_from[0])
            ->with('route_to', $route_to[0]);
    }
}
