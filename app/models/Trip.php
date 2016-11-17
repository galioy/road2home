<?php

use Illuminate\Support\Facades\Validator;

/**
 * Class Trip
 *
 * @property int      id
 * @property int      parent_trip_id
 * @property int      driver_user_id
 * @property int      return_trip_id
 * @property string   route_from
 * @property string   country_from
 * @property string   route_to
 * @property string   country_to
 * @property DateTime start_date
 * @property double   km
 * @property int      status
 * @property bool     smoking_allowed
 * @property bool     chat_allowed
 * @property bool     music_allowed
 * @property bool     children_allowed
 * @property bool     animals_allowed
 * @property int      price
 * @property string   luggage_size
 * @property string   trip_type
 * @property string   additional_info
 * @property int      seats_total
 * @property int      seats_taken
 */
class Trip extends \Eloquent {

    protected $table = 'trips';

    protected $hidden = [
        'id',
        'parent_trip_id',
        'driver_user_id',
        'return_trip_id'
    ];

    protected $fillable = [
        'route_from',
        'country_from',
        'route_to',
        'country_to',
        'start_date',
        'km',
        'status',
        'smoking_allowed',
        'chat_allowed',
        'music_allowed',
        'children_allowed',
        'animals_allowed',
        'price',
        'luggage_size',
        'trip_type',
        'additional_info',
        'seats_total',
        'seats_taken'
    ];

    /**
     * Rules for validation used in the trip creation.
     *
     * @var array
     */
    public static $rules_create = [
        'route_from'      => 'required|min:2',
        'country_from'    => 'required|min:2',
        'route_to'        => 'required|min:2',
        'country_to'      => 'required|min:2',
        'start_date'      => 'required',
        'price'           => 'required|integer|min:2',
        'additional_info' => 'required|min:50|max:150',
    ];

    /**
     * Container for the error messages generated from the Validator
     * in case validation has not passed.
     *
     * @var
     */
    public static $error_messages;

    /***
     * User related to this entity.
     *
     * @return [object][User object related to this trip, based on the foreign key relation.]
     */
    public function ReturnTrip()
    {
        return $this->hasOne('Trip', 'return_trip_id', 'id');
    }

    public function TripPassengers()
    {
        return $this->hasMany('Passenger', 'user_id');
    }

    /**
     * Conducts a validation against the given rules for registration or login.
     * If validation does not pass - generate error messages.
     *
     * @param $input      - the input data, to be validated, passed from the fields
     *                    registration; "false" if for login
     *
     * @return bool - "true" if validation has passed; "false" otherwise.
     */
    public static function isValid($input)
    {
        $validation = Validator::make($input, static::$rules_create);

        if ($validation->passes()) {
            return true;
        }

        static::$error_messages = $validation->messages();

        return false;
    }
}