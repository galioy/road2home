<?php

class Vehicle extends Eloquent {

    protected $table = 'vehicles';

    protected $hidden = [
        'id',
        'user_id'
    ];

    protected $fillable = [
        'color',
        'make',
        'model',
        'seats',
        'type',
        'year'
    ];

    /**
     * Rules for validation used in the registration form.
     *
     * @var array
     */
    public static $rules_register = [
        'make'  => 'required|alpha_num',
        'model' => 'required|alpha_num',
        'seats' => 'required|integer|min:1|max:8',
        'type'  => 'required|alpha',
    ];

    /**
     * Container for the error messages generated from the Validator
     * in case validation has not passed.
     *
     * @var
     */
    public static $error_messages;


    /**
     * Conducts a validation against the given rules for registration of a vehicle.
     * If validation does not pass - generate error messages.
     *
     * @param $input - the input data, to be validated, passed from the fields
     *
     * @return bool - "true" if validation has passed; "false" otherwise.
     */
    public static function isValid($input)
    {
        $validation = Validator::make($input, static::$rules_register);

        if ($validation->passes()) {
            return true;
        }
        static::$error_messages = $validation->messages();

        return false;
    }
}