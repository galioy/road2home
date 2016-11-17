<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'password',
        'password_temp',
        'active'
    ];

    protected $fillable = [
        'email',
        'password',
        'name',
        'surname',
        'bio',
        'birthdate',
        'gender',
        'driving_style',
        'smoker',
        'university',
        'phone_number',
        'activation_code'
    ];

    /***
     * Vehicles related to this entity.
     *
     * @return [array][Vehicles related to this user, based on the foreign key relation.]
     */
    public function Vehicles()
    {
        return $this->hasMany('Vehicle', 'user_id');
    }

    /***
     * Trips related to this entity.
     *
     * @return [array][Trips related to this user, based on the foreign key relation.]
     */
    public function Trips()
    {
        return $this->hasMany('Trip');
    }

    public function PartialTrips()
    {
        return $this->hasMany('PartialTrip', 'driver_user_id');
    }

    public function TripPassenger()
    {
        return $this->hasOne('Passenger', 'user_id');
    }

    public function university()
    {
        return $this->hasOne('University');
    }

    /**
     * Rules for validation used in the registration form.
     *
     * @var array
     */
    public static $rules_register = [
        'email'           => 'required|alpha_num|min:6|max:6',
        'password'        => 'required|min:6',
        'password_repeat' => 'required|same:password',
        'name'            => 'required|alpha|min:2|max:20',
        'surname'         => 'required|alpha|min:2|max:20',
        'bio'             => 'required|min:20|max:150',
        'birthdate'       => 'required',
        'gender'          => 'required',
        'smoker'          => 'required',
        'university'      => 'required|alpha',
        'phone_number'    => 'required|integer'
    ];

    /**
     * Rules for validation used in the login form.
     *
     * @var array
     */
    public static $rules_login = [
        'email'    => 'required|email',
        'password' => 'required|min:6'
    ];

    /**
     * Container for the error messages generated from the Validator
     * in case validation has not passed.
     *
     * @var
     */
    public static $error_messages;


    /**
     * Conducts a validation against the given rules for registration or login.
     * If validation does not pass - generate error messages.
     *
     * @param $input      - the input data, to be validated, passed from the fields
     * @param $isRegister - "true" if validation has to be made against the rules for
     *                    registration; "false" if for login
     *
     * @return bool - "true" if validation has passed; "false" otherwise.
     */
    public static function isValid($input, $isRegister)
    {
        if ($isRegister) {
            $validation = Validator::make($input, static::$rules_register);
        } else {
            $validation = Validator::make($input, static::$rules_login);
        }

        if ($validation->passes()) {
            return true;
        }

        static::$error_messages = $validation->messages();

        return false;
    }


    /**
     * Conducts a validation for the Email field only.
     * Checks for the full format of an email ("email@domain"), but not just the email prefix.
     *
     * @param $input - the value of the Email input field + the domain "@via.dk"
     *
     * @return bool - "true" if validation passes; "false" otherwise.
     */
    public static function isValidEmail($input)
    {
        $validation = Validator::make($input, ['email' => 'unique:users,email']);
        if ($validation->passes()) {
            return true;
        }
        static::$error_messages = $validation->messages();

        return false;
    }

    /**
     * Calculates the age, upon the given birth date.
     *
     * @param $birthdate - string [YYYY-MM-DD]
     *
     * @return int - the age, calculated from the birth date until the present day
     */
    public static function calculateAge($birthdate)
    {
        $from = new DateTime($birthdate);
        $to = new DateTime('today');

        return $from->diff($to)->y;
    }
}
