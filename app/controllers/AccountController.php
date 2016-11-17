<?php

use Account\AccountProvider as AccountProvider;

class AccountController extends BaseController {

////
//
//
//
//                  ________________________________________________________
//                  |                                                      | -------
//             /    |           SOME                                       |        ------------
//            /---, |                GOOD ASS QUALITY CODE                 |   ---
//       -----# ==| |                                       BABY           |        -----
//       | :) # ==| |                                                      |---
//  -----'----#   | |______________________________________________________|  --------------------
//  |)___()  '#   |______====____   \___________________________________|
// [_/,-,\"--"------ //,-,  ,-,\\\   |/             //,-,  ,-,  ,-,\\ __#
//   ( 0 )|===******||( 0 )( 0 )||-  o              '( 0 )( 0 )( 0 )||
//----'-'--------------'-'--'-'-----------------------'-'--'-'--'-'--------------

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => 'post']);
    }

    /**
     * @return Creates and redirects to view for registration.
     */
    public function create()
    {
        if (Auth::check()) {
            return Redirect::route('account.myprofile');
        }
        $universities = University::all();
        $universities_names = [];
        foreach ($universities as $uni) {
            $universities_names [ $uni['initials'] ] = $uni['name'];
        }

        return View::make('account.register')
            ->with('universities_names', $universities_names);
    }

    /**
     * Handles the creation of new user:
     * 1. Check if input fields values pass validation rules
     * 2. Check if email is not already taken
     * 3. Create user entity and save to DB
     * 4. Send message to user's email, with URL for confirmation of account
     *
     * @return Redirects to home page.
     */
    public function store()
    {
        $input = Input::all();
        if ( ! User::isValid($input, true)) {
            return Redirect::back()->withInput()->withErrors(User::$error_messages);
        } else {
            $university = University::whereInitials($input['university'])->select('id', 'domain')->first();
            $domain = $university->domain;
            $university_id = $university->id;
            if ( ! User::isValidEmail(['email' => $input['email'] . '@' . $domain])) {
                return Redirect::back()->withInput()->withErrors(User::$error_messages);
            }
            $activation_code = str_random(60);
            $user = User::create([
                'email'           => $input['email'] . '@' . $domain,
                'password'        => Hash::make($input['password']),
                'name'            => $input['name'],
                'surname'         => $input['surname'],
                'bio'             => $input['bio'],
                'birthdate'       => $input['birthdate'],
                'gender'          => $input['gender'],
                'university'      => $university_id,
                'phone_number'    => $input['country_code'] . $input['phone_number'],
                'driving_style'   => $input['driving_style'],
                'smoker'          => (int)$input['smoker'],
                'activation_code' => $activation_code
            ]);
            if ($user) {
                Auth::attempt(['email' => $input['email'] . '@' . $domain, 'password' => $input['password']]);
                $this->sendActivate();
            }

            return Redirect::route('home');
        }
    }

    /**
     * Sends an email to the provided user, with activation link to confirm the user's account validity
     *
     * @return Redirect back to last visited page
     */
    public function sendActivate()
    {
        if (Auth::check()) {
            $user = Auth::user();
            Mail::send('emails.auth.confirm_email', [
                'link'  => URL::route('account.activate', $user->activation_code),
                'name'  => $user->name,
                'email' => $user->email
            ], function ($message) use ($user) {
                $message->to($user->email, $user->name)->subject('Road2home - Account confirmation');
            });

            return Redirect::back();
        }
    }

    /**
     * Sets a certain user (found by the activation code provided) to be active.
     *
     * @param $activation_code [string] - The activation code sent as a link to the user's email,
     *                         needed for activating the user's account.
     *
     * @return redirect to the home page
     */
    public function getActivate($activation_code)
    {
        $user = User::whereActivationCode($activation_code)->whereActive('0')->first();
        if ( ! $user) {
            return Redirect::to('/');
        }
        if ($user->count()) {
            $user->active = 1;
            $user->activation_code = '';
            $user->save();

            if ( ! Auth::check()) {
                return Redirect::to('/');
            } else {
                Auth::attempt(['email' => $user->email, 'password' => $user->password]);

                return Redirect::route('account.editAccount', $user->id);
            }
        }
    }

    /**
     * Redirects to user's profile page, if logged in.
     * Otherwise - redirect to 'home'
     *
     * @return Redirect to personal page or home.
     */
    public function getPersonalProfile()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->age = User::calculateAge($user->birthdate);
            $university = University::whereId($user->university)->select('name')->get()->first();
            $user->university = $university->name;

            return View::make('account.personal_profile')->with('user', $user);
        }

        return Redirect::route('home');
    }

    /**
     * Finds the user, by given ID, creates and redirects to its view.
     *
     * @param $id - the ID of the user to display
     *
     * @return Redirect to view of visit someone's profile
     */
    public function show($id)
    {
        if ( ! isset($id) || is_null($id) || ! is_numeric($id)) {
            return Redirect::route('wrong-page');
        }
        $user = User::find($id);
        if ( ! $user) {
            return Redirect::route('wrong-page');
        }
        $university = University::whereId($user->university)->select('name')->get()->first();
        $user->university = $university->name;
        $user->age = User::calculateAge($user->birthdate);

        return View::make('account.visit_profile')->with('user', $user);
    }

    /**
     * Loads the page for editing one's profile, if the user is logged and if
     * the ID parameter given in the URL is the same as the currently logged user,
     * to prevent tries for loading someone else's profile page.
     * If ID parameter, given in URL, differs, then redirect to this action with
     * the currently logged user's ID.
     *
     * @param $id - the ID of the user, whose profile to display
     *
     * @return View with page to edit one's profile
     */
    public function edit($id)
    {
        if (Auth::check()) {
            if (Auth::id() != $id) {
                return Redirect::route('account.edit', ['id' => Auth::id()]);
            }
            $user = Auth::user();
            $university = University::whereId($user->university)->select('name')->get()->first();
            $user->university = $university->name;

            return View::make('account.edit_profile')
                ->with('user', $user);
        }

        return Redirect::route('home');
    }

    /**
     * Check if the request is for deleting a vehicle. If yes, delete said vehicle, else:
     * Update the User model and the related to it Vehicles and redirect back to MyProfile
     * (gonna be changed to ajax response, so no redirect is necessary)
     *
     * @param $id - the ID of the user to update
     *
     * @return Redirect to the user's personal page view
     */
    public function update($id)
    {
        $deleteVehicle = Input::get('delete_vehicle', null);
        if ( ! is_null($deleteVehicle)) {
            $vehicleUser = Auth::user();

            Vehicle::find($deleteVehicle)->delete();

            return View::make('account.edit_profile')->with('user', $vehicleUser);
        } else {
            $user = Auth::user();
            $user_input = Input::except("Vehicles");
            $vehicle_input = Input::get("Vehicles");
            $user_input['smoker'] = (int)$user_input['smoker'];
            $user->update($user_input);

            if ($vehicle_input) {
                foreach ($vehicle_input as $id => $data) {
                    Vehicle::find($id)->update($data);

                    if (Input::hasFile('vehicle_' . $id)) {
                        AccountProvider::StoreVehiclePic($user, Input::File('vehicle_' . $id), $id);
                    }
                }
            }

            if (Input::hasFile('profile-pic')) {
                AccountProvider::StoreProfilePic($user, Input::File('profile-pic'));
            }

            return Redirect::route('account.edit');
        }
    }

    /**
     * Logs the user out.
     *
     * @return Redirect to home.
     */
    public function getLogout()
    {
        Auth::logout();
        Session::flush();

        return Redirect::route('home');
    }

    /**
     * If the user is logged in - get all trips with status = 1 (active),
     * that belong to that user, and pass them to the view.
     *
     * @return View with list of trips.
     */
    public function getPersonalTrips()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $trips_offered = Trip::whereDriverUserId($user->id)->where('start_date', '>=', date('Y-m-d H:i:s'))
                ->orderBy('start_date', 'DESC')->get();
            $trips_passengers = Passenger::whereUserId($user->id)->select('trip_id')->get();
            $trip_ids = [];
            foreach ($trips_passengers as $trip) {
                $trip_ids[] = $trip->trip_id;
            }
            $trips_joined = Trip::whereIn('id', $trip_ids)->where('start_date', '>=', date('Y-m-d H:i:s'))
                ->orderBy('start_date', 'DESC')->get();

            foreach ($trips_offered as $trip) {
                $trip['date'] = date('d M Y', strtotime($trip['start_date']));
                $trip['time'] = date('G:i', strtotime($trip['start_date']));
            }
            foreach ($trips_joined as $trip) {
                $trip['date'] = date('d M Y', strtotime($trip['start_date']));
                $trip['time'] = date('G:i', strtotime($trip['start_date']));
            }

            return View::make('trips.personal_trips')
                ->with('trips_offered', $trips_offered)
                ->with('trips_joined', $trips_joined);
        }

        return Redirect::route('home');
    }

    /**
     * @param $id
     *
     * @return View with editable information fields directly about the account
     */
    public function getEditAccount($id)
    {
        if (Auth::id() != $id) {
            return Redirect::route('account.editAccount', ['id' => Auth::id()]);
        }

        return View::make('account.edit_account')->with('user', Auth::user());
    }

    /***
     * Gets the input data from the new vehicle modal window and saves it as a new vehicle for the given user.
     *
     * @return mixed the edit profile view including the new vehicle.
     */
    public function saveNewVehicle()
    {
        $vehicleUser = Auth::user();
        if (Input::all()) {
            $newVehicle = new Vehicle();

            $newVehicle->make = Input::get('make');
            $newVehicle->model = Input::get('model');
            $newVehicle->year = Input::get('year');
            $newVehicle->seats = Input::get('seats');
            $newVehicle->type = Input::get('type');
            $newVehicle->color = Input::get('color');
            $newVehicle->user_id = $vehicleUser->id;

            $newVehicle->save();

            if (Input::hasFile('vehicle_new_pic')) {
                AccountProvider::StoreVehiclePic($vehicleUser, Input::File('vehicle_new_pic'), $newVehicle->id);
            }

        }

        return Redirect::route('account.edit');
    }
}