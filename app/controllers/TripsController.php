<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Laracasts\Utilities\JavaScript\Facades\JavaScript;
use Trips\TripsProvider as TripsProvider;

class TripsController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => 'post']);
    }

    /**
     * Display a listing of the trips.
     *
     * @return View with trips listed.
     */
    public function index()
    {
        $trips = TripsProvider::getTripsListing();
        foreach ($trips as $trip) {
            $trip['date'] = date('d M Y', strtotime($trip['start_date']));
            $trip['time'] = date('G:i', strtotime($trip['start_date']));
        }

        return View::make('trips.trip_list')
            ->with('trips', $trips);
    }

    /**
     * Show the form for creating a new trip.
     *
     * @return Redirect to view to create a trip
     */
    public function create()
    {
        if (Auth::check()) {
            if ( ! Auth::user()->active) {
                return View::make('trips.offer_trip');
            }
            $has_vehicle = true;
            $seats = [];
            $vehicle = Vehicle::whereUserId(Auth::user()->id)->select('seats')->first();
            if ( ! $vehicle) {
                $has_vehicle = false;
            } else {
                for ($i = 1; $i <= $vehicle->seats; $i ++) {
                    $seats[ $i ] = $i;
                }
            }

            /* Send empty partial_trips object to the client-side JS */
            JavaScript::put(['partial_trips' => null]);

            return View::make('trips.offer_trip')
                ->with('has_vehicle', $has_vehicle)
                ->with('seats', $seats);
        }

        return Redirect::route('home');
    }

    /**
     * Store a newly created trip in DB.
     *
     * @return Response
     * TODO -> assign kilometers dynamically, after Google Maps API is implemented - take the distance from there.
     */
    public function store()
    {
        $trip_id = null;
        $input = Input::all();
        $input = array_merge($input, TripsProvider::separateRoutesFromCountriesInput($input));
        if ( ! Trip::isValid($input)) {
            return Redirect::back()->withInput()->withErrors(Trip::$error_messages);
        } else {
            $trip = new Trip();
            $trip->unguard();
            $trip->fill([
                'route_from'       => $input['route_from'],
                'country_from'     => $input['country_from'],
                'route_to'         => $input['route_to'],
                'country_to'       => $input['country_to'],
                'start_date'       => date('Y-m-d H:i:s', strtotime($input['start_date'] . ' ' . ($input['start_hour'] . ':' . $input['start_minutes'] . ':00'))),
                'km'               => $input['distance'],
                'status'           => 1,
                'smoking_allowed'  => array_key_exists('smoking_allowed', $input),
                'chat_allowed'     => array_key_exists('chat_allowed', $input),
                'music_allowed'    => array_key_exists('music_allowed', $input),
                'children_allowed' => array_key_exists('children_allowed', $input),
                'animals_allowed'  => array_key_exists('animals_allowed', $input),
                'price'            => $input['price'],
                'luggage_size'     => $input['luggage'],
                'trip_type'        => 'STANDARD',
                'additional_info'  => $input['additional_info'],
                'seats_total'      => $input['seats'],
                'driver_user_id'   => Auth::user()->id
            ]);
            $trip->reguard();
            $trip->save();

            $partial_trips = TripsProvider::mapRouteToPriceForStops($input);
            foreach ($partial_trips as $route => $price) {
                TripsProvider::storePartialTrip($trip, $route, $price);
            }
        }

        return Redirect::route('trips.show', ['id' => $trip->id]);
    }

    /**
     * Display the specified trip.
     *
     * @param  int $id
     *
     * @return Redirect to view of trip with specified id
     */
    public function show($id)
    {
        $trip = Trip::find($id);
        if ( ! $trip) {
            return Redirect::route('wrong-page');
        }
        $trip['date'] = date('d M Y', strtotime($trip['start_date']));
        $trip['time'] = date('G:i', strtotime($trip['start_date']));
        $passenger_ids = [];
        $passengers = Passenger::whereTripId($id)->get();
        foreach ($passengers as $passenger) {
            $passenger_ids[] = $passenger->user_id;
        }

        $driver = User::find($trip->driver_user_id);
        $driver['age'] = User::calculateAge($driver->birthdate);

        $vehicle = Vehicle::whereUserId($driver->id)->first();

        $partial_trips = Trip::whereParentTripId($id)->select('id')->get();

        return View::make('trips.trip')
            ->with('trip', $trip)
            ->with('driver', $driver)
            ->with('vehicle', $vehicle)
            ->with('passengers', $passenger_ids)
            ->with('partial_trips', $partial_trips);
    }

    /**
     * Show the form for editing the specified trip.
     *
     * @param  int $id
     *
     * @return Redirect to view for editing the specified trip
     */
    public function edit($id)
    {
        if (Auth::check()) {
            $trip = Trip::find($id);
            if (Auth::id() == $trip->driver_user_id) {
                $partial_trips = Trip::whereParentTripId($id)->get();
                $seats = [];
                $has_vehicle = false;
                $vehicle = Vehicle::whereUserId(Auth::user()->id)->select('seats')->first();
                $trip['date'] = date('Y-m-d', strtotime($trip['start_date']));
                $trip['time_hours'] = date('G', strtotime($trip['start_date']));
                $trip['time_minutes'] = date('i', strtotime($trip['start_date']));
                if ($vehicle) {
                    $has_vehicle = true;
                    for ($i = 1; $i <= $vehicle->seats; $i ++) {
                        $seats[ $i ] = $i;
                    }
                }

                /* Send the partial_trips object to the client-side JS */
                JavaScript::put(['partial_trips' => $partial_trips]);

                return View::make('trips.edit_trip')
                    ->with('trip', $trip)
                    ->with('seats', $seats)
                    ->with('has_vehicle', $has_vehicle);
            }

            return Redirect::route('trips.index');
        }

        return Redirect::route('trips.index');
    }

    /**
     * Update the specified trip with the changes input in the view.
     * Also update its partial trips, if they exist, OTHERWISE create new partial trips, for the certain main trip.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();
        $routes = TripsProvider::separateRoutesFromCountriesInput($input);
        $input['route_from'] = $routes['route_from'];
        $input['country_from'] = $routes['country_from'];
        $input['route_to'] = $routes['route_to'];
        $input['country_to'] = $routes['country_to'];
        if ( ! Trip::isValid($input)) {
            return Redirect::back()->withInput()->withErrors(Trip::$error_messages);
        } else {
            $trip = Trip::find($id);
            if ( ! $trip) {
                return Redirect::back();
            }
            $trip->route_from = $routes['route_from'];
            $trip->country_from = $routes['country_from'];
            $trip->route_to = $routes['route_to'];
            $trip->country_to = $routes['country_to'];
            $trip->start_date = date('Y-m-d H:i:s', strtotime($input['start_date'] . ' ' . ($input['start_hour'] . ':' . $input['start_minutes'] . ':00')));
            $trip->km = $input['distance'];
            $trip->status = 1;
            $trip->women_only = array_key_exists('women_only', $input);
            $trip->smoking_allowed = array_key_exists('smoking_allowed', $input);
            $trip->chat_allowed = array_key_exists('chat_allowed', $input);
            $trip->music_allowed = array_key_exists('music_allowed', $input);
            $trip->children_allowed = array_key_exists('children_allowed', $input);
            $trip->animals_allowed = array_key_exists('animals_allowed', $input);
            $trip->price = $input['price'];
            $trip->luggage_size = $input['luggage'];
            $trip->trip_type = 'STANDARD';
            $trip->additional_info = $input['additional_info'];
            $trip->seats_total = $input['seats'];
            $trip->update();

            $partial_trips = TripsProvider::decideToStoreUpdateDeletePartialTrip($id, $input);
            foreach ($partial_trips as $p_trip) {
                switch ($p_trip['action']) {
                    case 'update':
                        TripsProvider::updatePartialTrip($id, $p_trip['route'], $p_trip['price'], $input);
                        break;
                    case 'store':
                        TripsProvider::storePartialTrip($trip, $p_trip['route'], $p_trip['price']);
                        break;
                    case 'delete':
                        TripsProvider::deletePartialTrip($id, $p_trip['route']);
                        break;
                }
            }
        }

        return Redirect::route('trips.show', ['id' => $trip->id]);
    }

    /**
     * Remove the specified trip from DB.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        Trip::destroy($id);

        return Redirect::route('account.trips');
    }

    /**
     * Stores a row in the 'trips_passengers' entity, as this is the user who applied for the certain trip.
     *
     * @param int $trip_id - the id of the trip to be applied for
     * @param int $user_id - the id of the user who is applying for the trip (NOT the creator of the trip)
     *
     * @return redirect back to the trip's page
     */
    public function applyForTrip($trip_id, $user_id)
    {
        $passenger_exists = Passenger::whereTripId($trip_id)->whereUserId($user_id)->exists();
        if ( ! $passenger_exists) {
            $trip = Trip::find($trip_id);
            if ($trip->seats_taken < $trip->seats_total) {
                $passenger = new Passenger();
                $passenger->trip_id = $trip_id;
                $passenger->user_id = $user_id;
                $passenger->save();

                $trip->seats_taken = $trip->seats_taken + 1;
                $trip->update();

                //Send notification email to driver that a passenger has joined his trip
                $passenger = Auth::user();
                $driver = User::find($trip->driver_user_id);

                Mail::send('emails.notifications.joined_trip', [
                    'trip_link'      => URL::route('trips.show', $trip->id),
                    'passenger_link' => URL::route('account.show', $passenger->id),
                    'trip'           => $trip,
                    'driver'         => $driver,
                    'passenger'      => $passenger
                ],
                    function ($message) use ($driver, $passenger) {
                        $message->to($driver->email, $driver->name)->subject('Road2home - ' . $passenger->name . ' ' . $passenger->surname . ' joined your trip');
                    });

                //Send notification email to passenger about the trip they have joined
                Mail::send('emails.notifications.applicant_joined_trip', [
                    'trip_link'   => URL::route('trips.show', $trip->id),
                    'driver_link' => URL::route('account.show', $driver->id),
                    'trip'        => $trip,
                    'driver'      => $driver,
                    'passenger'   => $passenger
                ],
                    function ($message) use ($driver, $passenger) {
                        $message->to($passenger->email, $passenger->name)->subject('Road2home - You have joined a trip.');
                    });
            }
        }

        // TODO -> add messages "success/failure" type, to show up in a fade-in/out modal, after applying
        return Redirect::back();
    }


    /**
     * Removes a row from the 'trips_passengers' entity, as this is the user who resigned from the certain trip.
     *
     * @param int $trip_id - the id of the trip to resign from
     * @param int $user_id - the id of the user who is resigning for the trip (NOT the creator of the trip)
     *
     * @return redirect back to the trip's page
     */
    public function resignFromTrip($trip_id, $user_id)
    {
        $passenger_id = Passenger::whereTripId($trip_id)->whereUserId($user_id)->first()->id;
        if ($passenger_id) {
            Passenger::destroy($passenger_id);
            $trip = Trip::find($trip_id);
            $trip->seats_taken = $trip->seats_taken - 1;
            $trip->update();

            $passenger = Auth::user();
            $driver = User::find($trip->driver_user_id);

            Mail::send('emails.notifications.resigned_trip', [
                'trip_link'      => URL::route('trips.show', $trip->id),
                'passenger_link' => URL::route('account.show', $passenger->id),
                'trip'           => $trip,
                'driver'         => $driver,
                'passenger'      => $passenger
            ],
                function ($message) use ($driver, $passenger) {
                    $message->to($driver->email, $driver->name)->subject('Road2home - ' . $passenger->name . ' ' . $passenger->surname . ' resigned from your trip');
                });

            //Send notification email to passenger about the trip they have joined
            Mail::send('emails.notifications.applicant_resigned_trip', [
                'trip_link'   => URL::route('trips.show', $trip->id),
                'driver_link' => URL::route('account.show', $driver->id),
                'trip'        => $trip,
                'driver'      => $driver,
                'passenger'   => $passenger
            ],
                function ($message) use ($driver, $passenger) {
                    $message->to($passenger->email, $passenger->name)->subject('Road2home - You have resigned from a trip.');
                });
        }

        // TODO -> add messages "success/failure" type, to show up in a fade-in/out modal, after resigning
        return Redirect::back();
    }
}
