<?php

namespace Trips;

use Carbon\Carbon;
use Trip;
use User;
use Vehicle;

/**
 * Class TripsProvider
 * Contains functions that are called from the controllers, and deal with data connected to the trips.
 *
 * @package Trips
 */
class TripsProvider {

    /**
     * Generates an object containing trips and their drivers (as object as well).
     * Simply paginate 10 trips from the DB.
     *
     * @return object $trips_with_drivers - 10 paginated trips and their drivers
     */
    public static function getTripsListing()
    {
        $trips = Trip::where('start_date', '>=', date('Y-m-d H:i:s'))
            ->select(
            'id',
            'parent_trip_id',
            'driver_user_id',
            'route_from',
            'country_from',
            'route_to',
            'country_to',
            'start_date')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        $trips_with_drivers = self::getTripsDrivers($trips);

        return $trips_with_drivers;
    }

    /**
     * Select all trips that have (or LIKE) the provided start and destination of the route + the
     * date of trip. If the date is not provided - search with today's date.
     *
     * @param $route_from - searched start city the of route, from the user
     * @param $route_to   - searched destination of the route, from the user
     * @param $date       - searched date for the trip
     *
     * @return object $trips_with_drivers - the provided trips, but already with their drivers
     */
    public static function getSearchedTrips($route_from, $route_to, $date)
    {
        $trips = Trip::whereStatus('1')
            ->where('route_from', 'LIKE', '%' . $route_from . '%')
            ->where('route_to', 'LIKE', '%' . $route_to . '%')
            ->whereRaw('DATE(start_date) >= ?', [$date])
            ->select('id', 'driver_user_id', 'route_from', 'route_to', 'start_date')->get();

        $trips_with_drivers = self::getTripsDrivers($trips);

        return $trips_with_drivers;
    }

    /**
     * Finds the drivers, and their vehicles, for each trip of the collection object of trips, passed to the function.
     *
     * @param Trip[] $trips - the trips to search the drivers for
     *
     * @return Trip[] $trips - the provided trips, but already with their drivers
     */
    public static function getTripsDrivers($trips)
    {
        foreach ($trips as $trip) {
            $driver = User::whereId($trip->driver_user_id)
                ->select('id', 'name', 'surname', 'email', 'gender')->first();
            $trip['driver'] = $driver;
            $vehicle = Vehicle::whereUserId($trip->driver_user_id)->select('id')->first();

            if ($vehicle) {
                $trip['vehicle'] = $vehicle;
            }
        }

        return $trips;
    }

    /**
     * Takes a DATETIME value and separates the date, the hours and the minutes into separate indexes in an array.
     *
     * @param $date_time - string of DATETIME format
     *
     * @return array of date and time values separately per index
     */
    public static function getDateAndTimeSeparated($date_time)
    {
        $date_time = explode(' ', $date_time);
        $date = $date_time[0];
        $time = explode(':', $date_time[1]);
        $time_hours = $time[0];
        $time_minutes = $time[1];

        return [
            'date'         => $date,
            'time_hours'   => $time_hours,
            'time_minutes' => $time_minutes
        ];
    }


    /**
     * Organizes the routes input fields and prices input fields from the "Offer trip" page, as
     * each route field matches its price field.
     *
     * @param array $input - the form input from the view
     *
     * @return array $stop_points[via_route_..id..] => stop_point_price_..id..
     */
    public static function mapRouteToPriceForStops($input)
    {
        $stops = [];
        for ($i = 0; $i < 3; $i ++) {
            if (isset($input[ 'stop_route_' . $i ])) {
                $stops[ $input[ 'stop_route_' . $i ] ] = $input[ 'stop_price_' . $i ];
            }
        }

        return $stops;
    }

    /**
     * Takes the array of organized trips (from the input of the view) "Route" => "Price", takes the existing partial
     * trips for the main trip, of the given id, as parameter, and then loops through the organized trips to
     * re-organize them in the following logic:
     * 1. if the input trip exists in the DB - update it
     * 2. if a trip that exists in the DB is not present in the input - delete it from DB
     * 3. if a trip from the input does not exist in the DB - insert(store) it
     *
     * Simply putting each trip in a separate index of the "decided" array, by adding an index "action", which is then
     * the key for deciding what to do with the certain partial trip.
     *
     * @param $parent_trip_id
     * @param $input
     *
     * @return array - decided[index_as_number] => [
     *               'route' => the destination route,
     *               'price' => the price for that trip,
     *               'action' => the action to be taken for that partial trip
     *               ]
     */
    public static function decideToStoreUpdateDeletePartialTrip($parent_trip_id, $input)
    {
        $decided = [];
        $partial_trips_as_array = [];
        $partial_trips_organized = self::mapRouteToPriceForStops($input);
        $partial_trips_from_db = Trip::whereParentTripId($parent_trip_id)->select('route_to')->get();
        foreach ($partial_trips_from_db as $p) {
            if (array_key_exists($p->route_to, $partial_trips_organized)) {
                $decided[] = [
                    'route'  => $p->route_to,
                    'price'  => $partial_trips_organized[ $p->route_to ],
                    'action' => 'update'
                ];
            } else {
                $decided[] = [
                    'route'  => $p->route_to,
                    'action' => 'delete'
                ];
            }
            $partial_trips_as_array[ $p->route_to ] = null;
        }
        foreach ($partial_trips_organized as $route => $price) {
            if ( ! array_key_exists($route, $partial_trips_as_array)) {
                $decided[] = [
                    'route'  => $route,
                    'price'  => $price,
                    'action' => 'store'
                ];
            }
        }

        return $decided;
    }

    /**
     * Stores a new partial trip in the DB
     *
     * @param Trip           $parent_trip - the parent trip
     * @param string         $route       - the "route_to" value (the stop point of the route)
     * @param string(number) $price       - the price of that partial trip
     */
    public static function storePartialTrip($parent_trip, $route, $price)
    {
        $p_trip = new Trip();
        $route_country_to = self::separateSingleRouteFromCountry($route);
        $p_trip->unguard();
        $p_trip->fill([
            'parent_trip_id'   => $parent_trip->id,
            'route_from'       => $parent_trip->route_from,
            'country_from'     => $parent_trip->country_from,
            'route_to'         => $route_country_to['route'],
            'country_to'       => $route_country_to['country'],
            'start_date'       => $parent_trip->start_date,
            'km'               => $parent_trip->km,
            'status'           => 1,
            'smoking_allowed'  => $parent_trip->smoking_allowed,
            'chat_allowed'     => $parent_trip->chat_allowed,
            'music_allowed'    => $parent_trip->music_allowed,
            'children_allowed' => $parent_trip->children_allowed,
            'animals_allowed'  => $parent_trip->animals_allowed,
            'price'            => $price,
            'luggage_size'     => $parent_trip->luggage_size,
            'trip_type'        => $parent_trip->trip_type,
            'additional_info'  => $parent_trip->additional_info,
            'seats_total'      => $parent_trip->seats_total,
            'driver_user_id'   => $parent_trip->driver_user_id
        ]);
        $p_trip->reguard();
        $p_trip->save();
    }

    /**
     * Updates a partial trip in the DB
     *
     * @param $main_trip_id - the id of the main trip for the certain partial trip
     * @param $route        - the "route_to" value
     * @param $price        - the price of that partial trip
     * @param $input        - the input values passed from the view
     */
    public static function updatePartialTrip($main_trip_id, $route, $price, $input)
    {
        $p_trip = Trip::whereMainTripId($main_trip_id)->whereRouteTo($route)->first();
        $p_trip_input = [
            'route_from'   => $input['route_from'],
            'route_to'     => $route,
            'price'        => $price,
            'start_date'   => date('Y-m-d H:i:s', strtotime($input['start_date'] . ' ' . ($input['start_hour'] . ':' . $input['start_minutes'] . ':00'))),
            'arrival_date' => date('Y-m-d H:i:s', strtotime($input['arrival_date'] . ' ' . ($input['arrival_hour'] . ':' . $input['arrival_minutes'] . ':00'))),
        ];
        $p_trip->update($p_trip_input);
    }

    /**
     * Deletes a partial trip from the DB.
     *
     * @param $main_trip_id - the id of the main trip for the certain partial trip
     * @param $route        - the "route_to" value
     */
    public static function deletePartialTrip($main_trip_id, $route)
    {
        $trip_id = Trip::whereParentTripId($main_trip_id)->whereRouteTo($route)->first()->id;
        if ($trip_id) {
            Trip::destroy($trip_id);
        }
    }

    /**
     * Separates the city from the country, given from the input route value,
     * and puts them into array with the following structure:
     * routes [
     *      'route' => "city name",
     *      'country' => "country name"
     * ]
     *
     * @param string $input The string containing the city and country.
     *                      Looks like this: "City, Country"
     *
     * @return array $routes
     */
    public static function separateSingleRouteFromCountry($input)
    {
        $routes = [];

        $route_country = explode(',', $input);
        $routes['route'] = $route_country[0];
        $routes['country'] = $route_country[1];

        return $routes;
    }

    /**
     * Given the input array from the client-side, separates the cities and countries
     * for both the origin and destination points of the trip.
     *
     * @param array $input
     *
     * @return array $routes
     */
    public static function separateRoutesFromCountriesInput($input)
    {
        $routes = [];

        $route_country_from = explode(',', $input['route_from']);
        $routes['route_from'] = $route_country_from[0];
        $routes['country_from'] = $route_country_from[1];

        $route_country_to = explode(',', $input['route_to']);
        $routes['route_to'] = $route_country_to[0];
        $routes['country_to'] = $route_country_to[1];

        return $routes;
    }
}
