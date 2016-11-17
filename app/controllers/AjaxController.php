<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class AjaxController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => 'post']);
    }

    /***
     * Handler for the ajax request made from homepage_teaser.js to get 10 recent trips from the database.
     *
     * @return A compiled view with the data filled in to be placed in the containing div.
     */
    public function getTeaser()
    {
        if (Request::ajax()) {
            $trips = Trip::where('start_date', '>=', date('Y-m-d H:i:s'))->take(10)->get();
            if (Request::Ajax()) {
                foreach ($trips as $trip) {
                    $trip['driver'] = User::find($trip->driver_user_id);
                }
            }
            if (count($trips) < 1) {
                return View::make('teaser');
            }

            return View::make('teaser')->with('trips', $trips);
        } else {
            return Redirect::to('/');
        }
    }

    public function postLogin()
    {
        if (Request::ajax()) {

            $email = Input::get('email');
            $password = Input::get('password');

            $logged_in = Auth::attempt(['email' => $email, 'password' => $password]);
            $response = [
                'status' => 'error',
                'msg'    => 'email/password incorrect',
            ];

            if ($logged_in) {
                $response = [
                    'status' => 'success',
                    'msg'    => 'Welcome.',
                ];
            }

            return Response::Json($response);
        } else {
            return Redirect::back();
        }
    }

    public function uploadProfilePic()
    {
        if (Request::ajax()) {

            $response = [
                'msg'   => 'success',
                'input' => Input::all()
            ];

            return Response::Json($response);;
        } else {
            return Redirect::back();
        }
    }
}